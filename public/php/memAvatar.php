<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once("connect.php");


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $uploadedFile = $_FILES["image"]["name"];
    $mem_name = $_POST["mem_name"];

    // 檢查文件是否成功上傳
    // if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
    //     $response = [
    //         "error" => true,
    //         "message" => "文件上傳失敗。"
    //     ];
    //     echo json_encode($response);
    //     exit;
    // }

    $fileName = uniqid();
    $fileExt = pathinfo($uploadedFile, PATHINFO_EXTENSION);

    $targetDirectory = "../all_images/memAvatar/";

    if (!file_exists($targetDirectory)) {
        mkdir($targetDirectory, 0755, true); // 遞歸創建目錄，如果它不存在的話
    }

    $targetFile = $fileName . "." . $fileExt;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetDirectory . $targetFile)) {
        $response = [
            "success" => true,
            "message" => "文件上傳成功。",
            "file_path" => $targetFile,
            "fileName" => $targetFile
        ];
        echo json_encode($response);
    } else {
        $response = [
            "error" => true,
            "message" => "文件上傳失敗。"
        ];
        echo json_encode($_FILES["image"]["tmp_name"]);
    }
    // 文件上傳成功，接下來更新數據庫
    $update_sql = "UPDATE member SET mem_pic = :mem_pic WHERE mem_name = :mem_name";
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->bindValue(":mem_name", $mem_name);
    $update_stmt->bindValue(":mem_pic", $targetFile);

    if ($update_stmt->execute()) {
        $response = [
            "success" => true,
            "message" => "更新成功。",
        ];
    } else {
        $errorInfo = $update_stmt->errorInfo();
        $response = [
            "error" => true,
            "message" => "更新失敗：" . $errorInfo[2],
        ];
    }
}
