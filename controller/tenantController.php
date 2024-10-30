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
        $password = $_POST['password'];
        $roomID = $_POST['roomID'];

        $sql = "INSERT INTO tbltenant(tenantName, gender, phoneNumber, emailAddress, currentAddress, fatherName, fatherNumber, motherName, motherNumber, emergencyName, emergencyNumber, dateStarted, username, userPassword, roomID) 
                VALUES ('{$name}', '{$gender}', '{$number}', '{$email}', '{$address}', '{$fatherName}', '{$fatherNumber}', '{$motherName}', '{$motherNumber}', '{$emergencyName}', '{$emergencyNumber}', '{$dateStarted}', '{$username}', '{$password}', '{$roomID}')";

        if($conn->query($sql)){
            $updateRoom = $conn->prepare("UPDATE tblRoom SET availableStatus = ? WHERE roomID = ?");
            $status = 'Occupied'; // Example status
            $updateRoom->bind_param('si', $status, $roomID);

            if($updateRoom->execute()){
                    $selectSql = "SELECT t.*, r.*, h.*
                                    FROM tblTenant t  
                                    JOIN tblRoom r ON t.roomID = r.roomID
                                    JOIN tblHouse h ON r.houseID = h.houseID;
                                    ";
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
            }else {
                    echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
                    }
        }
        
    }else if (isset($_POST['generatePass'])){
        $length = 8 ; // Length of the password
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomPassword = '';
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[rand(0, $charactersLength - 1)];
        }
        echo json_encode(['password' => $randomPassword]);
    
    }if (isset($_POST['query'])) {
        $searchTerm = mysqli_real_escape_string($conn, $_POST['query']);
        
        // Search for tenant names that match the query
        $sql = "SELECT t.tenantID, t.tenantName, t.phoneNumber, r.roomNumber, h.houselocation
                FROM tblTenant t  
                JOIN tblRoom r ON t.roomID = r.roomID
                JOIN tblHouse h ON r.houseID = h.houseID 
                WHERE tenantName LIKE ?";
        $stmt = $conn->prepare($sql);
        $searchParam = "%" . $searchTerm . "%";
        $stmt->bind_param("s", $searchParam);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $tenants = array();
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Add the row data to the array
                $tenants[] = array(
                    'tenantID' => $row['tenantID'],
                    'tenantName' => $row['tenantName'],
                    'phoneNumber' => $row['phoneNumber'],
                    'roomNumber' => $row['roomNumber'],
                    'houselocation' => $row['houselocation']
                );
            }
        }
        
        // Return the result as JSON
        echo json_encode($tenants);
        
        $stmt->close();
    }
    
    $conn->close();
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
        $sql = "SELECT t.*, r.*, h.*
                    FROM tblTenant t  
                    JOIN tblRoom r ON t.roomID = r.roomID
                    JOIN tblHouse h ON r.houseID = h.houseID;";

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
    }
}
else if ($requestMethod == 'DELETE') {
    // Read raw input data
    parse_str(file_get_contents("php://input"), $_DELETE);
    
    // Retrieve and sanitize the roomID
    if (isset($_DELETE['tenantID'])) {
        $tenantID   = intval($_DELETE['tenantID']);
        $roomID     = intval($_DELETE['roomID']);
        // Construct SQL DELETE query
        $sql = "DELETE FROM tbltenant WHERE tenantID = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $tenantID);
        
        if ($stmt->execute()) {
            $updateAvailable = "UPDATE tblroom SET availableStatus = 'Available' WHERE roomID = ?"; 

            $stmtUpdate = $conn->prepare($updateAvailable);
            $stmtUpdate->bind_param("i", $roomID);
            if($stmtUpdate->execute()){
                echo json_encode(["status" => "success", "message" => "Tenant Successfully Deleted"]);
            } else {
                // Error in update
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