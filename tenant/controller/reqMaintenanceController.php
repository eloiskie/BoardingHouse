<?php
session_start(); // Start the session to access session variables
include_once('../server/db.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];

if($requestMethod ==='GET'){

    $tenantID = intval($_GET['tenantID']);
    $sql = "SELECT t.*, r.roomNumber, r.roomID, h.houselocation, h.houseAddress
            FROM tbltenant t
            JOIN tblroom r ON t.roomID = r.roomID
            JOIN tblhouse h ON r.houseID = h.houseID
            WHERE t.tenantID = ?";
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
}else if ($requestMethod=== 'POST') {
    // Collect data from the form
    $tenantID = $_POST['tenantID'];
    $maintenanceType = isset($_POST['maintenanceType']) ? $_POST['maintenanceType'] : 'Others'; // Default to 'Others' if not set
    $description = $_POST['description'];
    $status = 'Pending';
    $priorityLevel = $_POST['priorityLevel'];
    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO tblmaintenancerequest (tenantID, requestDate, maintenanceType, description, requestStatus, priorityLevel) VALUES (?, NOW(), ?, ?, ?, ?)");
    $stmt->bind_param("issss", $tenantID, $maintenanceType, $description, $status, $priorityLevel);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => "Maintenance request submitted successfully."]);
    } else {
        echo json_encode(['status' => 'error', 'message' => "Error Request Maintenance: " . $stmt->error]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
