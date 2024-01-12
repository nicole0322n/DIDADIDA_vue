<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once("connect.php"); 

// get
try {
    
    $sql = "SELECT * FROM banner";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
} catch (PDOException $e) {
    $response = array('error' => true, 'msg' => '获取管理员数据失败: ' . $e->getMessage());
    echo json_encode($response);
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $uploadedFile = $_FILES["image"]["name"];
  $banner_id = $_POST["banner_id"];

  // 檢查文件是否成功上傳
  if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
    $response = [
      "error" => true,
      "message" => "文件上傳失敗。"
    ];
    echo json_encode($response);
    exit;
  }

  $fileName = uniqid();
  $fileExt = pathinfo($uploadedFile, PATHINFO_EXTENSION);

  $targetDirectory = "../all_images/banner/";

  if (!file_exists($targetDirectory)) {
    mkdir($targetDirectory, 0755, true); // 遞歸創建目錄，如果它不存在的話
  }

  $targetFile = $fileName . "." . $fileExt;

  if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetDirectory . $targetFile)) {
    // 文件上傳成功，接下來更新數據庫
    $update_sql = "UPDATE banner SET banner_pic = :banner_pic WHERE banner_id = :banner_id";
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->bindValue(":banner_id", $banner_id, PDO::PARAM_INT);
    $update_stmt->bindValue(":banner_pic", $targetFile);

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
  } else {
    $response = [
      "error" => true,
      "message" => "文件複製失敗。"
    ];
  }

  echo json_encode($response);
}

// 用於數據庫操作的其餘代碼，取消註釋並正確處理

?>
