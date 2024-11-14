<?php
include_once('../server/db.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === "GET") {
    // Initialize an empty data array
    $data = [];


    if (isset($_GET['tenant'])) {
    // SQL query to get tenant data with remaining balance
    $sql = "
        SELECT 
                tblTenant.tenantName,
                tblTenant.tenantID,
                tblhouse.houselocation,
                tblRoom.roomNumber,
                tblRoom.roomfee,
                IFNULL(
                    (SELECT SUM(amount) 
                    FROM tblchargesDetails 
                    WHERE tblchargesDetails.tenantID = tblTenant.tenantID), 0) 
                    - IFNULL(
                        (SELECT SUM(paymentAmount) 
                        FROM tblpayments 
                        WHERE tblpayments.tenantID = tblTenant.tenantID), 0) 
                AS remainingBalance
        FROM 
            tblRoom
        JOIN 
            tblTenant ON tblTenant.roomID = tblRoom.roomID
        JOIN 
            tblhouse ON tblRoom.houseID = tblhouse.houseID
        WHERE 
            tblTenant.tenantStatus = 'active'
        GROUP BY 
            tblTenant.tenantName, 
            tblTenant.tenantID,
            tblhouse.houselocation, 
            tblRoom.roomNumber, 
            tblRoom.roomfee
        ORDER BY 
            tblTenant.tenantName;
    ";

    // Execute the query
    $result = $conn->query($sql);
    
    if ($result) {
        // Check if data is returned
        if ($result->num_rows > 0) {
            $data = [];
            // Fetch all data and store in $data array
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            // Return the data as a JSON response
            echo json_encode(["status" => "success", "data" => $data]);
        } else {
            // No data found
            echo json_encode(["status" => "success", "data" => []]);
        }
    } else {
        // Error executing query
        echo json_encode(["status" => "error", "message" => "Error executing query: " . $conn->error]);
    }
    }
    else if(isset($_GET['tenantName'])) {
        // Fetch all tenant IDs and names
        $sql = "SELECT 
                    tenantID, 
                    tenantName
                FROM tblTenant 
                WHERE tenantStatus = 'active'";
        $result = $conn->query($sql);
    
    // Handle the result
    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode(["status" => "success", "data" => $data]);
        } else {
            echo json_encode(["status" => "success", "data" => []]);
        }
    }
    }else if(isset($_GET['roomFee'])) {
    $tenantID = intval($_GET['tenantID']);

    // Ensure the tenantID is valid and exists
    if ($tenantID <= 0) {
        echo json_encode(["status" => "error", "message" => "Invalid tenant ID"]);
        exit();
    }

    // Query to fetch the room fee for the given tenant
    $query = "
    SELECT r.roomFee 
    FROM tblRoom r
    JOIN tbltenant t ON r.roomID = t.roomID
    WHERE t.tenantID = ?
    ";

    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        echo json_encode(["status" => "error", "message" => "Failed to prepare the statement"]);
        exit();
    }

    // Bind parameter (i = integer)
    $stmt->bind_param('i', $tenantID);

    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $data = null; // No data found
    }

    $stmt->close();
    $conn->close();

    // Return response in JSON format
    echo json_encode(["status" => "success", "data" => $data]);
    }


}
if ($requestMethod === "POST") {
    // Retrieve POST data
    if(isset($_POST['payment']) && !isset($_POST['query'])){
    $paymentTypes = isset($_POST['paymentTypes']) ? $_POST['paymentTypes'] : []; 
    $amounts = isset($_POST['amounts']) ? $_POST['amounts'] : []; 
    $dueDate = $_POST['dueDate'] ?? ''; 
    $tenantID = $_POST['tenantID'] ?? 0; 

    // Check if payment types and amounts are provided
    if (empty($paymentTypes) || empty($amounts)) {
        echo json_encode(["status" => "error", "message" => "Payment types and amounts must be provided."]);
        exit;
    }

    // Prepare the insert statement for tblchargesDetails
    $stmtGrouped = $conn->prepare("INSERT INTO tblchargesDetails (tenantID, paymentTypeID, amount, dueDate) VALUES (?, ?, ?, ?)");
    
    // Handle error if statement preparation fails
    if ($stmtGrouped === false) {
        echo json_encode(["status" => "error", "message" => "Error preparing grouped charges statement: " . $conn->error]);
        exit;
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        $totalGroupedAmount = 0;

        foreach ($paymentTypes as $i => $type) {
            $paymentType = $type;
            $amount = (float)$amounts[$i];

            // Check if the paymentType exists in tblpaymenttype
            $stmtCheck = $conn->prepare("SELECT paymentTypeID FROM tblpaymenttype WHERE paymentType = ?");
            
            // Handle error if statement preparation fails
            if ($stmtCheck === false) {
                throw new Exception("Error preparing payment type check: " . $conn->error);
            }

            $stmtCheck->bind_param("s", $paymentType);
            $stmtCheck->execute();
            $result = $stmtCheck->get_result();

            if ($result->num_rows === 0) {
                // If paymentType doesn't exist, insert it
                $insertCategory = $conn->prepare("INSERT INTO tblpaymenttype (paymentType) VALUES (?)");
                
                if ($insertCategory === false) {
                    throw new Exception("Error preparing insert for new payment type: " . $conn->error);
                }

                $insertCategory->bind_param("s", $paymentType);
                if (!$insertCategory->execute()) {
                    throw new Exception("Error inserting into tblpaymenttype: " . $insertCategory->error);
                }
                $paymentTypeID = $insertCategory->insert_id; 
                $insertCategory->close();
            } else {
                $row = $result->fetch_assoc();
                $paymentTypeID = $row['paymentTypeID'];
            }

            // Insert each charge
            $stmtGrouped->bind_param("iids", $tenantID, $paymentTypeID, $amount, $dueDate);
            if ($stmtGrouped->execute() === false) {
                throw new Exception("Error executing grouped charges statement: " . $stmtGrouped->error);
            }

            $totalGroupedAmount += $amount;
        }

        // Calculate total amount of charges for the tenant
        $stmtTotalCharges = $conn->prepare("SELECT SUM(amount) AS totalCharges FROM tblchargesDetails WHERE tenantID = ?");
        if ($stmtTotalCharges === false) {
            echo json_encode(["status" => "error", "message" => "Error preparing total charges statement: " . $conn->error]);
            exit;
        }
        $stmtTotalCharges->bind_param("i", $tenantID);
        $stmtTotalCharges->execute();
        $resultTotalCharges = $stmtTotalCharges->get_result();
        $rowCharges = $resultTotalCharges->fetch_assoc();
        $totalCharges = $rowCharges['totalCharges'] !== null ? (float)$rowCharges['totalCharges'] : 0;

        // Calculate total payments made by the tenant
        $stmtTotalPayments = $conn->prepare("SELECT SUM(paymentAmount) AS totalPayments FROM tblpayments WHERE tenantID = ?");
        if ($stmtTotalPayments === false) {
            echo json_encode(["status" => "error", "message" => "Error preparing total payments statement: " . $conn->error]);
            exit;
        }
        $stmtTotalPayments->bind_param("i", $tenantID);
        $stmtTotalPayments->execute();
        $resultTotalPayments = $stmtTotalPayments->get_result();
        $rowPayments = $resultTotalPayments->fetch_assoc();
        $totalPayments = $rowPayments['totalPayments'] !== null ? (float)$rowPayments['totalPayments'] : 0;

        // Calculate remaining balance
        $remainingBalance = $totalCharges - $totalPayments;

        // Commit the transaction
        $conn->commit();

        // Return JSON response including balance
        echo json_encode([
            "status" => "success",
            "message" => "Charges inserted and total amount updated successfully",
            "totalCharges" => $totalCharges,
            "totalPayments" => $totalPayments,
            "remainingBalance" => $remainingBalance
        ]);

    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }

    $stmtGrouped->close();
    }
    else if(isset($_POST['query'])) {
        $query = $_POST['query']; // Get the search query for active tenants
        $query = '%' . $query . '%'; // Add wildcards for LIKE query
    
        // Prepare the SQL query to filter active tenants based on the search query
        $sql = "SELECT 
                    t.tenantID, 
                    t.tenantName, 
                    t.phoneNumber, 
                    t.emailAddress, 
                    r.roomNumber, 
                    r.roomType, 
                    h.houselocation, 
                    t.tenantStatus,
                    IFNULL(
                        (SELECT SUM(amount) 
                        FROM tblchargesDetails 
                        WHERE tblchargesDetails.tenantID = t.tenantID), 0) 
                        - IFNULL(
                            (SELECT SUM(paymentAmount) 
                            FROM tblpayments 
                            WHERE tblpayments.tenantID = t.tenantID), 0) 
                    AS remainingBalance
                FROM 
                    tblTenant t
                JOIN 
                    tblRoom r ON t.roomID = r.roomID
                JOIN 
                    tblHouse h ON r.houseID = h.houseID
                WHERE 
                    (t.tenantName LIKE ? OR t.phoneNumber LIKE ? OR t.emailAddress LIKE ?) 
                    AND t.tenantStatus = 'active'
                ORDER BY 
                    t.tenantName;
                ";
    
        // Prepare and bind the parameters
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sss", $query, $query, $query);
    
            // Execute the query
            if ($stmt->execute()) {
                $result = $stmt->get_result();
    
                if ($result->num_rows > 0) {
                    // Fetch the data and return as JSON response
                    $data = [];
                    while ($row = $result->fetch_assoc()) {
                        $data[] = $row;
                    }
                    echo json_encode(["status" => "success", "data" => $data]);
                } else {
                    // No results found
                    echo json_encode(["status" => "success", "message" => "No tenants found."]);
                }
            } else {
                // Error executing query
                echo json_encode(["status" => "error", "message" => "Error executing query."]);
            }
    
            $stmt->close();
        } else {
            // Error preparing query
            echo json_encode(["status" => "error", "message" => "Error preparing query."]);
        }
}
}
?>