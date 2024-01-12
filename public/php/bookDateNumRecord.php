<?php
// 允许跨域请求
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");


// 读取 JSON 数据
// $src = file_get_contents("php://input");
// $data = json_decode($src);
// var_dump($data);echo "<hr>";
// exit();
$datas = $_POST["datas"];
$data=json_decode($datas);
// 检查是否成功解析 JSON 数据
if ($data === null) {
    http_response_code(400); // Bad Request
    echo json_encode(["message" => "无法解析 JSON 数据"]);
    exit();
}

// 在这里可以访问 $data，它是一个包含你发送的 JSON 数据的 PHP 数组或对象

// 在这里处理 $data 数据，例如：
// $ticType = $data->ticType;
// $ticPrice = $data->ticPrice;
// $ticQty = $data->ticQty;

// 对数据进行处理，然后返回响应
require_once("connect.php"); 



$insertedRecords = [];

$ticord_num = uniqid();
// 循环处理接收到的 JSON 数据
foreach ($data as $item) {
    // 在循环中处理每个数据项
    $tictype_id = $item->tictype_id;
    $tic_qty = $item->ticQty;
    $tic_price = $item->ticPrice;

    // 为 $ticord_num 设置唯一的值
   
    // 执行数据库插入操作
    $stmt = $pdo->prepare("INSERT INTO ticorder_list (tictype_id, tic_qty, tic_price, ticord_num) VALUES (:tictype_id, :tic_qty, :tic_price, :ticord_num)");

    $stmt->bindParam(':tictype_id', $tictype_id);
    $stmt->bindParam(':tic_qty', $tic_qty);
    $stmt->bindParam(':tic_price', $tic_price);
    $stmt->bindParam(':ticord_num', $ticord_num);
    if ($stmt->execute()) {
        $insertedRecords[] = ["tictype_id" => $tictype_id, "ticQty" => $tic_qty, "ticPrice" => $tic_price, "ticord_num" => $ticord_num];
    }
}

// 返回响应，包括插入的记录

//echo json_encode(["message" => "成功接收并处理 JSON 数据", "insertedRecords" => $insertedRecords]);
// $response = ["message" => "成功接收并处理 JSON 数据"];
echo json_encode(["訂單編號" => $ticord_num]);
?>
