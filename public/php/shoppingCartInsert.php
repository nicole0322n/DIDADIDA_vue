<?php
// 允许跨域请求
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
$ord_id = $_POST["ord_id"];
$matchingProducts = json_decode($_POST["matchingProduct"]);

if ($matchingProducts === null) {
    http_response_code(400); // Bad Request
    echo json_encode(["message" => "无法解析 JSON 数据"]);
    exit();
}

require_once("connect.php");

$insertedRecords = [];
$orderNo = $pdo->lastInsertId();
$getLast = $orderNo;

foreach ($matchingProducts as $item) {
    $stmt = $pdo->prepare("INSERT INTO order_list (ord_id, prod_id, ord_qty, prod_price) VALUES ($ord_id, :prod_id, :ord_qty, :prod_price)");
    $prod_id = $item->prod_id;
    $ord_qty = $item->count;
    $prod_price = $item->prod_price;

  
    $stmt->bindParam(':prod_id', $prod_id);
   
    $stmt->bindParam(':ord_qty', $ord_qty);
    $stmt->bindParam(':prod_price', $prod_price);

    if ($stmt->execute()) {
        $insertedRecords[] = ["getLast" => $getLast, "count" => $ord_qty, "ord_id" => $ord_id];
    }
}

echo json_encode(["message" => "成功插入记录", "insertedRecords" => $insertedRecords]);
?>

