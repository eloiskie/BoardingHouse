<?php
include_once('../server/db.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];
if($requestMethod == 'PUT') {
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
              )) { 

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
       

        // Update SQL query to include userPassword
        $sql = "UPDATE tbltenant 
                SET tenantName = ?, gender = ?, phoneNumber = ?, 
                    emailAddress = ?, currentAddress = ?, fatherName = ?, 
                    fatherNumber = ?, motherName = ?, motherNumber = ?, 
                    emergencyName = ?, emergencyNumber = ?
                WHERE tenantID = ?";

        $stmtUpdate = $conn->prepare($sql);
        if ($stmtUpdate) {
            // Ensure you bind the userPassword parameter as well
            $stmtUpdate->bind_param("sssssssssssi", $tenantName, $gender, $phoneNumber, 
                $emailAddress, $currentAddress, $fatherName, $fatherNumber, 
                $motherName, $motherNumber, $emergencyName, $emergencyNumber, 
                $tenantID); // Correct binding

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

?>