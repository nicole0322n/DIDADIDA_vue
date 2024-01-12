<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");



require_once("connect.php"); 

$mem_name = $_POST['mem_name'];



try {
    
    $update_sql = "SELECT * FROM member WHERE mem_name = :mem_name  ";
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->bindParam(":mem_name", $mem_name);
   

    if ($update_stmt->execute()) {
        $result = $update_stmt->fetchAll(PDO::FETCH_ASSOC);

        // 将查询结果编码为 JSON 并返回给前端
        echo json_encode($result);
    }
} catch (PDOException $e) {
    $response = array('error' => true, 'msg' => '获取管理员数据失败: ' . $e->getMessage());
    echo json_encode($response);
}

// 關閉連接
$pdo = null;


?>
