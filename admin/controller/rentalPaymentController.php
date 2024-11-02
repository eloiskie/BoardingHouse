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
            GROUP BY 
                tblTenant.tenantName, 
                tblTenant.tenantID,
                tblhouse.houselocation, 
                tblRoom.roomNumber, 
                tblRoom.roomfee
            ORDER BY 
                tblTenant.tenantName;
        ";

        $result = $conn->query($sql);
        
    } else {
        // Fetch all tenant IDs and names
        $sql = "SELECT tenantID, tenantName FROM tblTenant";
        $result = $conn->query($sql);
    }

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
    } else {
        echo json_encode(["status" => "error", "message" => "Error executing query: " . $conn->error]);
    }
}

if ($requestMethod === "POST") {
    // Retrieve POST data
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
?>