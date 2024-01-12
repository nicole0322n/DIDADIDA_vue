<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");



require_once("connect.php"); 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
//   $uploadedFile = $_FILES["image"]['name'];
  $tic_date =  $_POST["tic_date"];
 $tic_state = $_POST["tic_state"];

  

  
$update_sql = "UPDATE ticket_order SET tic_state = :tic_state WHERE tic_date = :tic_date";

$update_stmt = $pdo->prepare($update_sql);


$update_stmt->bindValue(":tic_date", $tic_date);
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
}


// try {
   

    
//     $sql = "SELECT * FROM laba";
//     $stmt = $pdo->query($sql);
//     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//     // echo json_encode($result);
// } catch (PDOException $e) {
//     $response = array('error' => true, 'msg' => '获取管理员数据失败: ' . $e->getMessage());
//     // echo json_encode($response);
// }

// 關閉連接
$pdo = null;


?>