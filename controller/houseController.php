<?php
include_once('../server/db.php');
$requestMethod = $_SERVER['REQUEST_METHOD'];
if ($_SERVER["REQUEST_METHOD"] == "POST"){
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
