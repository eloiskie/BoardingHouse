<?php
include_once('../server/db.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === "GET") {
    if (isset($_GET['tenant'])) {
        // SQL query to get tenant data, including room fee, total charges, total payments, and remaining balance
        $sql = "
        SELECT 
            tblTenant.tenantName,
            tblTenant.tenantID,
            tblhouse.houselocation,
            tblRoom.roomNumber,
            tblRoom.roomfee,
            IFNULL(SUM(tblCharges.chargeAmount), 0) AS totalCharges, 
            IFNULL((
                SELECT SUM(tblPaymentDetails.paymentAmount)
                FROM tblPaymentDetails
                WHERE tblPaymentDetails.tenantID = tblTenant.tenantID
            ), 0) AS totalPayments,
            (IFNULL(SUM(tblCharges.chargeAmount), 0) - IFNULL((
                SELECT SUM(tblPaymentDetails.paymentAmount)
                FROM tblPaymentDetails
                WHERE tblPaymentDetails.tenantID = tblTenant.tenantID
            ), 0)) AS remainingBalance  
        FROM 
            tblRoom
        JOIN 
            tblTenant ON tblTenant.roomID = tblRoom.roomID
        JOIN 
            tblhouse ON tblRoom.houseID = tblhouse.houseID
        LEFT JOIN 
            tblCharges ON tblCharges.tenantID = tblTenant.tenantID  
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

        if ($result) {
            $data = array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }
            echo json_encode(["status" => "success", "data" => $data]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
        }
    } else {
        // Fetch all tenant IDs and names
        $sql = "SELECT tenantID, tenantName FROM tblTenant";
        $result = $conn->query($sql);

        if ($result) {
            $data = array();
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
} elseif ($requestMethod === "POST") {
    // Retrieve POST data
    $chargeTypes = $_POST['chargeTypes'];
    $amounts = $_POST['amounts'];
    $dueDate = $_POST['dueDate'];
    $tenantID = $_POST['tenantID'];

    // Prepare the insert statement
    $stmt = $conn->prepare("INSERT INTO tblcharges (chargeType, chargeAmount, dueDate, tenantID) VALUES (?, ?, ?, ?)");

    if ($stmt === false) {
        echo json_encode(["status" => "error", "message" => "Error preparing statement: " . $conn->error]);
        exit;
    }

    // Start a transaction
    $conn->begin_transaction();

    try {
        foreach ($chargeTypes as $i => $type) {
            $chargeType = $conn->real_escape_string($type);
            $amount = $conn->real_escape_string($amounts[$i]);

            $stmt->bind_param("sssi", $chargeType, $amount, $dueDate, $tenantID);

            if ($stmt->execute() === false) {
                throw new Exception("Error executing statement: " . $stmt->error);
            }
        }

        // Calculate the totalAmount for the tenant after inserting the charges
        $result = $conn->query("SELECT SUM(chargeAmount) as totalAmount FROM tblcharges WHERE tenantID = $tenantID");
        if ($result === false) {
            throw new Exception("Error calculating total amount: " . $conn->error);
        }

        $row = $result->fetch_assoc();
        $totalAmount = $row['totalAmount'];

        // Commit the transaction
        $conn->commit();
        echo json_encode([
            "status" => "success",
            "message" => "Charges inserted and total amount updated successfully",
            "totalAmount" => $totalAmount // Send back the total amount
        ]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }

    $stmt->close();
}
?>
