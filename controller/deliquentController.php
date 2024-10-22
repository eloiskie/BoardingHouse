<?php
include_once('../server/db.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == 'GET') {
    // Prepare an SQL statement to get tenant name, house location, room number, and count delayed payments
    $sql = "
        SELECT 
            t.tenantName, 
            h.houseLocation, 
            r.roomNumber, 
            COUNT(cd.paymentDetailsID) AS delayedPayments
        FROM 
            tbltenant t
        JOIN 
            tblroom r ON t.roomID = r.roomID
        JOIN 
            tblhouse h ON r.houseID = h.houseID
        LEFT JOIN 
            tblchargesdetails cd ON t.tenantID = cd.tenantID
        LEFT JOIN 
            tblpayments p ON cd.paymentDetailsID = p.paymentDetailsID
        WHERE 
            cd.dueDate < NOW() AND (p.paymentDate IS NULL OR cd.dueDate < p.paymentDate)
        GROUP BY 
            t.tenantID, h.houseLocation, r.roomNumber
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
} else {
    // Handle method not allowed
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed.']);
}
?>
