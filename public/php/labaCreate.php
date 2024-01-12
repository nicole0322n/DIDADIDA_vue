<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");



require_once("connect.php");
echo 123;
print_r($_FILES["image"]);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $uploadedFile = $_FILES["image"]['name'];
  $game_no =  $_POST["game_no"];
  $game_text =  $_POST["game_text"];
  $qa_bonus =  $_POST["qa_bonus"];
  $game_title =  $_POST["game_title"];

  $fileName = uniqid();
  $fileExt = pathinfo($uploadedFile,PATHINFO_EXTENSION); //副檔名

  $targetDirectory = "../all_images/laba/";
  if(!file_exists($targetDirectory)){
    mkdir($targetDirectory);
  }
  $targetFile = $fileName . "." . $fileExt;
  $targetFile = "{$fileName}.{$fileExt}";
  $result = ["fileName" => "$targetFile"];
  echo $_FILES["image"]["tmp_name"];
move_uploaded_file($_FILES["image"]["tmp_name"], "{$targetDirectory}{$targetFile}");
  if (move_uploaded_file($_FILES["image"]["tmp_name"], "{$targetDirectory}{$targetFile}")) {
    $response = [
      "success" => true,
      "message" => "文件上傳成功。",
      "file_path" => $targetFile,
      "fileName" => $targetFile
    ];
    echo json_encode($response);
}
$update_sql = "UPDATE laba SET game_text = :game_text, qa_bonus = :qa_bonus, game_title = :game_title, game_img = :game_img WHERE game_no = :game_no";
$update_stmt = $pdo->prepare($update_sql);
$update_stmt->bindValue(":game_text", $game_text);
$update_stmt->bindValue(":qa_bonus", $qa_bonus);
$update_stmt->bindValue(":game_title", $game_title);
$update_stmt->bindValue(":game_no", $game_no, PDO::PARAM_INT);
$update_stmt->bindValue(":game_img", $targetFile);
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
   

    
    $sql = "SELECT * FROM laba";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // echo json_encode($result);
} catch (PDOException $e) {
    $response = array('error' => true, 'msg' => '获取管理员数据失败: ' . $e->getMessage());
    // echo json_encode($response);
}

// 關閉連接
$pdo = null;


?>