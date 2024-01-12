<?php
header("Access-Control-Allow-Origin: *"); //跨域(接收所有來源)
header("Content-Type: application/json"); //只接收json



require_once("connect.php"); //開啟DB

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 使用 $_POST 來訪問前端發送的數據
    $mem_email = $_POST["mem_email"];
    $mem_state = $_POST["mem_state"];
  

    // 直接執行更新操作
    $update_sql = "UPDATE member SET mem_state = :mem_state WHERE mem_email = :mem_email";
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->bindValue(":mem_email", $mem_email);
    $update_stmt->bindValue(":mem_state", $mem_state);


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
}




// 關閉連接
$pdo = null;


?>