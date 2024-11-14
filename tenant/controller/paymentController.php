<?php
include_once('../server/db.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === 'GET') {
    if (isset($_GET['tenantID']) && !isset($_GET['paymentList'])) {
        $tenantID = intval($_GET['tenantID']); // tenantID passed from AJAX
        
        $sql = "
        SELECT 
            cd.dueDate, 
            GROUP_CONCAT(pc.paymentType SEPARATOR '<br>') AS paymentTypes, 
            GROUP_CONCAT(cd.paymentTypeID SEPARATOR '<br>') AS paymentTypeIDs, 
            GROUP_CONCAT(cd.paymentDetailsID SEPARATOR '<br>') AS paymentDetailsIDs, 
            SUM(cd.amount) AS totalAmount, 
            COALESCE(SUM(pd.totalPayments), 0) AS totalPayments, 
            SUM(cd.amount) - COALESCE(SUM(pd.totalPayments), 0) AS remainingBalance 
        FROM 
            tblchargesDetails cd 
        JOIN 
            tblpaymentType pc ON cd.paymentTypeID = pc.paymentTypeID 
        LEFT JOIN (
            SELECT 
                tenantID, 
                paymentDetailsID,
                SUM(paymentAmount) AS totalPayments
            FROM 
                tblPayments 
            GROUP BY 
                tenantID, paymentDetailsID
        ) pd ON cd.tenantID = pd.tenantID AND cd.paymentDetailsID = pd.paymentDetailsID
        WHERE 
            cd.tenantID = ? 
        GROUP BY 
            cd.dueDate;
        ";

        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            echo json_encode(["status" => "error", "message" => "SQL prepare failed: " . $conn->error]);
            exit;
        }

        $stmt->bind_param("i", $tenantID);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $data = [];

            while ($row = $result->fetch_assoc()) {
                $row['paymentTypes'] = '<ul><li>' . str_replace('<br>', '</li><li>', $row['paymentTypes']) . '</li></ul>';
                $row['paymentTypeIDs'] = explode('<br>', $row['paymentTypeIDs']);
                $row['paymentDetailsIDs'] = explode('<br>', $row['paymentDetailsIDs']);
                $data[] = $row;
            }

            echo json_encode(["status" => "success", "data" => $data]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error executing query: " . $stmt->error]);
        }

        $stmt->close();
    } elseif (isset($_GET['tenantID'], $_GET['dueDate'], $_GET['paymentList'])) {
        $tenantID = intval($_GET['tenantID']);
        $dueDate = $_GET['dueDate'];

        $sql = "
        SELECT 
            pt.paymentType AS PaymentType,
            cd.amount AS Amount,
            cd.dueDate AS DueDate,
            IFNULL(p.paymentDate, 'N/A') AS PaymentDate,
            IFNULL(p.paymentAmount, 0) AS PaymentAmount,
            (cd.amount - IFNULL(p.paymentAmount, 0)) AS Balance
        FROM 
            tblchargesDetails cd
        JOIN 
            tblpaymentType pt ON cd.paymentTypeID = pt.paymentTypeID
        LEFT JOIN 
            tblPayments p ON cd.paymentDetailsID = p.paymentDetailsID
        WHERE 
            cd.tenantID = ? AND cd.dueDate = ?
        ";

        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            echo json_encode(["status" => "error", "message" => "SQL prepare failed: " . $conn->error]);
            exit;
        }

        $stmt->bind_param("is", $tenantID, $dueDate);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $data = [];

            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            echo json_encode(["status" => "success", "data" => $data]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error executing query: " . $stmt->error]);
        }

        $stmt->close();
    }
}
?>
