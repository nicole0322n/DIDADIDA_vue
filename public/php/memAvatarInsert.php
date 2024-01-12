<!-- 可複製圖片 / 新增 / 修改 -->
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once("connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $uploadedFile = $_FILES["image"]["name"];
    $mem_id = $_POST["mem_id"];

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

    $update_sql = "INSERT INTO member (mem_id, mem_pic) VALUES (:mem_id, :mem_pic)";

    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->bindValue(":mem_id", $mem_id, PDO::PARAM_INT);
    $update_stmt->bindValue(":mem_pic", $targetFile);

    if ($update_stmt->execute()) {
        // 返回成功消息或其他適當的響應
        $response = [
            "success" => true,
            "message" => "更新成功。",
        ];
        // echo json_encode($response);
    } else {
        // 更新失敗，返回錯誤消息
        $errorInfo = $update_stmt->errorInfo();
        $response = [
            "error" => true,
            "message" => "更新失敗：" . $errorInfo[2], // 將錯誤信息包括在消息中
        ];
        // echo json_encode($response);
    }
}

// 用於數據庫操作的其餘代碼，取消註釋並正確處理



?>