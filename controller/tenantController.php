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
        $number = $_POST['number'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $fatherName = $_POST['fatherName'];
        $fatherNumber = $_POST['fatherNumber'];
        $motherName = $_POST['motherName'];
        $motherNumber = $_POST['motherNumber'];
        $emergencyName = $_POST['emergencyName'];
        $emergencyNumber = $_POST['emergencyNumber'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $roomID = $_POST['roomID'];

        if ($password === $confirmPassword) {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO tbltenant(tenantName, birthdate, phoneNumber, emailAddress, currentAddress, fatherName, fatherNumber, motherName, motherNumber, emergencyName, emergencyNumber, username, userPassword, roomID) 
                VALUES ('{$name}', '{$birthday}', '{$number}', '{$email}', '{$address}', '{$fatherName}', '{$fatherNumber}', '{$motherName}', '{$motherNumber}', '{$emergencyName}', '{$emergencyNumber}','{$username}', '{$password}', '{$roomID}')";
      
            if ($conn->query($sql))  {
                $selectSql = "SELECT * FROM tbltenant t
                              JOIN tblroom r ON t.roomID = r.roomID
                              JOIN tblhouse h ON r.houseID = h.houseID
                              WHERE r.roomID = '{$roomID}'";
                $selectResult = $conn->query($selectSql);
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
    }
}

?>
