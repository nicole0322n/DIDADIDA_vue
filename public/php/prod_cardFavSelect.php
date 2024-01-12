<?php
 header("Access-Control-Allow-Origin: *");
 header("Content-Type: application/json");

 require_once("connect.php"); 

 try {
    
    $sql = "SELECT * FROM product INNER JOIN favorite_list ON product.prod_id = favorite_list.prod_id INNER JOIN member ON member.mem_id = favorite_list.mem_id";
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