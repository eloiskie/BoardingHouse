<?php
include_once('../server/db.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];
if ($requestMethod == 'POST') {
    if (isset($_POST['houseID'])) {
        $houseID = intval($_POST['houseID']);
        $sql = "SELECT roomID, roomNumber, roomType FROM tblroom WHERE houseID = ?";
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
        // Fetching the roomID and its details
        $roomID = $_POST['roomID'];
        $roomQuery = $conn->prepare("SELECT roomType, capacity FROM tblRoom WHERE roomID = ?");
        $roomQuery->bind_param('i', $roomID);
        $roomQuery->execute();
        $roomResult = $roomQuery->get_result();
    
        if ($roomResult->num_rows > 0) {
            $roomData = $roomResult->fetch_assoc();
            $roomType = $roomData['roomType'];
            $capacity = $roomData['capacity'];
    
            // Count current tenants in the room
            $tenantCountQuery = $conn->prepare("SELECT COUNT(*) as tenantCount FROM tblTenant WHERE roomID = ? AND tenantStatus = 'available'");
            $tenantCountQuery->bind_param('i', $roomID);
            $tenantCountQuery->execute();
            $tenantCountResult = $tenantCountQuery->get_result();
            $tenantCount = $tenantCountResult->fetch_assoc()['tenantCount'];
    
            // Check the conditions for adding a new tenant
            if (($roomType === 'regular' && $tenantCount < 1) || ($roomType !== 'regular' && $tenantCount < $capacity)) {
                // Proceed with adding tenant
                $name = $_POST['tenantName'];
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
                $username = $_POST['username'];
                $tenantStatus = $_POST['tenantStatus'];
                $password = $_POST['password'];

                

              
                // Trim the password to remove extra spaces
                $trimmedPassword = trim($password);

                // Hash the trimmed password
                $hashedPassword = password_hash($trimmedPassword, PASSWORD_DEFAULT);
                    
                // Prepared statement for inserting a tenant
                $stmt = $conn->prepare("INSERT INTO tblTenant (tenantName, gender, phoneNumber, emailAddress, currentAddress, fatherName, fatherNumber, motherName, motherNumber, emergencyName, emergencyNumber, dateStarted, username, userPassword, tenantStatus, roomID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssssssssssss", $name, $gender, $number, $email, $address, $fatherName, $fatherNumber, $motherName, $motherNumber, $emergencyName, $emergencyNumber, $dateStarted, $username, $hashedPassword, $tenantStatus, $roomID);
    
                if ($stmt->execute()) {
                    // Update the room's status
                    $updateRoom = $conn->prepare("UPDATE tblRoom SET availableStatus = ? WHERE roomID = ?");
                    $status = 'Occupied'; // Example status
                    $updateRoom->bind_param('si', $status, $roomID);
    
                    if ($updateRoom->execute()) {
                        // Fetching tenant data
                        $selectSql = "SELECT t.*, r.*, h.* FROM tblTenant t JOIN tblRoom r ON t.roomID = r.roomID JOIN tblHouse h ON r.houseID = h.houseID WHERE tenantStatus='active';";
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
                        echo json_encode(["status" => "error", "message" => "Error: " . $updateRoom->error]);
                    }
                    $updateRoom->close(); // Close the statement
                } else {
                    echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
                }
                $stmt->close(); // Close the statement
            } else {
                echo json_encode(["status" => "error", "message" => "Cannot add tenant: Room capacity exceeded or room type restriction."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Error: Room not found."]);
        }
        $roomQuery->close(); // Close the statement
    }
    
    else if (isset($_POST['generatePass'])) {
        $length = 8; // Length of the password
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomPassword = '';
            
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[random_int(0, $charactersLength - 1)]; // Use random_int
        }
        echo json_encode(['status' => 'success', 'password' => $randomPassword]);
    }
}
else if ($requestMethod == 'GET') {
    // Existing GET requests handling
    if (!isset($_GET['houseID']) && !isset($_GET['tenant']) && !isset($_GET['tenantID']) && !isset($_GET['inactiveTenant']) ) {
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
        $sql = "SELECT t.*, r.*, h.*
                    FROM tblTenant t  
                    JOIN tblRoom r ON t.roomID = r.roomID
                    JOIN tblHouse h ON r.houseID = h.houseID
                    WHERE tenantStatus = 'active';";

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
        $sql = "SELECT t.*, r.*, h.*
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
    }else if (isset($_GET['inactiveTenant'])) {
        $sql = "SELECT t.*, r.*, h.*
                    FROM tblTenant t  
                    JOIN tblRoom r ON t.roomID = r.roomID
                    JOIN tblHouse h ON r.houseID = h.houseID
                    WHERE tenantStatus = 'In-active';";

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
    }
}
else if ($requestMethod == 'DELETE') {
    // Read raw input data
    parse_str(file_get_contents("php://input"), $_DELETE);
    
    // Check if both tenantID and roomID are provided
    if (isset($_DELETE['tenantID']) && isset($_DELETE['roomID'])) {
        $tenantID   = intval($_DELETE['tenantID']); // Ensure tenantID is an integer
        $roomID     = intval($_DELETE['roomID']);   // Ensure roomID is an integer

        $tenantStatus = "In-active"; // String value for tenant status
        // Construct SQL UPDATE query
        $sql = "UPDATE tbltenant SET tenantStatus = ? WHERE tenantID = ?";
        
        $stmt = $conn->prepare($sql);
        // Bind parameters: first is string (s), second is integer (i)
        $stmt->bind_param("si", $tenantStatus, $tenantID);
        
        if ($stmt->execute()) {
            $updateAvailable = "UPDATE tblroom SET availableStatus = 'Available' WHERE roomID = ?"; 

            $stmtUpdate = $conn->prepare($updateAvailable);
            $stmtUpdate->bind_param("i", $roomID); // roomID is also an integer
            if ($stmtUpdate->execute()) {
                echo json_encode(["status" => "success", "message" => "Tenant Successfully Deleted"]);
            } else {
                // Error in updating room availability
                echo json_encode(["status" => "error", "message" => "Error updating room availability: " . $stmtUpdate->error]);
            }
            $stmtUpdate->close();
        } else {
            // Error in deletion
            echo json_encode(["status" => "error", "message" => "Error deleting tenant: " . $stmt->error]);
        }
        
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Tenant ID or Room ID not provided"]);
    }

    $conn->close();
}

else if($requestMethod == 'PUT') {
    $inputData = json_decode(file_get_contents("php://input"), true);
    
    // Validate the input
    // if(isset($_PUT['tenantUpdate']) && !isset($_PUT['activate'])){
    if (json_last_error() === JSON_ERROR_NONE && 
        isset($inputData['tenantID'], $inputData['tenantName'], 
              $inputData['gender'], $inputData['phoneNumber'], 
              $inputData['emailAddress'], $inputData['currentAddress'], 
              $inputData['fatherName'], $inputData['fatherNumber'], 
              $inputData['motherName'], $inputData['motherNumber'], 
              $inputData['emergencyName'], $inputData['emergencyNumber'], 
              $inputData['dateStarted'], $inputData['roomID'], 
              $inputData['userPassword'])) { 

        $tenantID = intval($inputData['tenantID']);
        $tenantName = $inputData['tenantName'];
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
        $userPassword = $inputData['userPassword'];  
        $roomID = intval($inputData['roomID']);

        // Update SQL query to include userPassword
        $sql = "UPDATE tbltenant 
                SET tenantName = ?, gender = ?, phoneNumber = ?, 
                    emailAddress = ?, currentAddress = ?, fatherName = ?, 
                    fatherNumber = ?, motherName = ?, motherNumber = ?, 
                    emergencyName = ?, emergencyNumber = ?, dateStarted = ?, 
                    userPassword = ?, roomID = ?
                WHERE tenantID = ?";

        $stmtUpdate = $conn->prepare($sql);
        if ($stmtUpdate) {
            // Ensure you bind the userPassword parameter as well
            $stmtUpdate->bind_param("sssssssssssssii", $tenantName, $gender, $phoneNumber, 
                $emailAddress, $currentAddress, $fatherName, $fatherNumber, 
                $motherName, $motherNumber, $emergencyName, $emergencyNumber, 
                $dateStarted, $userPassword, $roomID, $tenantID); // Correct binding

            if ($stmtUpdate->execute()) {
                echo json_encode(["status" => "success", "message" => "Tenant Successfully Updated"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
            }
            $stmtUpdate->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Error preparing update statement: " . $conn->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid or incomplete data"]);
    }

    $conn->close();
}

?>