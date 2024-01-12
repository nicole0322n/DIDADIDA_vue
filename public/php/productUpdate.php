<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once("connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $prod_id = $_POST["prod_id"];
    $prod_name = $_POST["prod_name"];
    $prod_price = $_POST["prod_price"];
    $prod_info = $_POST["prod_info"];
    $prod_listed = $_POST["prod_listed"];
    $prod_category = $_POST["prod_category"];
    $prod_date = $_POST["prod_date"];

   $update_sql = "UPDATE product SET prod_name = :prod_name, prod_price = :prod_price, prod_info = :prod_info, prod_listed = :prod_listed, prod_category = :prod_category, prod_date = :prod_date";

    // 如果有新图像上传，更新图像字段
    if (!empty($_FILES["image"]["name"])) {
        $uploadedFile = $_FILES["image"]["name"];
        $fileName = uniqid();
        $fileExt = pathinfo($uploadedFile, PATHINFO_EXTENSION); // 获取文件扩展名

        $targetDirectory = "../all_images/product/";

        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory);
        }

        $targetFile = $fileName . "." . $fileExt;
        $targetFile = "{$fileName}.{$fileExt}";

        if (move_uploaded_file($_FILES["image"]["tmp_name"], "{$targetDirectory}{$targetFile}")) {
            // 图像上传成功
            $response = [
                "success" => true,
                "message" => "文件上傳成功。",
                "file_path" => $targetFile,
                "fileName" => $targetFile
            ];

            $update_sql .= ", prod_img = :prod_img";
        } else {
            // 图像上传失败
            $response = [
                "error" => true,
                "message" => "文件上傳失敗。"
            ];

            echo json_encode($response);
            exit; // 提前退出
        }
    }

    $update_sql .= " WHERE prod_id = :prod_id";
    $update_stmt = $pdo->prepare($update_sql);

    $update_stmt->bindValue(":prod_id", $prod_id, PDO::PARAM_INT);
    $update_stmt->bindValue(":prod_name", $prod_name);
    $update_stmt->bindValue(":prod_info", $prod_info);
    $update_stmt->bindValue(":prod_date", $prod_date);
    $update_stmt->bindValue(":prod_price", $prod_price);
    $update_stmt->bindValue(":prod_listed", $prod_listed);
    $update_stmt->bindValue(":prod_category", $prod_category);

    // 如果有新图像上传，绑定图像参数
    if (!empty($_FILES["image"]["name"])) {
        $update_stmt->bindValue(":prod_img", $targetFile);
    }

    // 执行更新操作
    if ($update_stmt->execute()) {
        // 返回成功消息或其他适当的响应
        $response = [
            "success" => true,
            "message" => "更新成功。",
        ];
        echo json_encode($response);
    } else {
        // 更新失败，返回错误消息
        $response = [
            "error" => true,
            "message" => "更新失敗。",
        ];
        echo json_encode($response);
    }
}

try {
    $sql = "SELECT * FROM product";
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