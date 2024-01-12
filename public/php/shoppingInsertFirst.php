<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");



require_once("connect.php"); 



if ($_SERVER["REQUEST_METHOD"] === "POST") {
   
    
    $mem_id = $_POST["mem_id"];
    $ord_date = $_POST["ord_date"];
    $ord_sum = $_POST["ord_sum"];
    $ord_ship = $_POST["ord_ship"];
    $ord_pay = $_POST["ord_pay"];
    $ord_person = $_POST["ord_person"];
    $ord_phone = $_POST["ord_phone"];
    $ord_add = $_POST["ord_add"];
    $ord_state = $_POST["ord_state"];

    $update_sql = "INSERT INTO orders (mem_id, ord_date, ord_sum, ord_ship, ord_pay, ord_person, ord_phone, ord_add, ord_state) VALUES (:mem_id, :ord_date, :ord_sum, :ord_ship, :ord_pay, :ord_person, :ord_phone, :ord_add, :ord_state)";

    $update_stmt = $pdo->prepare($update_sql);

    // 绑定参数
    $update_stmt->bindParam(":mem_id", $mem_id);
    $update_stmt->bindParam(":ord_date", $ord_date);
    $update_stmt->bindParam(":ord_sum", $ord_sum);
    $update_stmt->bindParam(":ord_ship", $ord_ship);
    $update_stmt->bindParam(":ord_pay", $ord_pay);
    $update_stmt->bindParam(":ord_person", $ord_person);
    $update_stmt->bindParam(":ord_phone", $ord_phone);
    $update_stmt->bindParam(":ord_add", $ord_add);
    $update_stmt->bindParam(":ord_state", $ord_state);

  
   // 執行更新操作
   if ($update_stmt->execute()) {
    // 返回成功消息或其他適當的響應
    $lastInsertedId = $pdo->lastInsertId();
    $response = [
        "success" => true,
        "message" => "更新成功。",
        'lastInsertedId' => $lastInsertedId
    ];
    echo json_encode([$lastInsertedId]);
} else {
    // 更新失敗，返回錯誤消息
    $response = [
        "error" => true,
        "message" => "更新失敗。",
    ];
    echo json_encode($response);
}
}


$pdo = null;


?>