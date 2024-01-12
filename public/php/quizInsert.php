<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");



require_once("connect.php"); 


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 使用 $_POST 來訪問前端發送的數據
    $qa_no = $_POST["qa_no"];
    $qa_que = $_POST["qa_que"];
    $qa_ans = $_POST["qa_ans"];
    $qa_bonus = $_POST["qa_bonus"];

    // 直接執行更新操作
    $update_sql = "INSERT INTO quiz (qa_no, qa_que, qa_ans, qa_bonus) VALUES (:qa_no, :qa_que, :qa_ans, :qa_bonus)";

    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->bindValue(":qa_no", $qa_no, PDO::PARAM_INT);
    $update_stmt->bindValue(":qa_que", $qa_que);
    $update_stmt->bindValue(":qa_ans", $qa_ans);
    $update_stmt->bindValue(":qa_bonus", $qa_bonus);

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


try {
    
    $sql = "SELECT * FROM quiz";
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