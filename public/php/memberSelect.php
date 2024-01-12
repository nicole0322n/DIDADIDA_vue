<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");



require_once("connect.php"); 

$mem_email = $_POST['mem_email'];
$mem_psw = $_POST['mem_psw'];


try {
    
    $update_sql = "SELECT * FROM member WHERE mem_email = :mem_email AND mem_psw = :mem_psw ";
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->bindParam(":mem_email", $mem_email);
    $update_stmt->bindParam(":mem_psw", $mem_psw);

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


