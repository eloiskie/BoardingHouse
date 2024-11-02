<?php
// Include Composer's autoload file

// Include database connection
include_once('../server/db.php');

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpMailer/src/Exception.php';
require '../phpMailer/src/PHPMailer.php';
require '../phpMailer/src/SMTP.php';

// Function to send the reset email
function sendResetEmail($email, $code) {
    $mail = new PHPMailer(true);
    
    try {
        // Enable SMTP and set the SMTP server details
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'alegradojohnloi@gmail.com';
        $mail->Password = 'boul kusb esmy ipet'; // Consider using environment variables for sensitive data
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('verificationCode@gmail.com', 'BoardingHouse');
        $mail->addAddress($email);
        $mail->Subject = 'Password Reset Verification Code';
        $mail->Body    = "Your verification code is: $code";

        // Send the email
        $mail->send();
        echo json_encode(["status" => "success", "message" => "Verification code sent to your email!"]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Email could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
}

// Check request method
$requestMethod = $_SERVER['REQUEST_METHOD'];
if ($requestMethod === 'POST') {
    $email = $_POST['email'];

    // Check for an existing, non-expired code in the database
    $stmt = $conn->prepare("SELECT emailCode, expires_at FROM tblpassreset WHERE userEmail = ? AND expires_at > NOW()");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // If a non-expired code exists, fetch it and calculate remaining time
            $stmt->bind_result($existingCode, $expiresAt);
            $stmt->fetch();
            
            // Get current time in 'H:i:s' format
            $currentTime = date('H:i:s');
            
            // Convert both times to seconds since midnight
            $expiresAtSeconds = strtotime($expiresAt);
            $currentTimeSeconds = strtotime($currentTime);
            
            // Calculate remaining time in seconds
            $remainingTime = $expiresAtSeconds - $currentTimeSeconds;
            
            // Ensure remaining time is not negative
            $remainingTime = max($remainingTime, 0);
            
            // Convert remaining time to minutes
            $minutesLeft = floor($remainingTime / 60);
            
            echo json_encode([
                "status" => "exist",
                "message" => "A valid code already exists.",
                "minutes_left" => $minutesLeft,
                "expires_at" => $expiresAt
            ]);
        }
     else {
        // If no valid code exists, generate a new verification code
        $code = rand(100000, 999999);

        // Get current MySQL time directly
        $stmtCurrentTime = $conn->prepare("SELECT NOW()");
        $stmtCurrentTime->execute();
        $stmtCurrentTime->bind_result($currentTime);
        $stmtCurrentTime->fetch();
        $stmtCurrentTime->close();
        
        // Calculate expiration time, 5 minutes from now
        $expiresAt = date('Y-m-d H:i:s', strtotime($currentTime . ' +5 minutes')); 
        
        // Insert the new code into the database
        $stmt = $conn->prepare("INSERT INTO tblpassreset (userEmail, emailCode, expires_at, created_at) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $email, $code, $expiresAt, $currentTime); // Binding parameters as strings
        
        if ($stmt->execute()) {
            // Send the reset email with the new code
            sendResetEmail($email, $code);
        } else {
            echo json_encode(["error" => "Error inserting data into the database."]);
        }
    }
    $stmt->close();
}
?>
