<?php
include_once('../server/db.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];
if($requestMethod == 'PUT') {
    $inputData = json_decode(file_get_contents("php://input"), true);
    
    if(isset($inputData['details']) && !isset($inputData['password'])){
        if (json_last_error() === JSON_ERROR_NONE && 
            isset($inputData['tenantID'], $inputData['tenantName'], 
                  $inputData['gender'], $inputData['phoneNumber'], 
                  $inputData['emailAddress'], $inputData['currentAddress'], 
                  $inputData['fatherName'], $inputData['fatherNumber'], 
                  $inputData['motherName'], $inputData['motherNumber'], 
                  $inputData['emergencyName'], $inputData['emergencyNumber'])) { 

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

            $sql = "UPDATE tbltenant 
                    SET tenantName = ?, gender = ?, phoneNumber = ?, 
                        emailAddress = ?, currentAddress = ?, fatherName = ?, 
                        fatherNumber = ?, motherName = ?, motherNumber = ?, 
                        emergencyName = ?, emergencyNumber = ?
                    WHERE tenantID = ?";
            $stmtUpdate = $conn->prepare($sql);

            if ($stmtUpdate) {
                $stmtUpdate->bind_param("sssssssssssi", $tenantName, $gender, $phoneNumber, 
                    $emailAddress, $currentAddress, $fatherName, $fatherNumber, 
                    $motherName, $motherNumber, $emergencyName, $emergencyNumber, 
                    $tenantID);

                if ($stmtUpdate->execute()) {
                    echo json_encode(["status" => "success", "message" => "Information Successfully Updated"]);
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
    else if(isset($inputData['account'])) {
        if (json_last_error() === JSON_ERROR_NONE && 
            isset($inputData['tenantID'], $inputData['oldPassword'], $inputData['newPassword'])) {

            $tenantID = intval($inputData['tenantID']);
            $oldPassword = $inputData['oldPassword'];
            $newPassword = $inputData['newPassword'];

            $sqlFetch = "SELECT userPassword FROM tbltenant WHERE tenantID = ?";
            $stmtFetch = $conn->prepare($sqlFetch);
            if ($stmtFetch) {
                $stmtFetch->bind_param("i", $tenantID);
                $stmtFetch->execute();
                $stmtFetch->bind_result($storedHashedPassword);
                
                $fetchSuccess = $stmtFetch->fetch();
                $stmtFetch->close(); // Ensure close is outside conditional block

                if ($fetchSuccess) {
                    if (password_verify($oldPassword, $storedHashedPassword)) {
                        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                        $sqlUpdatePassword = "UPDATE tbltenant SET userPassword = ? WHERE tenantID = ?";
                        $stmtUpdatePassword = $conn->prepare($sqlUpdatePassword);
                        if ($stmtUpdatePassword) {
                            $stmtUpdatePassword->bind_param("si", $hashedNewPassword, $tenantID);
                            if ($stmtUpdatePassword->execute()) {
                                echo json_encode(["status" => "success", "message" => "Password successfully updated"]);
                            } else {
                                echo json_encode(["status" => "error", "message" => "Error updating password: " . $conn->error]);
                            }
                            $stmtUpdatePassword->close();
                        } else {
                            echo json_encode(["status" => "error", "message" => "Error preparing password update statement: " . $conn->error]);
                        }
                    } else {
                        echo json_encode(["status" => "error", "message" => "Old password does not match"]);
                    }
                } else {
                    echo json_encode(["status" => "error", "message" => "Tenant not found"]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Error preparing fetch statement: " . $conn->error]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid or incomplete data"]);
        }

        $conn->close();
    }
}
?>
