<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");



require_once("connect.php"); 



if ($_SERVER["REQUEST_METHOD"] === "POST") {
   
    
    $close_date = $_POST["close_date"];

   

    $update_sql = "DELETE FROM close_days WHERE close_date = :close_date";
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->bindValue(":close_date", $close_date);
    
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
    
    
   
//     $stmt = $pdo->query($sql);
//     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//     echo json_encode($result);
// } catch (PDOException $e) {
//     $response = array('error' => true, 'msg' => '获取管理员数据失败: ' . $e->getMessage());
//     echo json_encode($response);
// }

// 關閉連接
$pdo = null;


?>