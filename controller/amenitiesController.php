<?php
include_once('../server/db.php');
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == 'GET') {
    if (!isset($_GET['houseID'])&& !isset($_GET['amenities'])) {
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
    }else if (isset($_GET['amenities'])) {
        $sql = "SELECT * FROM tblamenities a
               JOIN tbltenant t ON a.tenantID = t.tenantID";

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
} else if ($requestMethod == 'POST') {
    if (isset($_POST['roomID']) && !isset($_POST['tenantID'])) {
        $roomID = intval($_POST['roomID']);
        $sql = "SELECT tenantID, tenantName FROM tblTenant WHERE roomID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $roomID);
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
    } else if (isset($_POST['tenantID'])) {
        $electricBill = $_POST['electricBill'];
        $waterBill = $_POST['waterBill'];
        $monthReading = $_POST['monthReading'];
     
        $tenantID = intval($_POST['tenantID']);
        
        // Insert data using prepared statements
        $stmt = $conn->prepare("INSERT INTO tblAmenities (electricBill, waterBill, monthReading, tenantID) VALUES (?, ?, ?, ?)");
        
        if ($stmt === false) {
            echo json_encode(["status" => "error", "message" => "Error preparing statement: " . $conn->error]);
            exit;
        }

        $stmt->bind_param('ddsi', $electricBill, $waterBill, $monthReading, $tenantID);

        if ($stmt->execute()) {
            $totalBill = $electricBill + $waterBill;
            $updateStmt = $conn->prepare("UPDATE tblTenant SET balance = balance + ? WHERE tenantID = ?");
            
            if ($updateStmt === false) {
                echo json_encode(["status" => "error", "message" => "Error preparing update statement: " . $conn->error]);
                exit;
            }

            $updateStmt->bind_param('di', $totalBill, $tenantID);
    
            if ($updateStmt->execute()) {
                $sql = "SELECT * FROM tblAmenities a
                        JOIN tbltenant t ON a.tenantID = t.tenantID";
                $selectResult = $conn->query($sql);

                if ($selectResult) {
                    $data = array();
                    if ($selectResult->num_rows > 0) {
                        while ($row = $selectResult->fetch_assoc()) {
                            $data[] = $row;
                        }
                    }
                    echo json_encode(["status" => "success", "message" => "Amenities Successfully Added", "data" => $data]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Error updating balance: " . $updateStmt->error]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Error inserting amenities: " . $stmt->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Required parameters missing"]);
    }
}

$conn->close();
?>
