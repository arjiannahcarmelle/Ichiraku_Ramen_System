<?php
require_once 'config.php';
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sql'])) {
    $encryptedSQL = $_POST['sql'];
    $decodedSQL = base64_decode($encryptedSQL);
    try {
        if (!$conn) {
            throw new Exception("Database connection failed");
        }
        //user confirmation
        mysqli_query($conn, $decodedSQL);
        echo json_encode([
            'status' => 'success',
            'sql_executed' => $decodedSQL
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage(),
            'sql_attempted' => $decodedSQL
        ]);
    }
    exit;
}
?>