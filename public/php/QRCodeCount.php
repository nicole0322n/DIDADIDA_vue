<?php
header("Access-Control-Allow-Origin: *"); //跨域(接收所有來源)
header("Content-Type: application/json"); //只接收json



require_once("connect.php"); //開啟DB

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tic_id = $_POST["tic_id"];
    $tic_state = "已使用";

    $update_sql = "UPDATE ticket_order SET tic_state = :tic_state WHERE tic_id = :tic_id";
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->bindValue(":tic_id", $tic_id);
    $update_stmt->bindValue(":tic_state", $tic_state);
  
     // 執行更新操作
     if ($update_stmt->execute()) {
        // 返回成功消息或其他適當的響應
        $response = [
            "success" => true,
            "message" => "更新成功。",
        ];
        echo json_encode($response);
    } else {
        // 更新失敗，返回錯誤消息
        $response = [
            "error" => true,
            "message" => "更新失敗。",
        ];
        echo json_encode($response);
    }

};



?>