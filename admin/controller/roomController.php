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

    // Check if the room number already exists for the specified houseID
    $checkRoomSql = "SELECT COUNT(*) as roomExists FROM tblroom WHERE roomNumber = '{$roomNumber}' AND houseID = '{$houseID}'";
    $checkRoomResult = $conn->query($checkRoomSql);

    if ($checkRoomResult) {
        $checkRoomRow = $checkRoomResult->fetch_assoc();
        $roomExists = $checkRoomRow['roomExists'];

        if ($roomExists > 0) {
            echo json_encode(["status" => "error", "message" => "Room number already exists for this house."]);
            return;
        }

        // Check the current number of rooms for the specified houseID
        $countSql = "SELECT COUNT(*) as roomCount FROM tblroom WHERE houseID = '{$houseID}'";
        $countResult = $conn->query($countSql);

        if ($countResult) {
            $countRow = $countResult->fetch_assoc();
            $currentRoomCount = $countRow['roomCount'];

            // Fetch the maximum number of rooms allowed from tblhouse
            $houseSql = "SELECT numberOfRoom FROM tblhouse WHERE houseID = '{$houseID}'";
            $houseResult = $conn->query($houseSql);

            if ($houseResult) {
                $houseRow = $houseResult->fetch_assoc();
                $maxRooms = $houseRow['numberOfRoom'];

                // Check if the current room count has reached the limit
                if ($currentRoomCount >= $maxRooms) {
                    echo json_encode(["status" => "error", "message" => "Room limit reached. Cannot add more rooms."]);
                    return;
                } else {
                    // Proceed with inserting the new room
                    $sql = "INSERT INTO tblroom (roomNumber, roomType, capacity, roomFee, availableStatus, houseID) 
                            VALUES ('{$roomNumber}', '{$roomType}', '{$capacity}', '{$roomFee}', '{$availableStatus}', '{$houseID}')";

                    if ($conn->query($sql)) {
                        // Fetch rooms for the specific houseID in ascending order by roomNumber
                        $sql = "SELECT 
                                tblroom.roomID, 
                                tblroom.roomNumber, 
                                tblroom.roomType, 
                                tblroom.capacity, 
                                tblroom.roomFee, 
                                tblroom.availableStatus, 
                                tblhouse.houselocation,
                                CASE 
                                    WHEN tblroom.roomType = 'regular' THEN 
                                        CASE 
                                            WHEN (SELECT COUNT(*) 
                                                FROM tbltenant 
                                                WHERE tbltenant.roomID = tblroom.roomID 
                                                AND tbltenant.tenantStatus = 'active') > 0 
                                            THEN 0
                                            ELSE 1
                                        END
                                    ELSE 
                                        (tblroom.capacity - COALESCE(
                                            (SELECT COUNT(*) 
                                            FROM tbltenant 
                                            WHERE tbltenant.roomID = tblroom.roomID 
                                            AND tbltenant.tenantStatus = 'active'), 0))
                                END AS availableCapacity
                            FROM 
                                tblhouse
                            LEFT JOIN 
                                tblroom ON tblroom.houseID = tblhouse.houseID
                            WHERE 
                                tblhouse.houseID = '{$houseID}'
                            ORDER BY 
                                tblroom.roomNumber ASC;"; 

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
                            echo json_encode(["status" => "error", "message" => "Error fetching room details: " . $conn->error]);
                        }
                    } else {
                        echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
                    }
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Error fetching house details: " . $conn->error]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Error fetching room count: " . $conn->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Error checking room existence: " . $conn->error]);
    }
}
else if ($requestMethod == 'GET'){
    if (isset($_GET['houseID']) && !isset($_GET['roomType'])) {
        $houseID = intval($_GET['houseID']);

        $sql = "SELECT 
                tblroom.roomID, 
                tblroom.roomNumber, 
                tblroom.roomType, 
                tblroom.capacity, 
                tblroom.roomFee, 
                tblroom.availableStatus, 
                tblhouse.houselocation,
                CASE 
                    WHEN tblroom.roomType = 'regular' THEN 
                        CASE 
                            WHEN (SELECT COUNT(*) 
                                FROM tbltenant 
                                WHERE tbltenant.roomID = tblroom.roomID 
                                AND tbltenant.tenantStatus = 'active') > 0 
                            THEN 0
                            ELSE 1
                        END
                    ELSE 
                        (tblroom.capacity - COALESCE(
                            (SELECT COUNT(*) 
                            FROM tbltenant 
                            WHERE tbltenant.roomID = tblroom.roomID 
                            AND tbltenant.tenantStatus = 'active'), 0))
                END AS availableCapacity
            FROM 
                tblhouse
            LEFT JOIN 
                tblroom ON tblroom.houseID = tblhouse.houseID
            WHERE 
                tblhouse.houseID = ? 
                AND tblroom.roomNumber IS NOT NULL
                AND tblroom.roomType IS NOT NULL
                AND tblroom.capacity IS NOT NULL
                AND tblroom.roomFee IS NOT NULL
                AND tblroom.availableStatus IS NOT NULL
            ORDER BY 
                tblroom.roomNumber ASC;";
        
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
    }else if(isset($_GET['roomType']) ){
        $houseID = intval($_GET['houseID']);
        $roomType = $_GET['roomType'];

        // SQL query to filter by houseID and roomType
        $sql = "SELECT 
                tblroom.roomID, 
                tblroom.roomNumber, 
                tblroom.roomType, 
                tblroom.capacity, 
                tblroom.roomFee, 
                tblroom.availableStatus, 
                tblhouse.houselocation,
                CASE 
                    WHEN tblroom.roomType = 'regular' THEN 
                        CASE 
                            WHEN (SELECT COUNT(*) 
                                FROM tbltenant 
                                WHERE tbltenant.roomID = tblroom.roomID 
                                AND tbltenant.tenantStatus = 'active') > 0 
                            THEN 0
                            ELSE 1
                        END
                    ELSE 
                        (tblroom.capacity - COALESCE(
                            (SELECT COUNT(*) 
                            FROM tbltenant 
                            WHERE tbltenant.roomID = tblroom.roomID 
                            AND tbltenant.tenantStatus = 'active'), 0))
                END AS availableCapacity
            FROM 
                tblhouse
            LEFT JOIN 
                tblroom ON tblroom.houseID = tblhouse.houseID
            WHERE 
                tblhouse.houseID = ? 
                AND tblroom.roomType = ?
                AND tblroom.roomNumber IS NOT NULL
                AND tblroom.roomType IS NOT NULL
                AND tblroom.capacity IS NOT NULL
                AND tblroom.roomFee IS NOT NULL
                AND tblroom.availableStatus IS NOT NULL;";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $houseID, $roomType);  // Bind both houseID and roomType
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
    }
}else if ($requestMethod == 'DELETE') {
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
} 
else if ($requestMethod == 'PUT') {
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
