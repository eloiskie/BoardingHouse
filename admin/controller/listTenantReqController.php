<?php
include_once('../server/db.php'); // Only include the DB connection once
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === 'GET') {
    if (isset($_GET['tenantID']) && !isset($_GET['requestID']) && !isset($_GET['processingRequest'])) {
        $tenantID = intval($_GET['tenantID']);

        $sql = "SELECT *, 
                    DATE(requestDate) AS requestDate,
                    DATE_FORMAT(requestDate, '%r') AS requestTime
                FROM tblmaintenancerequest
                WHERE tenantID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $tenantID);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $stmt->close();
        echo json_encode($data);
    } elseif (isset($_GET['requestID']) && !isset($_GET['processingRequest'])) {
        $requestID = intval($_GET['requestID']);

        $sql = "SELECT * FROM tblmaintenancerequest WHERE requestID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $requestID);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();

            // Update the status only if it's not 'In Progress' or 'Completed'
            if (!in_array($data['requestStatus'], ['In Progress', 'Completed'])) {
                $updateSql = "UPDATE tblmaintenancerequest SET requestStatus = 'Received' WHERE requestID = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("i", $requestID);
                $updateStmt->execute();
                $updateStmt->close();

                // Update the data array with the new status
                $data['requestStatus'] = 'Received';
            }
        } else {
            echo "No record found for the provided requestID.";
        }

        $stmt->close();
        echo json_encode($data);
    } elseif (isset($_GET['processingRequest']) && isset($_GET['tenantID']) && isset($_GET['requestID'])) {
        $tenantID = intval($_GET['tenantID']);
        $requestID = intval($_GET['requestID']);

        $sql = "SELECT *, 
                    DATE(requestDate) AS requestDate,
                    DATE_FORMAT(requestDate, '%r') AS requestTime
                FROM tblmaintenancerequest
                WHERE tenantID = ? AND requestID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $tenantID, $requestID);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $stmt->close();
        echo json_encode($data);
    }
    
    $conn->close();
}
else if ($requestMethod === 'PUT') {
    // Reading and decoding JSON input data
    $inputData = json_decode(file_get_contents("php://input"), true);
    if(isset($inputData['inProgress']) && !isset($inputData['completed'])){
    // Validate if the input contains required fields
    if (json_last_error() === JSON_ERROR_NONE && isset($inputData['requestStatus'], $inputData['requestID'])) {
        $requestStatus = intval($inputData['requestStatus']);
        $requestID = intval($inputData['requestID']);

        // SQL query to update the maintenance request status
        $updateSql = "UPDATE tblmaintenancerequest SET requestStatus = ? WHERE requestID = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ii", $requestStatus, $requestID);

        // Execute the update query
        if ($updateStmt->execute()) {
            // After updating, fetch the updated status
            $selectUpdatedSql = "SELECT requestStatus FROM tblmaintenancerequest WHERE requestID = ?";
            $selectStmt = $conn->prepare($selectUpdatedSql);
            $selectStmt->bind_param("i", $requestID);
            $selectStmt->execute();
            $updatedResult = $selectStmt->get_result();

            $data = [];
            if ($updatedResult->num_rows > 0) {
                while($row = $updatedResult->fetch_assoc()){
                    $data[] = $row; // Store the updated status
                }
            }

            // If data is found, return the success response
            echo json_encode([
                "status" => "success", 
                "message" => "Maintenance Request is In Progress", 
                "data" => $data
            ]);
        } else {
            // Error updating the request status
            echo json_encode([
                "status" => "error",
                "message" => "Failed to update request status."
            ]);
            http_response_code(500);
        }
    } else {
        // Invalid input, return 400
        echo json_encode([
            "status" => "error",
            "message" => "Invalid input data. Please provide both requestID and requestStatus."
        ]);
        http_response_code(400);
    }
    }
    else if (isset($inputData['completed'])){
        // Validate if the input contains required fields
    if (json_last_error() === JSON_ERROR_NONE && isset($inputData['requestStatus'], $inputData['requestID'])) {
        $requestStatus = intval($inputData['requestStatus']);
        $requestID = intval($inputData['requestID']);

        // SQL query to update the maintenance request status
        $updateSql = "UPDATE tblmaintenancerequest SET requestStatus = ? WHERE requestID = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ii", $requestStatus, $requestID);

        // Execute the update query
        if ($updateStmt->execute()) {
            // After updating, fetch the updated status
            $selectUpdatedSql = "SELECT requestStatus FROM tblmaintenancerequest WHERE requestID = ?";
            $selectStmt = $conn->prepare($selectUpdatedSql);
            $selectStmt->bind_param("i", $requestID);
            $selectStmt->execute();
            $updatedResult = $selectStmt->get_result();

            $data = [];
            if ($updatedResult->num_rows > 0) {
                while($row = $updatedResult->fetch_assoc()){
                    $data[] = $row; // Store the updated status
                }
            }

            // If data is found, return the success response
            echo json_encode([
                "status" => "success", 
                "message" => "Maintenance Request is Completed", 
                "data" => $data
            ]);
        } else {
            // Error updating the request status
            echo json_encode([
                "status" => "error",
                "message" => "Failed to update request status."
            ]);
            http_response_code(500);
        }
    } else {
        // Invalid input, return 400
        echo json_encode([
            "status" => "error",
            "message" => "Invalid input data. Please provide both requestID and requestStatus."
        ]);
        http_response_code(400);
    }
    }
}


?>
