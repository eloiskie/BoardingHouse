

<?php
include_once('../server/db.php');

function login($username, $password) {
    global $conn; // Make sure to use the global connection variable

    try {
        // Trim the username and password to remove extra spaces
        $username = trim($username);
        $password = trim($password);

        // Check if user exists in tbladminaccount
        $stmt = $conn->prepare("SELECT AdminID, PasswordHash FROM tbladminaccount WHERE Username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();

        if ($admin) {
            // Admin found, verify the password
            if (password_verify($password, $admin['PasswordHash'])) {
                // User is an admin
                $_SESSION['user_id'] = $admin['AdminID'];
                $_SESSION['user_role'] = 'admin';
                echo json_encode(['success' => true, 'redirect' => '../view/index.php?user_id=' , 'adminID' => $admin['AdminID']]); 
                exit;
            } else {
                error_log("Failed to verify admin password. Input: $password, Hash: {$admin['PasswordHash']}");
            }
        }

        // Check if user exists in tbltenant
        $stmt = $conn->prepare("SELECT tenantID, userPassword FROM tbltenant WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $tenant = $result->fetch_assoc();

        if ($tenant) {
            // Tenant found, verify the password
            if (password_verify($password, $tenant['userPassword'])) {
                // User is a tenant
                $_SESSION['user_id'] = $tenant['tenantID'];
                $_SESSION['user_role'] = 'tenant';

                echo json_encode(['success' => true, 'redirect' => '../../tenant/view/index.php?user_id=' , 'tenantID' => $tenant['tenantID']]); 
                exit;
            } else {
                error_log("Failed to verify tenant password. Input: $password, Hash: {$tenant['userPassword']}");
            }
        }

        // If we reach here, username/password was incorrect
        echo json_encode(['success' => false, 'message' => 'Invalid username or password.', 'password' => $tenant]);
        exit;

    } catch (mysqli_sql_exception $e) {
        // Log error or handle it accordingly
        error_log("Database error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again later.']);
        exit;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        login($username, $password);
    } else {
        echo json_encode(['success' => false, 'message' => 'Please fill in both username and password.']);
        exit;
    }
}

$conn->close(); // Close the connection if you're done
?>
