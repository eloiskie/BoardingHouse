<?php
include_once('../server/db.php');

$requesMethod = $_SERVER['REQUEST_METHOD'];

if($requesMethod === 'GET'){
    if (isset($_GET['tenantID'])) {
        $tenantID = intval($_GET['tenantID']); // tenantID passed from AJAX
    
        // SQL query to select charges grouped by dueDate for the given tenant
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
            error_log("SQL prepare failed: " . $conn->error); // Log the error for debugging
            echo json_encode(["status" => "error", "message" => "SQL prepare failed: " . $conn->error]);
            exit;
        }
    
        // Bind the tenantID parameter
        $stmt->bind_param("i", $tenantID); // only one tenantID
    
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $data = array();
    
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Format the charge types
                    $row['paymentTypes'] = '<ul><li>' . str_replace('<br>', '</li><li>', $row['paymentTypes']) . '</li></ul>';
                    
                    // Split paymentTypeIDs and paymentDetailsIDs into arrays
                    $row['paymentTypeIDs'] = explode('<br>', $row['paymentTypeIDs']);
                    $row['paymentDetailsIDs'] = explode('<br>', $row['paymentDetailsIDs']); // Split paymentDetailsIDs
                    
                    $data[] = $row;
                }
                echo json_encode(["status" => "success", "data" => $data]);
            } else {
                echo json_encode(["status" => "success", "data" => []]);
            }
        } else {
            error_log("Error executing query: " . $stmt->error); // Log the error
            echo json_encode(["status" => "error", "message" => "Error executing query: " . $stmt->error]);
        }
    
        $stmt->close();
    } 
}
?>