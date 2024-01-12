<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");



require_once("connect.php"); 

$checkEmail = $_POST["checkEmail"];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $checkEmail == 1) {
    $mem_email = $_POST["mem_email"];
    
    // 使用参数化查询
    $sql = "SELECT * FROM member WHERE mem_email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $mem_email, PDO::PARAM_STR);
    
    if ($stmt->execute()) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } else {
        // 查询执行失败，返回错误信息
        echo json_encode(array('error' => 'Query execution failed.'));
    }
}else{
    $mem_email = $_POST['mem_email'];
    $mem_name = $_POST['mem_name'];
    $mem_psw = $_POST['mem_psw'];

    $update_sql = "INSERT INTO member (mem_email, mem_name, mem_psw) VALUES (:mem_email, :mem_name, :mem_psw)";

    
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->bindValue(":mem_email", $mem_email);
    $update_stmt->bindValue(":mem_name", $mem_name);
    $update_stmt->bindValue(":mem_psw", $mem_psw);
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