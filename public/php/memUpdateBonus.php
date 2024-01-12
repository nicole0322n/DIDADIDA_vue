<?php
header("Access-Control-Allow-Origin: *"); //跨域(接收所有來源)
header("Content-Type: application/json"); //只接收json



require_once("connect.php"); //開啟DB

$updateBonus = $_POST["updateBonus"];
if ($_SERVER["REQUEST_METHOD"] === "POST" && $updateBonus == "1") {
    $mem_bonus = $_POST["mem_bonus"];
    $mem_name = $_POST["mem_name"];
    $update_sql = "UPDATE member SET mem_bonus = :mem_bonus WHERE mem_name = :mem_name";
    $update_stmt = $pdo->prepare($update_sql);
   
    $update_stmt->bindValue(":mem_name", $mem_name);
    $update_stmt->bindValue(":mem_bonus", $mem_bonus);


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

?>