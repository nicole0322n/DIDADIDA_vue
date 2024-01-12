
<?php
// 資料庫資料全撈 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once("connect.php"); 

// if ($_SERVER["REQUEST_METHOD"] === "POST") { 
// }

try {
    $sql = "SELECT * FROM activity";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
} catch (PDOException $e) {
    $response = array('error' => true, 'msg' => '獲取管理員數據失敗: ' . $e->getMessage());
    echo json_encode($response);
}

// 關閉連接
$pdo = null;
?>