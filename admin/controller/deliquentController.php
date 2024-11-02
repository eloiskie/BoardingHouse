<?php
include_once('../server/db.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == 'GET') {
    // Check if the request is for delayed payments
    if (isset($_GET['delayedPayments']) && !isset($_GET['tenantList'])) {
        $sql = "
            SELECT 
            t.tenantID, 
            t.tenantName, 
            h.houseLocation, 
            r.roomNumber, 
            COUNT(DISTINCT CASE WHEN cd.dueDate < p.paymentDate THEN cd.dueDate END) AS delayedPayments 
            FROM tbltenant AS t 
            JOIN 
            tblroom AS r ON t.roomID = r.roomID 
            JOIN 
            tblhouse AS h ON r.houseID = h.houseID 
            JOIN 
            tblpayments AS p ON t.tenantID = p.tenantID 
            JOIN 
            tblchargesdetails AS cd ON p.paymentDetailsID = cd.paymentDetailsID 
            
            GROUP BY t.tenantID, t.tenantName, h.houseLocation, r.roomNumber
        ";

        // Execute the SQL query
        $result = $conn->query($sql);

        if ($result) {
            $tenants = [];

            // Fetch all results
            while ($row = $result->fetch_assoc()) {
                $tenants[] = $row;
            }

            // Return results as JSON
            echo json_encode($tenants);
        } else {
            // Handle query error
            echo json_encode(['status' => 'error', 'message' => $conn->error]);
        }
    } 
    // Check if the request is for the tenant list
    else if (isset($_GET['tenantID'])) {
        $tenantID = $_GET['tenantID'];

        $sql = "
            SELECT 
                p.tenantID, 
                cd.dueDate, 
                GROUP_CONCAT(DISTINCT pt.paymentType ORDER BY pt.paymentType ASC SEPARATOR '<br>') AS paymentTypes, 
                GROUP_CONCAT(DISTINCT p.paymentDate ORDER BY p.paymentDate ASC SEPARATOR '<br>') AS paymentDates 
            FROM 
                tblpayments AS p 
            JOIN 
                tblchargesdetails AS cd ON p.paymentDetailsID = cd.paymentDetailsID 
            JOIN 
                tblpaymenttype AS pt ON cd.paymentTypeID = pt.paymentTypeID 
            WHERE 
                p.tenantID = ? 
                AND cd.dueDate IS NOT NULL 
                AND p.paymentDate IS NOT NULL 
                AND cd.dueDate < p.paymentDate 
            GROUP BY 
                p.tenantID, cd.dueDate 
            ORDER BY 
                cd.dueDate;
        ";

        // Prepare statement and bind parameter
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $tenantID);

        // Execute the statement
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            $tenants = [];

            // Fetch all results
            while ($row = $result->fetch_assoc()) {
                $tenants[] = $row;
            }

            // Return results as JSON
            echo json_encode($tenants);
        } else {
            // Handle query error
            echo json_encode(['status' => 'error', 'message' => $conn->error]);
        }
        $stmt->close();
    } else {
        // Handle invalid query parameters
        echo json_encode(['status' => 'error', 'message' => 'Invalid parameters.']);
    }
} else {
    // Handle method not allowed
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed.']);
}

$conn->close();
?>
