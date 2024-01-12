<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

require_once("connect.php"); // 開啟DB

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 使用 $_POST 來訪問前端發送的數據
    $prod_id = $_POST["prod_id"];
    $prod_name = $_POST["prod_name"];
    $prod_price = $_POST["prod_price"];
    $prod_info = $_POST["prod_info"];
    $prod_listed = $_POST["prod_listed"];
    $prod_category = $_POST["prod_category"];
    $prod_date = $_POST["prod_date"];
    $prod_img = $_POST["prod_img"];

    
    // 執行更新操作
    $update_sql = "UPDATE product SET (prod_id, prod_img, prod_name, prod_price, prod_info, prod_listed, prod_category, prod_date) VALUES (:prod_id, :prod_img, :prod_name, :prod_price, :prod_info, :prod_listed, :prod_category, :prod_date)";
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->bindValue(":prod_id", $prod_id, PDO::PARAM_INT);
    $update_stmt->bindValue(":prod_img", $targetFile);
    $update_stmt->bindValue(":prod_name", $prod_name);
    $update_stmt->bindValue(":prod_price", $prod_price);
    $update_stmt->bindValue(":prod_info", $prod_info);
    $update_stmt->bindValue(":prod_listed", $prod_listed);
    $update_stmt->bindValue(":prod_category", $prod_category);
    $update_stmt->bindValue(":prod_date", $prod_date);



}
try {
    
    $sql = "SELECT * FROM product";
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
