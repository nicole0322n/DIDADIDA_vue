<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");



require_once("connect.php"); 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    
}


try {
    
    $sql = "SELECT * FROM laba";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
} catch (PDOException $e) {
    $response = array('error' => true, 'msg' => '获取管理员数据失败: ' . $e->getMessage());
    echo json_encode($response);
}

// 關閉連接
$pdo = null;


?>