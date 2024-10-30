<?php
include_once('../server/db.php');


function isCodeExpired($conn, $code, $email) {
    // Prepare the statement
    $stmt = $conn->prepare("SELECT expires_at FROM tblpassreset WHERE emailCode = ? AND userEmail = ?");

    if (!$stmt) {
        error_log("SQL Error: " . $conn->error);
        return true; // Consider it expired since the query failed
    }

    // Bind parameters
    $stmt->bind_param("ss", $code, $email);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result()->fetch_assoc();

    if ($result) {
        // Check if the expiration date is in the past
        $expiresAt = new DateTime($result['expires_at']);
        $now = new DateTime();
        error_log("Current Time: " . $now->format('Y-m-d H:i:s'));
        error_log("Expires At: " . $expiresAt->format('Y-m-d H:i:s'));

        return $now > $expiresAt; // Returns true if expired
    }

    return true; // Code not found, consider it expired
}

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === 'POST' && isset($_REQUEST['emailCode']) && isset($_REQUEST['userEmail'])) {
    $emailCode = $_REQUEST['emailCode'];
    $userEmail = $_REQUEST['userEmail'];

    // Check if the code is expired
    if (isCodeExpired($conn, $emailCode, $userEmail)) {
        echo json_encode([
            "status" => "error",
            "message" => "The verification code has expired or is invalid.",
        ]);
    } else {
        echo json_encode([
            "status" => "success",
            "message" => "The verification code is valid.",
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Please provide both code and email.",
    ]);
}
?>
