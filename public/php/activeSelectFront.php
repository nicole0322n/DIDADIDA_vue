<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once("connect.php"); 

// if ($_SERVER["REQUEST_METHOD"] === "POST") { 
// }

try { // 試著走裡面這段
    $today = date('Y-m-d'); // 今天的日期

    $sql = "SELECT * FROM activity WHERE active_star >= :today ORDER BY active_star LIMIT 2";
    $stmt = $pdo->prepare($sql);  // prepare下指令
    $stmt->bindParam(':today', $today, PDO::PARAM_STR); // bindParam綁值
    $stmt->execute(); // execute執行
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // 全撈

    echo json_encode($result);  // fetch撈回來的API(方法、資料....),一定是陣列
} catch (PDOException $e) { // 錯誤捕捉
    $response = array('error' => true, 'msg' => '獲取管理員數據失敗: ' . $e->getMessage());
    // [true,'獲取管理員數據失敗,getMessage()],
    // {
        // error:true
        // 'msg':'獲取管理員數據失敗'
        // '$e':'錯誤原因'
    // }
    echo json_encode($response); // 印出上述陣列
}


// 關閉連接
$pdo = null;
?>