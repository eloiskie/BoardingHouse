<?php
include_once('../server/db.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];

if($requestMethod === 'GET'){

    $sql = "SELECT 
                t.tenantName,
                t.tenantID,
                h.houseLocation,
                r.roomNumber,
                COUNT(m.requestID) AS requestCount
            FROM 
                tbltenant t
            JOIN 
                tblroom r ON t.roomID = r.roomID
            JOIN 
                tblhouse h ON r.houseID = h.houseID
            LEFT JOIN 
                tblmaintenancerequest m ON t.tenantID = m.tenantID
            GROUP BY 
                t.tenantName, t.tenantID, h.houseLocation, r.roomNumber";

    $stmt= $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
  
    $data = [];

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $data[]= $row;
        }
    }
    $stmt->close();
    $conn->close();

    echo json_encode($data);
}
?>