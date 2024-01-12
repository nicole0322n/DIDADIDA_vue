<?php
header("Access-Control-Allow-Origin: *"); //跨域(接收所有來源)
header("Content-Type: application/json"); //只接收json



require_once("connect.php"); //開啟DB

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 使用 $_POST 來訪問前端發送的數據
    $smart_id = $_POST["smart_id"];
    $smart_que = $_POST["smart_que"];
    $smart_ans = $_POST["smart_ans"];

    // 直接執行更新操作
    $update_sql = "UPDATE helper SET smart_que = :smart_que, smart_ans = :smart_ans WHERE smart_id = :smart_id";
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->bindValue(":smart_id", $smart_id, PDO::PARAM_INT);
    $update_stmt->bindValue(":smart_que", $smart_que);
    $update_stmt->bindValue(":smart_ans", $smart_ans);

    // 執行更新操作
    if ($update_stmt->execute()) {
        // 返回成功消息或其他適當的響應
        $response = [
            "success" => true,
            "message" => "更新成功。",
        ];
        // echo json_encode($response);
    } else {
        // 更新失敗，返回錯誤消息
        $response = [
            "error" => true,
            "message" => "更新失敗。",
        ];
        // echo json_encode($response);
    }
}


try {
    
    $sql = "SELECT * FROM helper";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
} catch (PDOException $e) {
    $response = array('error' => true, 'msg' => '获取管理员数据失败: ' . $e->getMessage());
    echo json_encode($response);
}

// 關閉連接
$pdo = null;


?>