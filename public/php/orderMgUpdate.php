<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");



require_once("connect.php"); 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 使用 $_POST 來訪問前端發送的數據
    $ord_id = $_POST["ord_id"];
    $ord_state = $_POST["ord_state"];
  
    // 直接執行更新操作
    $update_sql = "UPDATE orders SET ord_state = :ord_state WHERE ord_id = :ord_id";
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->bindValue(":ord_id", $ord_id, PDO::PARAM_INT);
    $update_stmt->bindValue(":ord_state", $ord_state);
   

    // 執行更新操作
    if ($update_stmt->execute()) {
        // 返回成功消息或其他適當的響應
        $response = [
            "success" => true,
            "message" => "更新成功。",
        ];
        // echo json_encode($response);
    } else {
        // 更新失敗，返回錯誤消息
        $response = [
            "error" => true,
            "message" => "更新失敗。",
        ];
        // echo json_encode($response);
    }
}   






?>