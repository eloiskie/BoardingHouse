<?php
include_once('../server/db.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === "GET") {
    if (isset($_GET['tenantID']) && !isset($_GET['dueDate'])) {
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
    elseif (isset($_GET['dueDate']) && isset($_GET['tenantID'])) {
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
    } else {
        echo json_encode(["status" => "error", "message" => "Missing tenantID or dueDate parameters."]);
    }
}

    else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Capture the POST variables
        $tenantID = $_POST['tenantID'];
        $paymentBasis = $_POST['paymentBasis'];
        $partialPaymentDate = isset($_POST['partialPaymentDate']) ? $_POST['partialPaymentDate'] : null;

        // Handle partial payments
        if ($paymentBasis === 'payment') {
            $paymentDetails = json_decode($_POST['paymentDetails'], true);

            // Prepare your SQL query to insert payment details
            foreach ($paymentDetails as $detail) {
                $paymentDetailsID = $detail['paymentDetailsID'];
                $partialPaymentAmount = $detail['partialPaymentAmount'];

                // Prepare the statement (Assuming you have a PDO connection)
                $stmt = $conn->prepare("INSERT INTO tblpayments (tenantID, paymentDetailsID, paymentAmount, paymentDate) VALUES (?, ?, ?, ?)");
                if ($stmt === false) {
                    error_log("SQL prepare failed: " . $conn->error); // Log the error
                    echo json_encode(["status" => "error", "message" => "SQL prepare failed: " . $conn->error]);
                    exit;
                }

                // Bind parameters and execute the query
                $stmt->bind_param("iids", $tenantID, $paymentDetailsID, $partialPaymentAmount, $partialPaymentDate); // Adjust types as needed

                if (!$stmt->execute()) {
                    
                    error_log("Database error: " . $stmt->error); // Log the error
                    $response['status'] = 'error';
                    $response['message'] = 'Database error: ' . $stmt->error;
                    echo json_encode($response);
                    exit();
                }
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid payment basis.']);
            exit();
        }

        // Return success response
        $response['status'] = 'success';
        $response['message'] = 'Payment processed successfully.';
        echo json_encode($response);
    }



?>
