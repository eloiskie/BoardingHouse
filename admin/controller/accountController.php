<?php
include_once('../server/db.php');

function maskEmail($email) {
    list($localPart, $domainPart) = explode('@', $email);
    
    // Keep the first letter and the last letter of the local part (if it has more than 2 letters)
    if (strlen($localPart) > 2) {
        $maskedLocal = substr($localPart, 0, 1) . str_repeat('*', strlen($localPart) - 2) . substr($localPart, -1);
    } else {
        $maskedLocal = $localPart; // If local part has 1 or 2 characters, keep it as is
    }

    return $maskedLocal . '@' . $domainPart; // Fixed to include '@' symbol
}

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == "GET") {
    if (isset($_GET['email']) && !isset($_GET['adminName'])) {
        $email = $_GET['email'];

        // Use prepared statement for the email check
        $stmt = $conn->prepare("SELECT Email FROM tbladminaccount WHERE Email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
   

        $data = array();

        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $row['maskEmail'] = maskEmail($row['Email']);
                    $data[] = $row;
                }
            }
        } else {
            echo "Error: " . $conn->error; // Show the SQL error
        }

        // Return the data as JSON
        echo json_encode($data);
        $stmt->close(); // Close prepared statement
    } else if (isset($_GET['adminName'])) {
        $adminID = $_GET['adminID'];

        $sql = "SELECT AdminID, adminName, Email, PhoneNumber FROM tbladminaccount WHERE AdminID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $adminID);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = array();

        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }   
        } else {
            echo "Error: " . $conn->error; // Show the SQL error
        }
        echo json_encode($data); 
    }
}
else if ($requestMethod == "PUT") {
    // Get the raw input data
    $inputData = json_decode(file_get_contents("php://input"), true);

    // Check for JSON decoding errors
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(["status" => "error", "message" => "Invalid JSON input"]);
        exit;
    }

    // Condition for updating general account details
    if (isset($inputData['adminID']) && !isset($inputData['resetPass'])) {
        // Check required fields for account update
        if (isset($inputData['adminID'], $inputData['adminName'], $inputData['adminEmail'], $inputData['adminNumber'])) {
            $adminID     = $inputData['adminID'];
            $adminName   = $inputData['adminName'];
            $email       = $inputData['adminEmail'];
            $phoneNumber = $inputData['adminNumber'];

            $sql = "UPDATE tbladminaccount
                    SET adminName = ?, Email = ?, PhoneNumber = ?
                    WHERE adminID = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sssi', $adminName, $email, $phoneNumber, $adminID);
            $result = $stmt->execute();

            if ($result) {
                // Fetch updated data
                $sql = "SELECT AdminID, adminName, Email, PhoneNumber FROM tbladminaccount WHERE adminID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $adminID);
                $stmt->execute();
                $result = $stmt->get_result();

                $data = $result->fetch_assoc();
                echo json_encode(["status" => "success", "message" => "Successfully Updated", "data" => $data]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error updating data: " . $conn->error]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Missing required fields for account update"]);
        }
    }
    // Condition for resetting the password
        elseif (isset($inputData['resetPass']) && $inputData['resetPass'] === true) {
            // Check required fields for password reset
            if (isset($inputData['adminID'], $inputData['newPassword'])) {
                $adminID     = $inputData['adminID'];
                $newPassword =  password_hash($inputData['newPassword'], PASSWORD_BCRYPT);
            

                $sql = "UPDATE tbladminaccount
                        SET PasswordHash = ?
                        WHERE adminID = ?";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param('si', $newPassword, $adminID);
                $result = $stmt->execute();

                if ($result) {
                    echo json_encode(["status" => "success", "message" => "Password successfully updated"]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Error updating password: " . $conn->error]);
                }
                
            } else {
                echo json_encode(["status" => "error", "message" => "Missing required fields for password reset"]);
            }
        } 
        // Invalid input handling
        else {
            echo json_encode(["status" => "error", "message" => "Invalid input. Please check your data."]);
        }
}
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['role'])) {
        $role = trim($_POST['role']);
        $adminName = trim($_POST['adminName']);
        $adminEmail = trim($_POST['adminEmail']);
        $adminPhoneNumber = trim($_POST['adminPhoneNumber']);
        $adminUsername = trim($_POST['adminUsername']);
        $adminPassword = trim($_POST['adminPassword']);

        if (empty($adminName) || empty($adminEmail) || empty($adminUsername) || empty($adminPassword) || empty($adminPhoneNumber)) {
            echo json_encode(["status" => "error", "message" => "All fields are required."]);
            exit;
        }

        if (!filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["status" => "error", "message" => "Invalid email format."]);
            exit;
        }

        $sqlCheckUsername = "SELECT COUNT(*) FROM tbladminaccount WHERE Username = ?";
        $checkStmt = $conn->prepare($sqlCheckUsername);
        $checkStmt->bind_param('s', $adminUsername);
        $checkStmt->execute();
        $checkStmt->bind_result($usernameCount);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($usernameCount > 0) {
            echo json_encode(["status" => "error", "message" => "Username already exists."]);
            exit;
        }

        $passwordHash = password_hash($adminPassword, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO tbladminaccount (Username, PasswordHash, adminName, Email, PhoneNumber, Role) VALUES (?, ?, ?, ?, ?, ?)");

        if ($stmt) {
            $stmt->bind_param('ssssss', $adminUsername, $passwordHash, $adminName, $adminEmail, $adminPhoneNumber, $role);
            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Admin account created successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to create admin account."]);
            }
            $stmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Database error"]);
        }

        $conn->close();
    }
}




?>
