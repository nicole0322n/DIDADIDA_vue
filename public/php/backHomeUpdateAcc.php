<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");



require_once("connect.php"); 





if ($_SERVER["REQUEST_METHOD"] === "POST" ) {
    $emp_state = $_POST['emp_state'];
    $emp_id = $_POST['emp_id'];
    $update_sql = "UPDATE employee SET emp_state = :emp_state WHERE emp_id = :emp_id";
    $update_stmt = $pdo->prepare($update_sql);
   
    $update_stmt->bindValue(":emp_state", $emp_state);
    $update_stmt->bindValue(":emp_id", $emp_id);


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
