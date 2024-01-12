<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");



require_once("connect.php"); 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
//   $uploadedFile = $_FILES["image"]['name'];
  $tictype_id =  $_POST["tictype_id"];
  $tick_state =  $_POST["tick_state"];
 
  

  
$update_sql = "UPDATE ticket SET tick_state = :tick_state WHERE tictype_id = :tictype_id";

$update_stmt = $pdo->prepare($update_sql);
$update_stmt->bindValue(":tictype_id", $tictype_id, PDO::PARAM_INT);
$update_stmt->bindValue(":tick_state", $tick_state);


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