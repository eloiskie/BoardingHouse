<?php
include_once('../server/db.php');
    // Helper function to update tenant and room status
   
$requestMethod = $_SERVER['REQUEST_METHOD'];
if ($requestMethod == 'POST') {
    if (isset($_POST['houseID']) && isset($_POST['action'])) {
        $houseID = intval($_POST['houseID']);
        $action = $_POST['action'];
        
        // Define the base SQL query based on the action
        if ($action === 'new') {
            // Query to select available rooms for new action
            $sql = "SELECT r.roomID, r.roomNumber, r.roomType
                    FROM tblroom r
                    WHERE r.houseID = ? AND r.availableStatus = 'available'";
        } else if ($action === 'edit') {
            // Query to select all rooms for edit action without availability check
            $sql = "SELECT r.roomID, r.roomNumber, r.roomType
                    FROM tblroom r
                    WHERE r.houseID = ?";
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid action"]);
            exit;
        }
        
        // Check if the query preparation was successful
        if ($stmt = $conn->prepare($sql)) {
            // Bind the houseID parameter to the prepared statement
            $stmt->bind_param("i", $houseID);  // "i" means the parameter is an integer
            
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
                echo json_encode(["status" => "error", "message" => "Error retrieving data: " . $stmt->error]);
            }
    
            $stmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "SQL error: " . $conn->error]);
        }
    }
    elseif (isset($_POST['tenantName'])) {
        $roomID = $_POST['roomID'];
        $tenantName = $_POST['tenantName'];
        
        // Check for existing username
        $username = $_POST['username'];
        $usernameCheckQuery = $conn->prepare("SELECT tenantID FROM tblTenant WHERE username = ?");
        $usernameCheckQuery->bind_param('s', $username);
        $usernameCheckQuery->execute();
        $usernameCheckResult = $usernameCheckQuery->get_result();
        
        if ($usernameCheckResult->num_rows > 0) {
            echo json_encode(["status" => "error", "message" => "Username already exists. Please choose a different username."]);
            exit;
        }
    
        // Proceed with tenant insertion
        $gender = $_POST['gender'];
        $number = $_POST['number'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $fatherName = $_POST['fatherName'];
        $fatherNumber = $_POST['fatherNumber'];
        $motherName = $_POST['motherName'];
        $motherNumber = $_POST['motherNumber'];
        $emergencyName = $_POST['emergencyName'];
        $emergencyNumber = $_POST['emergencyNumber'];
        $dateStarted = $_POST['dateStarted'];
        $password = $_POST['password'];
        $tenantStatus = "active";
        $roomType = $_POST['roomType'];
        // Hash the password
        $hashedPassword = password_hash(trim($password), PASSWORD_DEFAULT);
    
        $stmt = $conn->prepare("INSERT INTO tblTenant (tenantName, gender, phoneNumber, emailAddress, currentAddress, fatherName, fatherNumber, motherName, motherNumber, emergencyName, emergencyNumber, dateStarted, username, userPassword, tenantStatus, roomID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssssssss", $tenantName, $gender, $number, $email, $address, $fatherName, $fatherNumber, $motherName, $motherNumber, $emergencyName, $emergencyNumber, $dateStarted, $username, $hashedPassword, $tenantStatus, $roomID);
        
        if ($stmt->execute()) {
            // Tenant insertion was successful
            // Update room availability based on roomType
            if ($roomType === 'regular') {
                // For regular room types, set status to Occupied
                $updateRoomStatus = $conn->prepare("UPDATE tblRoom SET availableStatus = 'Occupied' WHERE roomID = ?");
                $updateRoomStatus->bind_param('i', $roomID);
                $updateRoomStatus->execute();
                $updateRoomStatus->close();
            } else {
                // For non-regular room types, count tenants and update status based on capacity
                $tenantCountQuery = $conn->prepare("SELECT COUNT(*) as tenantCount FROM tblTenant WHERE roomID = ? AND tenantStatus = 'active'");
                $tenantCountQuery->bind_param('i', $roomID);
                $tenantCountQuery->execute();
                $tenantCountResult = $tenantCountQuery->get_result();
                $tenantCountData = $tenantCountResult->fetch_assoc();
                $tenantCount = $tenantCountData['tenantCount'];
                $tenantCountQuery->close();
    
                // Fetch room capacity
                $capacityQuery = $conn->prepare("SELECT capacity FROM tblRoom WHERE roomID = ?");
                $capacityQuery->bind_param('i', $roomID);
                $capacityQuery->execute();
                $capacityResult = $capacityQuery->get_result();
                $roomData = $capacityResult->fetch_assoc();
                $roomCapacity = $roomData['capacity'];
                $capacityQuery->close();
    
                // Update room status based on tenant count and room capacity
                $newStatus = ($tenantCount >= $roomCapacity) ? 'Occupied' : 'Available';
                $updateRoomStatus = $conn->prepare("UPDATE tblRoom SET availableStatus = ? WHERE roomID = ?");
                $updateRoomStatus->bind_param('si', $newStatus, $roomID);
                $updateRoomStatus->execute();
                $updateRoomStatus->close();
            }
    
            // Fetch all active tenants along with their room and house details
            $sql = "SELECT t.*, r.*, h.* FROM tblTenant t  
                    JOIN tblRoom r ON t.roomID = r.roomID
                    JOIN tblHouse h ON r.houseID = h.houseID
                    WHERE t.tenantStatus = 'active'";
    
            $fetchAllActiveTenants = $conn->prepare($sql);
            $fetchAllActiveTenants->execute();
            $activeTenantsResult = $fetchAllActiveTenants->get_result();
    
            if ($activeTenantsResult->num_rows > 0) {
                $allTenantsData = [];
                while ($tenantData = $activeTenantsResult->fetch_assoc()) {
                    $allTenantsData[] = $tenantData;
                }
                echo json_encode(["status" => "success", "message" => "Tenant successfully added.", "data" => $allTenantsData]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error fetching tenants data."]);
            }
    
            $fetchAllActiveTenants->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
        }
    
        $stmt->close();
    }
    elseif (isset($_POST['generatePass'])) {
        $length = 8; // Length of the password
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomPassword = '';
            
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[random_int(0, $charactersLength - 1)]; // Use random_int
        }
        echo json_encode(['status' => 'success', 'password' => $randomPassword]);
    } elseif (isset($_POST['query'])) {
        $query = $_POST['query']; // Get the search query for active tenants
        $query = '%' . $query . '%'; // Add wildcards for LIKE query
    
        // Prepare the SQL query to filter active tenants based on the search query
        $sql = "SELECT t.tenantID, t.tenantName, t.phoneNumber, t.emailAddress, r.roomNumber, r.roomType, h.houselocation, t.tenantStatus 
                FROM tblTenant t
                JOIN tblRoom r ON t.roomID = r.roomID
                JOIN tblHouse h ON r.houseID = h.houseID
                WHERE (t.tenantName LIKE ? OR t.phoneNumber LIKE ? OR t.emailAddress LIKE ?) AND t.tenantStatus = 'active'";
    
        // Prepare and bind the parameters
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sss", $query, $query, $query);
    
            // Execute the query
            if ($stmt->execute()) {
                $result = $stmt->get_result();
    
                if ($result->num_rows > 0) {
                    // Fetch the data and return as JSON response
                    $data = [];
                    while ($row = $result->fetch_assoc()) {
                        $data[] = $row;
                    }
                    echo json_encode(["status" => "success", "data" => $data]);
                } else {
                    // No results found
                    echo json_encode(["status" => "success", "message" => "No tenants found."]);
                }
            } else {
                // Error executing query
                echo json_encode(["status" => "error", "message" => "Error executing query."]);
            }
    
            $stmt->close();
        } else {
            // Error preparing query
            echo json_encode(["status" => "error", "message" => "Error preparing query."]);
        }
    } elseif (isset($_POST['queryInactive'])) {
        $query = $_POST['queryInactive']; // Get the search query for inactive tenants
        $query = '%' . $query . '%'; // Add wildcards for LIKE query
    
        // Prepare the SQL query to filter inactive tenants based on the search query
        $sql = "SELECT t.tenantID, t.tenantName, t.phoneNumber, t.emailAddress, r.roomNumber, r.roomType, h.houselocation, t.tenantStatus 
                FROM tblTenant t
                JOIN tblRoom r ON t.roomID = r.roomID
                JOIN tblHouse h ON r.houseID = h.houseID
                WHERE (t.tenantName LIKE ? OR t.phoneNumber LIKE ? OR t.emailAddress LIKE ?) AND t.tenantStatus = 'in-active'";
    
        // Prepare and bind the parameters
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sss", $query, $query, $query);
    
            // Execute the query
            if ($stmt->execute()) {
                $result = $stmt->get_result();
    
                if ($result->num_rows > 0) {
                    // Fetch the data and return as JSON response
                    $data = [];
                    while ($row = $result->fetch_assoc()) {
                        $data[] = $row;
                    }
                    echo json_encode(["status" => "success", "data" => $data]);
                } else {
                    // No results found
                    echo json_encode(["status" => "success", "message" => "No inactive tenants found."]);
                }
            } else {
                // Error executing query
                echo json_encode(["status" => "error", "message" => "Error executing query."]);
            }
    
            $stmt->close();
        } else {
            // Error preparing the query
            echo json_encode(["status" => "error", "message" => "Error preparing the query."]);
        }
        } else {
        echo json_encode(["status" => "error", "message" => "Search query is missing."]);
    }
}    
else if ($requestMethod == 'GET') {
    // Existing GET requests handling
    if (!isset($_GET['houseID']) && !isset($_GET['tenant']) && !isset($_GET['tenantID']) && !isset($_GET['inactiveTenant'])) {
        $sql = "SELECT houseID, houselocation FROM tblHouse";
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
    } else if (isset($_GET['tenant'])) {
        $sql = "SELECT t.*, r.*, h.*
                    FROM tblTenant t  
                    JOIN tblRoom r ON t.roomID = r.roomID
                    JOIN tblHouse h ON r.houseID = h.houseID
                    WHERE tenantStatus = 'active';";

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
    }else if(isset($_GET['tenantID'])){
        $tenantID = intval($_GET['tenantID']);
        $sql = "SELECT t.*, r.*, h.*
                    FROM tblTenant t  
                    JOIN tblRoom r ON t.roomID = r.roomID
                    JOIN tblHouse h ON r.houseID = h.houseID
                WHERE tenantID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $tenantID);
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
    }else if (isset($_GET['inactiveTenant'])) {
        $sql = "SELECT t.*, r.*, h.*
                    FROM tblTenant t  
                    JOIN tblRoom r ON t.roomID = r.roomID
                    JOIN tblHouse h ON r.houseID = h.houseID
                    WHERE tenantStatus = 'Inactive';";

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
else if ($requestMethod == 'DELETE') {
    // Read raw input data
    parse_str(file_get_contents("php://input"), $_DELETE);

    // Check if tenantID and roomID are provided
    if (isset($_DELETE['tenantID']) && isset($_DELETE['roomID'])) {
        $tenantID = intval($_DELETE['tenantID']); 
        $roomID = intval($_DELETE['roomID']);
        $tenantStatus = "Inactive"; // String value for tenant status
        $availableStatus = "Available"; // Status for room availability

        // Construct SQL UPDATE query to set tenant as inactive
        $sql = "UPDATE tbltenant SET tenantStatus = ? WHERE tenantID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $tenantStatus, $tenantID);

        if ($stmt->execute()) {
            // Update room availability if tenant status is successfully set to inactive
            $sqlRoom = "UPDATE tblroom SET availableStatus = ? WHERE roomID = ?";
            $stmtRoom = $conn->prepare($sqlRoom);
            $stmtRoom->bind_param("si", $availableStatus, $roomID);

            if ($stmtRoom->execute()) {
                echo json_encode(["status" => "success", "message" => "Tenant successfully set to inactive and room status updated to available"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error updating room status: " . $stmtRoom->error]);
            }

            $stmtRoom->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Error setting tenant to inactive: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Tenant ID or Room ID not provided"]);
    }

    $conn->close();
}
else if ($requestMethod == 'PUT') {
    $inputData = json_decode(file_get_contents("php://input"), true);
    
    if (isset($inputData['tenant']) && !isset($inputData['active'])) {
        // Ensure all required fields are set
        $requiredFields = [
            'tenantID', 'action', 'oldRoomID', 'tenantName', 'gender', 'phoneNumber', 'emailAddress', 'currentAddress',
            'fatherName', 'fatherNumber', 'motherName', 'motherNumber', 'emergencyName', 'emergencyNumber',
            'dateStarted', 'roomID'
        ];
    
        foreach ($requiredFields as $field) {
            if (!isset($inputData[$field])) {
                echo json_encode(["status" => "error", "message" => "Missing required field: $field"]);
                exit;
            }
        }
    
        // Extract input data
        $tenantID = intval($inputData['tenantID']);
        $oldRoomID = intval($inputData['oldRoomID']);
        $newRoomID = intval($inputData['roomID']);
    
        // Check if oldRoomID is equal to newRoomID; if so, skip room capacity checks
        if ($oldRoomID !== $newRoomID) {
            // Check the room type and capacity, and if it is occupied by an active tenant
            $roomQuery = "SELECT r.roomType, r.capacity 
                          FROM tblroom r 
                          LEFT JOIN tbltenant t ON r.roomID = t.roomID AND t.tenantStatus = 'active' 
                          WHERE r.roomID = ?";
            $stmtRoom = $conn->prepare($roomQuery);
            $stmtRoom->bind_param("i", $newRoomID);
            $stmtRoom->execute();
            $stmtRoom->bind_result($roomType, $capacity);
            $stmtRoom->fetch();
            $stmtRoom->close();
    
            // Check if the roomType is "regular" and if there is already a tenant in that room
            if ($roomType === "regular") {
                $tenantCountQuery = "SELECT COUNT(*) FROM tbltenant WHERE roomID = ? AND tenantStatus = 'active'";
                $stmtTenantCount = $conn->prepare($tenantCountQuery);
                $stmtTenantCount->bind_param("i", $newRoomID);
                $stmtTenantCount->execute();
                $stmtTenantCount->bind_result($tenantCount);
                $stmtTenantCount->fetch();
                $stmtTenantCount->close();
    
                if ($tenantCount > 0) {
                    echo json_encode(["status" => "error", "message" => "This room is already occupied by another tenant."]);
                    exit;
                }
            } else {
                // If roomType is not "regular," check if the number of tenants meets or exceeds capacity
                $tenantCountQuery = "SELECT COUNT(*) FROM tbltenant WHERE roomID = ? AND tenantStatus = 'active'";
                $stmtTenantCount = $conn->prepare($tenantCountQuery);
                $stmtTenantCount->bind_param("i", $newRoomID);
                $stmtTenantCount->execute();
                $stmtTenantCount->bind_result($tenantCount);
                $stmtTenantCount->fetch();
                $stmtTenantCount->close();
    
                if ($tenantCount >= $capacity) {
                    echo json_encode(["status" => "error", "message" => "This room is already occupied by another tenant."]);
                    exit;
                }
            }
        }
    
        // Proceed with updating tenant data if constraints are satisfied or oldRoomID is the same as newRoomID
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
        $dateStarted = $inputData['dateStarted'];
    
        // Update tenant data including roomID
        $updateTenantQuery = "UPDATE tbltenant 
                              SET tenantName = ?, gender = ?, phoneNumber = ?, 
                                  emailAddress = ?, currentAddress = ?, fatherName = ?, 
                                  fatherNumber = ?, motherName = ?, motherNumber = ?, 
                                  emergencyName = ?, emergencyNumber = ?, dateStarted = ?, 
                                  roomID = ?
                              WHERE tenantID = ?";
        
        $stmtUpdateTenant = $conn->prepare($updateTenantQuery);
        if ($stmtUpdateTenant) {
            $stmtUpdateTenant->bind_param("ssssssssssssii", $tenantName, $gender, $phoneNumber, 
                                           $emailAddress, $currentAddress, $fatherName, $fatherNumber, 
                                           $motherName, $motherNumber, $emergencyName, $emergencyNumber, 
                                           $dateStarted, $newRoomID, $tenantID);
    
            if ($stmtUpdateTenant->execute()) {
             // Update availableStatus for oldRoomID if it's different from newRoomID
        if ($oldRoomID !== $newRoomID) {
        // Check the room type and capacity of the old room
        $oldRoomQuery = "SELECT roomType, capacity FROM tblroom WHERE roomID = ?";
        $stmtOldRoom = $conn->prepare($oldRoomQuery);
        $stmtOldRoom->bind_param("i", $oldRoomID);
        $stmtOldRoom->execute();
        $stmtOldRoom->bind_result($oldRoomType, $oldRoomCapacity);
        $stmtOldRoom->fetch();
        $stmtOldRoom->close();

        // Determine the room status based on room type and tenant count
        if ($oldRoomType === "regular") {
            // If room type is "regular", mark as available
            $oldRoomStatus = "available";
        } else {
            // If room type is not "regular", count the active tenants in the room
            $oldRoomTenantCountQuery = "SELECT COUNT(*) FROM tbltenant WHERE roomID = ? AND tenantStatus = 'active'";
            $stmtOldRoomCount = $conn->prepare($oldRoomTenantCountQuery);
            $stmtOldRoomCount->bind_param("i", $oldRoomID);
            $stmtOldRoomCount->execute();
            $stmtOldRoomCount->bind_result($oldRoomTenantCount);
            $stmtOldRoomCount->fetch();
            $stmtOldRoomCount->close();

            // Set status based on tenant count and room capacity
            if ($oldRoomTenantCount < $oldRoomCapacity) {
                // If tenant count is less than capacity, set status to available
                $oldRoomStatus = "available";
            } else {
                // If tenant count is equal to capacity, set status to occupied
                $oldRoomStatus = "occupied";
            }
        }

        // Update the room's availableStatus
        $updateOldRoomStatusQuery = "UPDATE tblroom SET availableStatus = ? WHERE roomID = ?";
        $stmtUpdateOldRoom = $conn->prepare($updateOldRoomStatusQuery);
        $stmtUpdateOldRoom->bind_param("si", $oldRoomStatus, $oldRoomID);
        $stmtUpdateOldRoom->execute();
        $stmtUpdateOldRoom->close();
        }
         // Get the room type and capacity of the new room
                $newRoomTypeQuery = "SELECT roomType, capacity FROM tblroom WHERE roomID = ?";
                $stmtNewRoomType = $conn->prepare($newRoomTypeQuery);
                $stmtNewRoomType->bind_param("i", $newRoomID);
                $stmtNewRoomType->execute();
                $stmtNewRoomType->bind_result($roomType, $capacity);
                $stmtNewRoomType->fetch();
                $stmtNewRoomType->close();

                // Count active tenants in the new room
                $newRoomTenantCountQuery = "SELECT COUNT(*) FROM tbltenant WHERE roomID = ? AND tenantStatus = 'active'";
                $stmtNewRoomTenantCount = $conn->prepare($newRoomTenantCountQuery);
                $stmtNewRoomTenantCount->bind_param("i", $newRoomID);
                $stmtNewRoomTenantCount->execute();
                $stmtNewRoomTenantCount->bind_result($tenantCount);
                $stmtNewRoomTenantCount->fetch();
                $stmtNewRoomTenantCount->close();

                // Determine new room status based on room type and tenant count
                if ($roomType === "regular") {
                    // For "regular" room type, if tenant count is 1 or more, mark as occupied
                    $newRoomStatus = $tenantCount >= 1 ? "occupied" : "available";
                } else {
                    // For non-"regular" rooms, if tenant count reaches capacity, mark as occupied
                    $newRoomStatus = $tenantCount >= $capacity ? "occupied" : "available";
                }

                // Update availableStatus for the new room
                $updateNewRoomStatusQuery = "UPDATE tblroom SET availableStatus = ? WHERE roomID = ?";
                $stmtUpdateNewRoom = $conn->prepare($updateNewRoomStatusQuery);
                $stmtUpdateNewRoom->bind_param("si", $newRoomStatus, $newRoomID);
                $stmtUpdateNewRoom->execute();
                $stmtUpdateNewRoom->close();
    
                echo json_encode(["status" => "success", "message" => "Tenant successfully updated."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error updating tenant: " . $conn->error]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Error preparing update statement: " . $conn->error]);
        }
    
        $conn->close();
    }
    else if (isset($inputData['active'])) {
        // Validate fields when updating tenant's status
        if (!isset($inputData['tenantID'], $inputData['roomID'], $inputData['tenantStatus'])) {
            echo json_encode(["status" => "error", "message" => "Missing tenantID, roomID, or tenantStatus"]);
            exit;
        }
        
        // Extract input data
        $tenantID = $inputData['tenantID'];
        $roomID = $inputData['roomID'];
        $tenantStatus = $inputData['tenantStatus'];
        
        // Check if the room is available
        $checkRoomStatus = "SELECT availableStatus FROM tblroom WHERE roomID = ?";
        $stmtCheck = $conn->prepare($checkRoomStatus);
        $stmtCheck->bind_param("i", $roomID);
        $stmtCheck->execute();
        $stmtCheck->bind_result($currentStatus);
        $stmtCheck->fetch();
        $stmtCheck->close();
        
        if ($currentStatus === 'occupied') {
            echo json_encode(["status" => "error", "message" => "This room is already occupied by another tenant."]);
            exit;
        }
        
      // Proceed to update tenant status in tbltenant
        $updateTenantStatus = "UPDATE tbltenant SET tenantStatus = 'active' WHERE tenantID = ?";
        $stmt = $conn->prepare($updateTenantStatus);
        $stmt->bind_param("i", $tenantID);

        if ($stmt->execute()) {
            // Check the roomType for the room
            $checkRoomType = "SELECT roomType, capacity FROM tblroom WHERE roomID = ?";
            $stmtRoomType = $conn->prepare($checkRoomType);
            $stmtRoomType->bind_param("i", $roomID);
            $stmtRoomType->execute();
            $stmtRoomType->bind_result($roomType, $capacity);
            $stmtRoomType->fetch();
            $stmtRoomType->close();

            // Determine availableStatus based on roomType and tenant count
            if ($roomType === 'regular') {
                // For regular rooms, set availableStatus to 'occupied'
                $availableStatus = 'occupied';
            } else {
                // For non-regular rooms, count the tenants in this room
                $countTenants = "SELECT COUNT(*) AS tenantCount FROM tbltenant WHERE roomID = ? AND tenantStatus = 'active'";
                $stmtCount = $conn->prepare($countTenants);
                $stmtCount->bind_param("i", $roomID);
                $stmtCount->execute();
                $stmtCount->bind_result($tenantCount);
                $stmtCount->fetch();
                $stmtCount->close();

                // Set availableStatus based on tenant count and room capacity
                if ($tenantCount >= $capacity) {
                    $availableStatus = 'occupied';
                } else {
                    $availableStatus = 'available';
                }
            }

            // Update availableStatus in tblroom based on the logic above
            $updateRoomStatus = "UPDATE tblroom SET availableStatus = ? WHERE roomID = ?";
            $stmtRoom = $conn->prepare($updateRoomStatus);
            $stmtRoom->bind_param("si", $availableStatus, $roomID);

            if ($stmtRoom->execute()) {
                echo json_encode(["status" => "success", "message" => "Tenant and room status updated successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to update room status."]);
            }

            $stmtRoom->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update tenant status."]);
        }

        $stmt->close();
    }
    
}
  


?>