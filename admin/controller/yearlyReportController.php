<?php
include_once('../server/db.php');
require_once('../pdf/fpdf.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === 'POST') {
    // Existing logic for retrieving monthly report data
    $inputData = json_decode(file_get_contents("php://input"), true);
    if (isset($inputData['date'])) {
        if (json_last_error() === JSON_ERROR_NONE && isset($inputData['year'])) {
            $year = intval($inputData['year']);
          
            $sql = "SELECT h.houselocation, h.houseID, SUM(p.paymentAmount) AS totalMonthlyIncome
                    FROM tblhouse h
                    JOIN tblroom r ON h.houseID = r.houseID
                    JOIN tbltenant t ON r.roomID = t.roomID
                    JOIN tblpayments p ON t.tenantID = p.tenantID
                    WHERE YEAR(p.paymentDate) = ? 
                    GROUP BY h.houselocation
                    ORDER BY h.houselocation";
                    
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $year);
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
}elseif ($requestMethod === 'GET') {
    if (isset($_GET['houseID'], $_GET['year'])) {
        $houseID = intval($_GET['houseID']);
        $year = intval($_GET['year']);
    
        // SQL query to get house location, month, and total payment
        $sql = "SELECT
                    h.houselocation,
                    MONTH(p.paymentDate) AS month,
                    SUM(p.paymentAmount) AS total
                FROM
                    tblpayments p
                JOIN
                    tblchargesdetails cd ON p.paymentDetailsID = cd.paymentDetailsID
                JOIN
                    tbltenant t ON cd.tenantID = t.tenantID
                JOIN
                    tblroom r ON t.roomID = r.roomID
                JOIN
                    tblhouse h ON r.houseID = h.houseID
                WHERE
                    h.houseID = ? AND YEAR(p.paymentDate) = ?
                GROUP BY
                    h.houselocation,
                    MONTH(p.paymentDate)
                ORDER BY
                    month;";

        $stmt = $conn->prepare($sql);
        // Bind parameters to the prepared statement
        $stmt->bind_param("ii", $houseID, $year);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $paymentData = [];
        $totalIncome = 0;
        $houseLocation = ''; // Initialize variable to avoid undefined error
    
        while ($row = $result->fetch_assoc()) {
            $paymentData[] = $row;
            $totalIncome += $row['total'];  // Sum of total payments for the year
            $houseLocation = $row['houselocation'];
        }
    
        $stmt->close();
    
        // Check if any payments were found
        if (empty($paymentData)) {
            echo json_encode(["status" => "error", "message" => "No payments found"]);
            exit;
        }
    
        // Generate the PDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont("Arial", "B", 16);
    
        // Add house location info to PDF
        $pdf->Cell(190, 10, "Yearly Report", 0, 1, 'C');
        $pdf->Cell(190, 10, "House Location: " . $houseLocation, 0, 1, 'C');
    
        // Add table headers for the payments section
        $pdf->Cell(95, 10, "Month", 1, 0, 'C');
        $pdf->Cell(95, 10, "Total Payment", 1, 1, 'C');
    
        // Loop through payment data and add it to the PDF
        foreach ($paymentData as $payment) {
            $pdf->Cell(95, 10, date('F', mktime(0, 0, 0, $payment['month'], 1, $year)), 1, 0, 'C');
            $pdf->Cell(95, 10, number_format($payment['total'], 2), 1, 1, 'R');
        }
    
        // Add total yearly income to PDF
        $pdf->SetFont("Arial", "B", 14);
        $pdf->Cell(95, 10, "Total Yearly Income", 1, 0);
        $pdf->Cell(95, 10, number_format($totalIncome, 2), 1, 1, 'R');
    
        // Output the PDF to the browser
        $pdf->Output();
    }
}
?>
