<?php
include_once('../server/db.php');
$requestMethod = $_SERVER['REQUEST_METHOD'];
if($requestMethod == "DELETE"){
    parse_str(file_get_contents("php://input"), $_DELETE);

    if(isset($_DELETE['houseID'])){
        $houseID= intval($_DELETE['houseID']);

        $sql="DELETE FROM tblhouse WHERE houseID = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $houseID);
        if($stmt->execute()){
            echo json_encode(["status" => "success", "message" => "Successfully House Deleted."]);
        }else{
            echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
        }
        $stmt->close();
    }
}
else if($requestMethod =='PUT'){
    $inputData = json_decode(file_get_contents("php://input"), true);

    // Check for JSON errors and the required fields
    // Fixed typo: changed $inputDate to $inputData in the isset check
    if(json_last_error() === JSON_ERROR_NONE && isset($inputData['houseID'], $inputData['houselocation'], $inputData['houseAddress'], $inputData['numberOfRoom'])) {
        $houseID        = intval($inputData['houseID']);
        $houselocation  = $inputData['houselocation'];
        $houseAddress   = $inputData['houseAddress'];
        $numberOfRoom   = intval($inputData['numberOfRoom']);

        // Prepare SQL statement
        $sql = "UPDATE tblHouse
                SET houselocation = ?, houseAddress = ?, numberOfRoom =?
                WHERE houseID = ?";
        $stmt = $conn->prepare($sql);

        if($stmt) {
            // Bind parameters
            $stmt->bind_param("ssii", $houselocation, $houseAddress, $numberOfRoom, $houseID);

            // Execute statement
            if($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => "House Successfully Updated."]);
            } else {
                // If statement execution fails, return error
                echo json_encode(['status' => 'error', 'message' => "Error: " . $conn->error]);
            }
        } else {
            // Return error if statement preparation fails
            echo json_encode(['status' => 'error', 'message' => "Failed to prepare SQL statement."]); // <-- Added this error response
        }
    } else {
        // If JSON decoding fails or required fields are missing
        echo json_encode(['status' => 'error', 'message' => "Invalid input data. Please ensure all fields are filled correctly."]);
    }
}

else if ($requestMethod == "POST"){
    $house_location = $_POST['inputHouse-location'];
    $house_address = $_POST['inputHouse-address'];
    $numberOf_rooms = $_POST['inputNumberOf-rooms'];

    // Prepare SQL statement
    $sql = "INSERT INTO tblhouse (houselocation, houseAddress, numberOfRoom) VALUES ('{$house_location}', '{$house_address}', '{$numberOf_rooms}')";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        // Retrieve data after insertion if needed
        $selectResult = $conn->query("SELECT * FROM tblhouse WHERE houselocation = '{$house_location}'");

        // Process and return JSON response
        $data = array();
        if ($selectResult->num_rows > 0) {
            while ($row = $selectResult->fetch_assoc()) {
                $data[] = $row;
            }
        }
        echo json_encode(["status" => "success", "message" => "Room Successfully Added", "data" => $data]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
    }

    // Close connection
    $conn->close();
}

else if($requestMethod == "GET"){
    $sql = "SELECT * FROM tblhouse";
    $result = $conn->query($sql);

    $data = array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
            
        }
    }
   
    echo json_encode($data);
  
}

    else if(isset($_POST['houseID'])) {
        // Retrieve houseID from POST data
        $houseID = $_POST['houseID'];
        
        // Store houseID in session (example)
        $_SESSION['houseID'] = $houseID;
        
        // Return a response if needed
        echo 'Data received successfully';
    } else {
        // Handle case where houseID is not received
        echo 'houseID not found in POST data';
    }

?>
