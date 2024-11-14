<?php
include_once('../server/db.php');
require_once('../pdf/fpdf.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === 'POST') {
    // Existing logic for retrieving monthly report data
    $inputData = json_decode(file_get_contents("php://input"), true);
    if (isset($inputData['date'])) {
        if (json_last_error() === JSON_ERROR_NONE && isset($inputData['year'], $inputData['month'])) {
            $year = intval($inputData['year']);
            $month = intval($inputData['month']);

            $sql = "SELECT h.houselocation, h.houseID, SUM(p.paymentAmount) AS totalMonthlyIncome
                    FROM tblhouse h
                    JOIN tblroom r ON h.houseID = r.houseID
                    JOIN tbltenant t ON r.roomID = t.roomID
                    JOIN tblpayments p ON t.tenantID = p.tenantID
                    WHERE YEAR(p.paymentDate) = ? AND MONTH(p.paymentDate) = ?
                    GROUP BY h.houselocation
                    ORDER BY h.houselocation";
                    
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ii', $year ,$month);
            $stmt->execute();
            $result = $stmt->get_result();

            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $stmt->close();
            $conn->close();

            echo json_encode(["status" => "success", "data" => $data]);
        }
    }
} elseif ($requestMethod === 'GET') {
    if (isset($_GET['houseID'], $_GET['year'], $_GET['month'])) {
        $houseID = intval($_GET['houseID']);
        $year = intval($_GET['year']);
        $month = intval($_GET['month']);
    
        // SQL query to get tenant names, payment amounts, and house location
        $sql = "SELECT t.tenantName, 
                       SUM(p.paymentAmount) AS total, 
                       p.paymentDate, 
                       h.houselocation 
                FROM tblhouse h 
                JOIN tblroom r ON h.houseID = r.houseID 
                JOIN tbltenant t ON r.roomID = t.roomID 
                JOIN tblpayments p ON t.tenantID = p.tenantID 
                WHERE h.houseID = ? 
                AND YEAR(p.paymentDate) = ? 
                AND MONTH(p.paymentDate) = ? 
                GROUP BY t.tenantName, p.paymentDate, h.houselocation 
                ORDER BY t.tenantName, p.paymentDate";
    
        $stmt = $conn->prepare($sql);
        // Bind parameters to the prepared statement
        $stmt->bind_param("iii", $houseID, $year, $month);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $tenantPayments = [];
        $monthlyIncome = 0;
        $houseLocation = ''; // Initialize variable to avoid undefined error
    
        while ($row = $result->fetch_assoc()) {
            $tenantPayments[] = $row;
            $monthlyIncome += $row['total'];  // Use 'total' from SQL query result
            $houseLocation = $row['houselocation'];
        }
    
        $stmt->close();
    
        // Check if any payments were found
        if (empty($tenantPayments)) {
            echo json_encode(["status" => "error", "message" => "No payments found"]);
            exit;
        }
    
        // Generate the PDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont("Arial", "B", 16);

        $pdf->Cell(190, 10, "Monthly Report", 0, 1, 'C');
    
        // Add house location info to PDF
        $pdf->Cell(190, 10, "House Location: " . $houseLocation, 0, 1, 'C');
    
        // Add table headers for the payments section
        $pdf->Cell(63.33, 10, "Tenant Name", 1, 0, 'C');
        $pdf->Cell(63.33, 10, "Payment Amount", 1, 0, 'C');
        $pdf->Cell(63.33, 10, "Payment Date", 1, 1, 'C');
    
        // Loop through tenant payments and add them to the PDF
        foreach ($tenantPayments as $payment) {
            $pdf->Cell(63.33, 10, $payment['tenantName'], 1, 0);
            $pdf->Cell(63.33, 10,  number_format($payment['total'], 2), 1, 0, 'R');  // Use 'total' for payment amount
            $pdf->Cell(63.33, 10, date('F j, Y', strtotime($payment['paymentDate'])), 1, 1, 'C');
        }
    
        // Add total monthly income to PDF
        $pdf->SetFont("Arial", "B", 14);
        $pdf->Cell(63.33, 10, "Total Monthly Income", 1, 0);
        $pdf->Cell(63.33, 10, number_format($monthlyIncome, 2), 1, 1, 'R');
    
        // Output the PDF to the browser
        $pdf->Output();
    }
}
?>
