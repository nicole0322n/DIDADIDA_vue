<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");



require_once("connect.php"); 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
//   $uploadedFile = $_FILES["image"]['name'];
  $tictype_id =  $_POST["tictype_id"];
  $tic_name =  $_POST["tic_name"];
  $tic_info =  $_POST["tic_info"];
  $tic_price =  $_POST["tic_price"];

  

  
$update_sql = "UPDATE ticket SET tic_name = :tic_name, tic_info = :tic_info, tic_price = :tic_price WHERE tictype_id = :tictype_id";

$update_stmt = $pdo->prepare($update_sql);
$update_stmt->bindValue(":tictype_id", $tictype_id, PDO::PARAM_INT);
$update_stmt->bindValue(":tic_name", $tic_name);
$update_stmt->bindValue(":tic_info", $tic_info);
$update_stmt->bindValue(":tic_price", $tic_price);

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