<?php
include_once('../server/db.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === "GET") {
    $tenantID = intval($_GET['tenantID']); // tenantID passed from AJAX

    // SQL query to select charges grouped by dueDate for the given tenant
    $sql = "
        SELECT 
            c.dueDate, 
            GROUP_CONCAT(c.chargeType ORDER BY c.chargeType SEPARATOR '<br>') AS chargeTypes, 
            GROUP_CONCAT(c.chargeAmount ORDER BY c.chargeType SEPARATOR '<br>') AS amounts, 
            SUM(c.chargeAmount) AS totalAmount,
            COALESCE((SELECT SUM(pd.paymentAmount) FROM tblPaymentDetails pd WHERE pd.tenantID = ? AND pd.paymentDate < c.dueDate), 0) AS totalPayments,
            COALESCE((SELECT SUM(pd.paymentAmount) FROM tblPaymentDetails pd WHERE pd.tenantID = ?), 0) AS totalPaymentAmount,
            SUM(c.chargeAmount) - COALESCE((SELECT SUM(pd.paymentAmount) FROM tblPaymentDetails pd WHERE pd.tenantID = ?), 0) AS remainingBalance,
            c.tenantID
        FROM 
            tblCharges c
        WHERE 
            c.tenantID = ?
        GROUP BY 
            c.dueDate;
    ";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo json_encode(["status" => "error", "message" => "SQL prepare failed: " . $conn->error]);
        exit;
    }

    // Bind parameters (4 instances of tenantID)
    $stmt->bind_param("iiii", $tenantID, $tenantID, $tenantID, $tenantID);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $data = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Format the charge types and amounts
                $row['chargeTypes'] = '<ul><li>' . str_replace('<br>', '</li><li>', $row['chargeTypes']) . '</li></ul>';
                $row['amounts'] = '<ul><li>' . str_replace('<br>', '</li><li>', $row['amounts']) . '</li></ul>';
                $data[] = $row;
            }
            echo json_encode(["status" => "success", "data" => $data]);
        } else {
            echo json_encode(["status" => "success", "data" => []]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Error executing query: " . $stmt->error]);
    }

    $stmt->close();
} else if ($requestMethod === "POST") {
    if (isset($_POST['amount']) && isset($_POST['paymentDate']) && isset($_POST['dueDate']) && isset($_POST['tenantID'])) {
        $amount = $_POST['amount'];
        $paymentDate = $_POST['paymentDate'];
        $dueDate = $_POST['dueDate'];
        $tenantID = $_POST['tenantID']; // Ensure tenantID is passed as well

        // Insert the payment
        $sql = "INSERT INTO tblPaymentDetails(paymentAmount, paymentDate, tenantID) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $amount, $paymentDate, $tenantID);

        if ($stmt->execute()) {
            // Get total charges for the tenant
            $sql = "SELECT SUM(chargeAmount) AS totalCharges FROM tblCharges WHERE tenantID = ? AND dueDate = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $tenantID, $dueDate);
            $stmt->execute();
            $result = $stmt->get_result();
            $totalChargesRow = $result->fetch_assoc();
            $totalCharges = $totalChargesRow['totalCharges'] ?? 0;

            // Get total amount paid before the specific payment date
            $sql = "SELECT SUM(paymentAmount) AS totalAmountPaid FROM tblPaymentDetails WHERE tenantID = ? AND paymentDate < ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $tenantID, $paymentDate);
            $stmt->execute();
            $result = $stmt->get_result();
            $totalAmountPaidRow = $result->fetch_assoc();
            $totalAmountPaid = $totalAmountPaidRow['totalAmountPaid'] ?? 0;

            // Calculate remaining balance
            $balance = $totalCharges - $totalAmountPaid;

            // Fetch charges and payment details for the tenant
            $sql = "SELECT tblCharges.*, tblPaymentDetails.* FROM tblCharges INNER JOIN tblPaymentDetails ON tblCharges.tenantID = tblPaymentDetails.tenantID WHERE tblCharges.tenantID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $tenantID);
            $stmt->execute();
            $selectResult = $stmt->get_result();
            
            if ($selectResult) {
                $data = array();
                if ($selectResult->num_rows > 0) {
                    while ($row = $selectResult->fetch_assoc()) {
                        $data[] = $row;
                    }
                }
                // Return successful response
                echo json_encode([
                    "status" => "success", 
                    "message" => "Payment Added", 
                    "data" => $data, 
                    "balance" => $balance
                ]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error retrieving charge details: " . $conn->error]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Payment insertion failed: " . $stmt->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Error: Payment amount, payment date, due date, or tenantID not set."]);
    }
}

?>
