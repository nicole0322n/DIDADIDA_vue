<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

require_once("connect.php"); // 開啟DB

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 使用 $_POST 來訪問前端發送的數據
    $prod_id = $_POST["prod_id"];
    $prod_name = $_POST["prod_name"];
    $prod_price = $_POST["prod_price"];
    $prod_info = $_POST["prod_info"];
    $prod_listed = $_POST["prod_listed"];
    $prod_category = $_POST["prod_category"];
    $prod_date = $_POST["prod_date"];
    $prod_img = $_FILES["image"]["name"];
    $fileName = uniqid();
    $fileExt = pathinfo($prod_img, PATHINFO_EXTENSION); //副檔名

    $targetDirectory = "../all_images/product/";
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
    $update_sql = "INSERT INTO product (prod_id, prod_img, prod_name, prod_price, prod_info, prod_listed, prod_category, prod_date) VALUES (:prod_id, :prod_img, :prod_name, :prod_price, :prod_info, :prod_listed, :prod_category, :prod_date)";

    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->bindValue(":prod_id", $prod_id, PDO::PARAM_INT);
    $update_stmt->bindValue(":prod_img", $targetFile);
    $update_stmt->bindValue(":prod_name", $prod_name);
    $update_stmt->bindValue(":prod_price", $prod_price);
    $update_stmt->bindValue(":prod_info", $prod_info);
    $update_stmt->bindValue(":prod_listed", $prod_listed);
    $update_stmt->bindValue(":prod_category", $prod_category);
    $update_stmt->bindValue(":prod_date", $prod_date);


    
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
