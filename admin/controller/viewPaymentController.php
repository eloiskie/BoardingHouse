<?php
include_once('../server/db.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === "GET") {
    if (isset($_GET['tenantID']) && !isset($_GET['dueDate']) && !isset($_GET['paymentList'])) {
        $tenantID = intval($_GET['tenantID']); // tenantID passed from AJAX
    
        // SQL query to select charges grouped by dueDate for the given tenant
        $sql = "
        SELECT 
            cd.dueDate, 
            GROUP_CONCAT(pc.paymentType SEPARATOR '<br>') AS paymentTypes, 
            GROUP_CONCAT(cd.paymentTypeID SEPARATOR '<br>') AS paymentTypeIDs, 
            GROUP_CONCAT(cd.paymentDetailsID SEPARATOR '<br>') AS paymentDetailsIDs, 
            SUM(cd.amount) AS totalAmount, 
            COALESCE(SUM(pd.totalPayments), 0) AS totalPayments, 
            SUM(cd.amount) - COALESCE(SUM(pd.totalPayments), 0) AS remainingBalance 
        FROM 
            tblchargesDetails cd 
        JOIN 
            tblpaymentType pc ON cd.paymentTypeID = pc.paymentTypeID 
        LEFT JOIN (
            SELECT 
                tenantID, 
                paymentDetailsID,
                SUM(paymentAmount) AS totalPayments
            FROM 
                tblPayments 
            GROUP BY 
                tenantID, paymentDetailsID
        ) pd ON cd.tenantID = pd.tenantID AND cd.paymentDetailsID = pd.paymentDetailsID
        WHERE 
            cd.tenantID = ? 
        GROUP BY 
            cd.dueDate;
        ";
    
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            error_log("SQL prepare failed: " . $conn->error); // Log the error for debugging
            echo json_encode(["status" => "error", "message" => "SQL prepare failed: " . $conn->error]);
            exit;
        }
    
        // Bind the tenantID parameter
        $stmt->bind_param("i", $tenantID); // only one tenantID
    
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $data = array();
    
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Format the charge types
                    $row['paymentTypes'] = '<ul><li>' . str_replace('<br>', '</li><li>', $row['paymentTypes']) . '</li></ul>';
                    
                    // Split paymentTypeIDs and paymentDetailsIDs into arrays
                    $row['paymentTypeIDs'] = explode('<br>', $row['paymentTypeIDs']);
                    $row['paymentDetailsIDs'] = explode('<br>', $row['paymentDetailsIDs']); // Split paymentDetailsIDs
                    
                    $data[] = $row;
                }
                echo json_encode(["status" => "success", "data" => $data]);
            } else {
                echo json_encode(["status" => "success", "data" => []]);
            }
        } else {
            error_log("Error executing query: " . $stmt->error); // Log the error
            echo json_encode(["status" => "error", "message" => "Error executing query: " . $stmt->error]);
        }
    
        $stmt->close();
    } 
    elseif (isset($_GET['pay'])) {
        $dueDate = $_GET['dueDate'];
        $tenantID = intval($_GET['tenantID']);
    
        // SQL query to get payment types for a specific due date and tenant, along with the balance
            $sql = "SELECT 
                    ct.paymentTypeID,
                    pt.paymentType,
                    ct.amount,
                    ct.paymentDetailsID,
                    COALESCE(SUM(p.paymentAmount), 0) AS totalPaid,
                    (ct.amount - COALESCE(SUM(p.paymentAmount), 0)) AS balance
                FROM 
                    tblchargesDetails ct
                JOIN 
                    tblpaymentType pt ON ct.paymentTypeID = pt.paymentTypeID
                LEFT JOIN 
                    tblpayments p ON ct.paymentDetailsID = p.paymentDetailsID
                WHERE 
                    ct.tenantID = ? 
                    AND ct.dueDate = ?
                GROUP BY 
                    ct.paymentDetailsID;";

        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            error_log("SQL prepare failed: " . $conn->error); // Log the error for debugging
            echo json_encode(["status" => "error", "message" => "SQL prepare failed: " . $conn->error]);
            exit;
        }
    
        // Bind the tenantID and dueDate parameters
        $stmt->bind_param("is", $tenantID, $dueDate);
    
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $data = array();
    
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
                echo json_encode(["status" => "success", "data" => $data]);
            } else {
                echo json_encode(["status" => "success", "data" => []]);
            }
        } else {
            error_log("Error executing query: " . $stmt->error); // Log the error
            echo json_encode(["status" => "error", "message" => "Error executing query: " . $stmt->error]);
        }
    
        $stmt->close();
    } elseif (isset($_GET['paymentList'])) {
        // Check if parameters are set
        if (isset($_GET['tenantID']) && isset($_GET['dueDate'])) {
            $tenantID = intval($_GET['tenantID']); // Ensure tenantID is an integer
            $dueDate = $_GET['dueDate']; // Get due date as a string
    
            error_log("tenantID: $tenantID, dueDate: $dueDate"); // Debugging output
    
            // SQL query to get the list of payments for the specified tenant and due date
            $sql = "
                SELECT 
                    cd.paymentDetailsID,  -- Add paymentDetailsID to the SELECT clause
                    pt.paymentType AS PaymentType, 
                    IFNULL(cd.amount, '-') AS Amount, 
                    IFNULL(cd.dueDate, '-') AS DueDate, 
                    IFNULL(p.paymentDate, '-') AS PaymentDate, 
                    IFNULL(p.paymentAmount, '-') AS PaymentAmount, 
                    IFNULL((cd.amount - COALESCE(totalPayments.totalPaymentAmount, 0)), '-') AS Balance 
                FROM 
                    tblchargesdetails cd 
                JOIN 
                    tblpaymenttype pt ON cd.paymentTypeID = pt.paymentTypeID 
                LEFT JOIN 
                    tblpayments p ON cd.paymentDetailsID = p.paymentDetailsID 
                LEFT JOIN (
                    SELECT 
                        paymentDetailsID, 
                        SUM(paymentAmount) AS totalPaymentAmount 
                    FROM 
                        tblpayments 
                    GROUP BY 
                        paymentDetailsID
                ) AS totalPayments ON cd.paymentDetailsID = totalPayments.paymentDetailsID 
                WHERE 
                    cd.dueDate = ? 
                    AND cd.tenantID = ?
                ";
    
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                error_log("SQL prepare failed: " . $conn->error);
                echo json_encode(["status" => "error", "message" => "SQL prepare failed: " . $conn->error]);
                exit;
            }
            
            // Bind parameters (dueDate as string, tenantID as integer)
            $stmt->bind_param("si", $dueDate, $tenantID);
    
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $data = array();
    
                // Check if results are returned
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $data[] = $row;
                    }
                    echo json_encode(["status" => "success", "data" => $data]);
                } else {
                    echo json_encode(["status" => "success", "data" => []]); // No data found
                }
            } else {
                error_log("Error executing query: " . $stmt->error); // Log the error
                echo json_encode(["status" => "error", "message" => "Error executing query: " . $stmt->error]);
            }
    
            $stmt->close(); // Close statement
        } else {
            echo json_encode(["status" => "error", "message" => "Missing tenantID or dueDate parameters."]);
        }
    }
    
} 
    
elseif ($requestMethod === 'POST') {
    // Capture the POST variables
    $tenantID = $_POST['tenantID'] ?? null; // Use null coalescing operator
    $paymentBasis = $_POST['paymentBasis'] ?? null;
    $partialPaymentDate = $_POST['partialPaymentDate'] ?? null;

    // Validate inputs
    if (!$tenantID || !$paymentBasis) {
        echo json_encode(['status' => 'error', 'message' => 'Missing tenant ID or payment basis.']);
        exit;
    }

    // Handle partial payments
    if ($paymentBasis === 'payment') {
        $paymentDetails = json_decode($_POST['paymentDetails'], true);
        if (empty($paymentDetails)) {
            echo json_encode(['status' => 'error', 'message' => 'Payment details are empty.']);
            exit;
        }

        // Prepare your SQL query to insert payment details
        foreach ($paymentDetails as $detail) {
            $paymentDetailsID = $detail['paymentDetailsID'];
            $partialPaymentAmount = $detail['partialPaymentAmount'];

            // Prepare the statement
            $stmt = $conn->prepare("INSERT INTO tblpayments (tenantID, paymentDetailsID, paymentAmount, paymentDate) VALUES (?, ?, ?, ?)");
            if ($stmt === false) {
                error_log("SQL prepare failed: " . $conn->error);
                echo json_encode(["status" => "error", "message" => "SQL prepare failed: " . $conn->error]);
                exit;
            }

            // Bind parameters and execute the query
            $stmt->bind_param("iids", $tenantID, $paymentDetailsID, $partialPaymentAmount, $partialPaymentDate);
            if (!$stmt->execute()) {
                error_log("Database error: " . $stmt->error);
                echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $stmt->error]);
                exit();
            }
        }
        echo json_encode(['status' => 'success', 'message' => 'Payment successfully added.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid payment basis.']);
    }
}
else if ($requestMethod === 'PUT') {
    // Get the JSON input
    $inputData = json_decode(file_get_contents('php://input'), true);

    // Extract parameters with null coalescing for missing keys
    $paymentDetailsID = $inputData['paymentDetailsID'] ?? null;
    $paymentType = $inputData['paymentType'] ?? null;
    $amount = $inputData['amount'] ?? null;
    $tenantID = $inputData['tenantID'] ?? null;
    $dueDate = $inputData['dueDate'] ?? null; // Ensure dueDate is provided
    
    // Validate dueDate format if provided
    if ($dueDate) {
        // Check if the date format is correct (YYYY-MM-DD)
        $date = DateTime::createFromFormat('Y-m-d', $dueDate);
        if (!$date || $date->format('Y-m-d') !== $dueDate) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid date format for dueDate. Please use YYYY-MM-DD.']);
            exit();
        }
    }

    // If only year is provided, append '-01-01' to make it a full date
    if ($dueDate && strlen($dueDate) === 4) {
        $dueDate .= '-01-01';
    }

    // Prepare SQL update query
    $query = "
        UPDATE tblchargesdetails 
        SET 
            paymentTypeID = (SELECT paymentTypeID FROM tblpaymenttype WHERE paymentType = ?), 
            amount = ?, 
            dueDate = ?
        WHERE 
            paymentDetailsID = ? AND tenantID = ?
    ";

    if ($stmt = $conn->prepare($query)) {
        // Bind parameters
        $stmt->bind_param('ssdis', $paymentType, $amount, $dueDate, $paymentDetailsID, $tenantID);
    
        // Execute the query
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Payment details updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update payment details', 'error' => $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error preparing query', 'error' => $conn->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

// Close the database connection
$conn->close();


?>
