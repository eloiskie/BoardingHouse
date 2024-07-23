<?php
include_once('../server/db.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == 'POST') {
    $roomNumber = $_POST['roomNumber'];
    $roomType = $_POST['roomType'];
    $capacity = $_POST['capacity'];
    $roomFee = $_POST['roomFee'];
    $availableStatus = $_POST['availableStatus'];
    $houseID = $_POST['houseID'];

    // Corrected SQL INSERT statement
    $sql = "INSERT INTO tblroom (roomNumber, roomType, capacity, roomFee, availableStatus, houseID) 
            VALUES ('{$roomNumber}', '{$roomType}', '{$capacity}', '{$roomFee}', '{$availableStatus}', '{$houseID}')";

    if ($conn->query($sql)) {
        // Fetch rooms for the specific houseID
        $sql = "SELECT tblroom.roomID, tblroom.roomNumber, tblroom.roomType, tblroom.capacity, tblroom.roomFee, tblroom.availableStatus, tblhouse.houselocation
                FROM tblhouse
                LEFT JOIN tblroom ON tblroom.houseID = tblhouse.houseID
                WHERE tblhouse.houseID = '{$houseID}'"; // Filter by houseID

        $selectResult = $conn->query($sql);

        if ($selectResult) {
            $data = array();
            if ($selectResult->num_rows > 0) {
                while ($row = $selectResult->fetch_assoc()) {
                    $data[] = $row;
                }
            }
            echo json_encode(["status" => "success", "message" => "Room Successfully Added", "data" => $data]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
    }
}
 else if (isset($_GET['houseID'])) {
    $houseID = intval($_GET['houseID']);

    $sql = "SELECT tblroom.roomID, tblroom.roomNumber, tblroom.roomType, tblroom.capacity, tblroom.roomFee, tblroom.availableStatus, tblhouse.houselocation
            FROM tblhouse
            LEFT JOIN tblroom ON tblroom.houseID = tblhouse.houseID
            WHERE tblhouse.houseID = ?
            AND tblroom.roomNumber IS NOT NULL
            AND tblroom.roomType IS NOT NULL
            AND tblroom.capacity IS NOT NULL
            AND tblroom.roomFee IS NOT NULL
            AND tblroom.availableStatus IS NOT NULL";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $houseID);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    $stmt->close();
    $conn->close();

    echo json_encode($data);
} else if ($requestMethod == 'DELETE') {
    // Read raw input data
    parse_str(file_get_contents("php://input"), $_DELETE);
    
    // Retrieve and sanitize the roomID
    if (isset($_DELETE['roomID'])) {
        $roomID = intval($_DELETE['roomID']);
        
        // Construct SQL DELETE query
        $sql = "DELETE FROM tblroom WHERE roomID = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $roomID);
        
        if ($stmt->execute()) {
            // Deletion successful
            echo json_encode(["status" => "success", "message" => "Room Successfully Deleted"]);
        } else {
            // Error in deletion
            echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
        }
        
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Room ID not provided"]);
    }

    $conn->close();
} else if ($requestMethod == 'PUT') {
    // Read raw input data and decode JSON
    $inputData = json_decode(file_get_contents("php://input"), true);

    // Check if decoding was successful and required keys are present
    if (json_last_error() === JSON_ERROR_NONE && isset($inputData['roomID'], $inputData['roomNumber'], $inputData['roomType'], $inputData['capacity'], $inputData['roomFee'], $inputData['availableStatus'], $inputData['houseID'])) {
        $roomID = intval($inputData['roomID']);
        $roomNumber = $inputData['roomNumber'];
        $roomType = $inputData['roomType'];
        $capacity = $inputData['capacity'];
        $roomFee = $inputData['roomFee'];
        $availableStatus = $inputData['availableStatus'];
        $houseID = $inputData['houseID'];

        // Prepare SQL statement
        $sql = "UPDATE tblroom 
                SET roomNumber = ?, roomType = ?, capacity = ?, roomFee = ?, availableStatus = ?, houseID = ?
                WHERE roomID = ?";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssssssi", $roomNumber, $roomType, $capacity, $roomFee, $availableStatus, $houseID, $roomID);

            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Room Successfully Updated"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
            }

            $stmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Error preparing statement"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid or incomplete data"]);
    }

    $conn->close();
}

else {
    // Handle other request methods or invalid requests
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>
