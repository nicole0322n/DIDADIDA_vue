<?php
header("Access-Control-Allow-Origin: *"); //跨域(接收所有來源)
header("Content-Type: application/json"); //只接收json



require_once("connect.php"); //開啟DB

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mem_name = $_POST["mem_name"];
    $mem_address = $_POST["mem_address"];
    $mem_mob = $_POST["mem_mob"];
    $mem_birth = $_POST["mem_birth"];
    $mem_gender = $_POST["mem_gender"];

    $update_sql = "UPDATE member SET mem_address = :mem_address, mem_mob = :mem_mob, mem_birth = :mem_birth, mem_gender = :mem_gender WHERE mem_name = :mem_name";
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->bindValue(":mem_address", $mem_address);
    $update_stmt->bindValue(":mem_mob", $mem_mob);
    $update_stmt->bindValue(":mem_birth", $mem_birth);
    $update_stmt->bindValue(":mem_gender", $mem_gender);
    $update_stmt->bindValue(":mem_name", $mem_name);

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