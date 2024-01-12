<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");



require_once("connect.php"); 

$updateBonus = $_POST['updateBonus'];
if($updateBonus == "1" && $_SERVER["REQUEST_METHOD"] === "POST"){
    $mem_bonus = $_POST['mem_bonus'];
    $mem_name = $_POST['mem_name'];

    $update_sql = "UPDATE member SET mem_bonus = :mem_bonus WHERE mem_name = :mem_name";
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->bindValue(":mem_bonus", $mem_bonus);
    $update_stmt->bindValue(":mem_name", $mem_name);

     // 執行更新操作
     if ($update_stmt->execute()) {
        // 返回成功消息或其他適當的響應
        $response = [
            "success" => true,
            "message" => "更新成功。",
        ];
        echo json_encode($response);
        exit();
    } else {
        // 更新失敗，返回錯誤消息
        $response = [
            "error" => true,
            "message" => "更新失敗。",
        ];
        echo json_encode($response);
        exit();
    }
}
?>