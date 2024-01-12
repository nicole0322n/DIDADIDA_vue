<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

require_once("connect.php"); // 開啟DB

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 使用 $_POST 來訪問前端發送的數據
    $news_id = $_POST["news_id"];
    $news_title = $_POST["news_title"];
    $news_content = $_POST["news_content"];
    $news_date = $_POST["news_date"];
    $news_category = $_POST["news_category"];
    $news_state = $_POST["news_state"];
    $news_img = $_FILES["image"]["name"];
    $fileName = uniqid();
    $fileExt = pathinfo($news_img, PATHINFO_EXTENSION); //副檔名

    $targetDirectory = "../all_images/news/";
    if (!file_exists($targetDirectory)) {
        mkdir($targetDirectory);
    }
    $targetFile = $fileName . "." . $fileExt;
    $targetFile = "{$fileName}.{$fileExt}";
    $result = ["fileName" => "$targetFile"];
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "{$targetDirectory}{$targetFile}")) {
        $response = [
          "success" => true,
          "message" => "文件上傳成功。",
          "file_path" => $targetFile,
          "fileName" => $targetFile
        ];
        // echo json_encode($response);
    }
    
    // 執行更新操作
    $update_sql = "INSERT INTO news (news_id, news_img, news_title, news_content, news_date, news_category, news_state) VALUES (:news_id, :news_img, :news_title, :news_content, :news_date, :news_category, :news_state)";

    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->bindValue(":news_id", $news_id, PDO::PARAM_INT);
    $update_stmt->bindValue(":news_img", $targetFile);
    $update_stmt->bindValue(":news_title", $news_title);
    $update_stmt->bindValue(":news_content", $news_content);
    $update_stmt->bindValue(":news_date", $news_date);
    $update_stmt->bindValue(":news_category", $news_category);
    $update_stmt->bindValue(":news_state", $news_state);


    
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
        $errorInfo = $update_stmt->errorInfo();
        $response = [
            "error" => true,
            "message" => "更新失敗：" . $errorInfo[2], // 將錯誤信息包括在消息中
        ];
        echo json_encode($response);
    }
}


// 關閉連接
$pdo = null;
?>
