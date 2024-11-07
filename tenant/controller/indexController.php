<?php
session_start(); // Start the session to access session variables
include_once('../server/db.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];

if($requestMethod ==='GET'){

    $tenantID = intval($_GET['tenantID']);
    $sql = "SELECT * FROM tbltenant WHERE tenantID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $tenantID);
    $stmt->execute();
    $result = $stmt->get_result();
    

    $data = [];
    if($result->num_rows > 0){
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    $stmt->close();
    $conn->close();

    echo json_encode($data);
}


?>