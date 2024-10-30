<?php
include_once('../server/db.php');

 $requestMethod = $_SERVER['REQUEST_METHOD'];
 if($requestMethod == "GET"){
    $sql = "SELECT 
    (SELECT COUNT(*) FROM tblHouse) AS HouseCount, 
    (SELECT COUNT(*) FROM tblTenant) AS TenantCount";

    $result = $conn->query($sql);

    $data = array();

    if($result->num_rows > 0)
    {
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }
    }
    echo json_encode($data);
 }
?>
