<?php
include_once('../server/db.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];
if ($requestMethod == 'POST') {
    if (isset($_POST['houseID'])) {
        $houseID = intval($_POST['houseID']);
        $sql = "SELECT roomID, roomNumber FROM tblroom WHERE houseID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $houseID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            $data = array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }
            echo json_encode(["status" => "success", "data" => $data]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
        }
    } else if (isset($_POST['tenantName'])) {
        $name = $_POST['tenantName'];
        $birthday = $_POST['birthday'];
        $gender = $_POST['gender'];
        $number = $_POST['number'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $fatherName = $_POST['fatherName'];
        $fatherNumber = $_POST['fatherNumber'];
        $motherName = $_POST['motherName'];
        $motherNumber = $_POST['motherNumber'];
        $emergencyName = $_POST['emergencyName'];
        $emergencyNumber = $_POST['emergencyNumber'];
        $dateStarted = $_POST['dateStarted'];
        
        $lastPayment = $_POST['lastPayment'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $roomID = $_POST['roomID'];

         // Calculate the number of months since the start date
            $startDate = new DateTime($dateStarted);
            $currentDate = new DateTime();
            $interval = $startDate->diff($currentDate);
            $months = $interval->m + ($interval->y * 12);

            // Get the room fee
            $stmt = $conn->prepare("SELECT roomFee FROM tblroom WHERE roomID = ?");
            $stmt->bind_param("i", $roomID); // Bind the roomID parameter
            $stmt->execute(); // Execute the statement without arguments
            $result = $stmt->get_result();
            $room = $result->fetch_assoc();
            $roomFee = $room['roomFee'];
            

        // Calculate initial balance
        $balance = $months * $roomFee;

    
        if ($password === $confirmPassword) {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
            $sql = "INSERT INTO tbltenant(tenantName, birthdate, gender, phoneNumber, emailAddress, currentAddress, fatherName, fatherNumber, motherName, motherNumber, emergencyName, emergencyNumber, dateStarted, balance, lastPayment, username, userPassword, roomID) 
                VALUES ('{$name}', '{$birthday}', '{$gender}', '{$number}', '{$email}', '{$address}', '{$fatherName}', '{$fatherNumber}', '{$motherName}', '{$motherNumber}', '{$emergencyName}', '{$emergencyNumber}', '{$dateStarted}','{$balance}','{$lastPayment}', '{$username}', '{$hashedPassword}', '{$roomID}')";
    
            if ($conn->query($sql)) {
                $updateRoom = $conn->prepare("UPDATE tblRoom SET availableStatus = ? WHERE roomID = ?");
                $status = 'Occupied'; // Example status
                $updateRoom->bind_param('si', $status, $roomID);
    
                if ($updateRoom->execute()) {
                    // Perform the SELECT query
                    $selectSql = "SELECT t.*, 
                                        CASE 
                                            WHEN t.lastPayment = '0000-00-00' OR t.lastPayment IS NULL THEN 'N/A'
                                            ELSE t.lastPayment
                                        END AS formattedLastPayment,
                                        r.*, 
                                        h.*
                                    FROM tblTenant t
                                    JOIN tblRoom r ON t.roomID = r.roomID
                                    JOIN tblHouse h ON r.houseID = h.houseID";
                                    
                
    
                    $selectResult = $conn->query($selectSql);
    
                    if ($selectResult) {
                        $data = array();
                        if ($selectResult->num_rows > 0) {
                            while ($row = $selectResult->fetch_assoc()) {
                                $data[] = $row;
                            }
                        }
                        echo json_encode(["status" => "success", "message" => "Tenant Successfully Added", "data" => $data]);
                    } else {
                        echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
                    }
                } else {
                    echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Passwords do not match"]);
        }
    }
    
}

else if ($requestMethod == 'GET') {
    // Existing GET requests handling
    if (!isset($_GET['houseID']) && !isset($_GET['tenant']) && !isset($_GET['tenantID']) ) {
        $sql = "SELECT houseID, houselocation FROM tblHouse";
        $result = $conn->query($sql);

        if ($result) {
            $data = array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }
            echo json_encode(["status" => "success", "data" => $data]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
        }
    } else if (isset($_GET['tenant'])) {
        $sql = "SELECT t.*, 
                       CASE 
                           WHEN t.lastPayment = '0000-00-00' OR t.lastPayment IS NULL THEN 'N/A'
                           ELSE t.lastPayment
                       END AS formattedLastPayment,
                       r.roomNumber, 
                       r.roomFee,
                       h.houselocation
                FROM tblTenant t
                JOIN tblRoom r ON t.roomID = r.roomID
                JOIN tblHouse h ON r.houseID = h.houseID";

        $result = $conn->query($sql);

        if ($result) {
            $data = array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }
            echo json_encode(["status" => "success", "data" => $data]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
        }
    }else if(isset($_GET['tenantID'])){
        $tenantID = intval($_GET['tenantID']);
        $sql = "SELECT t.*, 
                        CASE 
                            WHEN t.lastPayment = '0000-00-00' OR t.lastPayment IS NULL THEN 'N/A'
                            ELSE t.lastPayment
                        END AS formattedLastPayment,
                        r.roomNumber, 
                        r.roomFee,
                        h.houselocation,
                        h.houseID
                FROM tblTenant t
                JOIN tblRoom r ON t.roomID = r.roomID
                JOIN tblHouse h ON r.houseID = h.houseID
                WHERE tenantID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $tenantID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            $data = array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }
            echo json_encode(["status" => "success", "data" => $data]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
        }
    }
}else if ($requestMethod == 'DELETE') {
    // Read raw input data
    parse_str(file_get_contents("php://input"), $_DELETE);
    
    // Retrieve and sanitize the roomID
    if (isset($_DELETE['tenantID'])) {
        $tenantID = intval($_DELETE['tenantID']);
        
        // Construct SQL DELETE query
        $sql = "DELETE FROM tbltenant WHERE tenantID = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $tenantID);
        
        if ($stmt->execute()) {
            // Deletion successful
            echo json_encode(["status" => "success", "message" => "Tenant Successfully Deleted"]);
        } else {
            // Error in deletion
            echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
        }
        
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Tenant ID not provided"]);
    }

    $conn->close();
}// Check if decoding was successful and required keys are present
else if($requestMethod == 'PUT') {
    $inputData = json_decode(file_get_contents("php://input"), true);
    if (json_last_error() === JSON_ERROR_NONE &&
        isset($inputData['tenantID'], $inputData['tenantName'], $inputData['birthdate'], 
            $inputData['gender'], $inputData['phoneNumber'], $inputData['emailAddress'], 
            $inputData['currentAddress'], $inputData['fatherName'], $inputData['fatherNumber'], 
            $inputData['motherName'], $inputData['motherNumber'], 
            $inputData['emergencyName'], $inputData['emergencyNumber'], 
            $inputData['dateStarted'], $inputData['roomID'])) {

        $tenantID = intval($inputData['tenantID']);
        $tenantName = $inputData['tenantName'];
        $birthdate = $inputData['birthdate'];
        $gender = $inputData['gender'];
        $phoneNumber = $inputData['phoneNumber'];
        $emailAddress = $inputData['emailAddress'];
        $currentAddress = $inputData['currentAddress'];
        $fatherName = $inputData['fatherName'];
        $fatherNumber = $inputData['fatherNumber'];
        $motherName = $inputData['motherName'];
        $motherNumber = $inputData['motherNumber'];
        $emergencyName = $inputData['emergencyName'];
        $emergencyNumber = $inputData['emergencyNumber'];
        $dateStarted = $inputData['dateStarted'];
        $roomID = $inputData['roomID'];

        // Prepare SQL statement
        $sql = "UPDATE tblTenant 
                SET tenantName = ?, birthdate = ?, gender = ?, phoneNumber = ?, 
                    emailAddress = ?, currentAddress = ?, fatherName = ?, 
                    fatherNumber = ?, motherName = ?, motherNumber = ?, 
                    emergencyName = ?, emergencyNumber = ?, dateStarted = ?, roomID = ?
                WHERE tenantID = ?";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssssssssssssssi", $tenantName, $birthdate, $gender, $phoneNumber, 
                $emailAddress, $currentAddress, $fatherName, $fatherNumber, 
                $motherName, $motherNumber, $emergencyName, $emergencyNumber, 
                $dateStarted, $roomID, $tenantID);

            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Tenant Successfully Updated"]);
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

    ?>
