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
                                    JOIN tblHouse h ON r.houseID = h.houseID
                                    WHERE r.roomID = '{$roomID}'";
                
    
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
    if (!isset($_GET['houseID'])) {
        $sql = "SELECT houseID, houselocation FROM tblhouse";
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
        
        $sql = "SELECT * FROM tbltenant 
                WHERE tenantID = ?";
         $stmt = $conn->prepare($sql);
         $stmt->bind_param("i", $tenantID);
         $stmt->execute();
         $result = $stmt->get_result();
    
        if($result){
            $data = array();
                if($result->num > 0){
                    while($row = $result->fetch_assoc()){
                        $data[] = $row;
                    }
                }
                echo json_encode(["status" => "success", "data" => $data]);
        }else {
            echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
        }
    }
}

?>
