<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once("connect.php");

try {
    
    $sql = "SELECT * FROM activity";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
} catch (PDOException $e) {
    $response = array('error' => true, 'msg' => '获取管理员数据失败: ' . $e->getMessage());
    echo json_encode($response);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $active_id = $_POST["active_id"];
    $active_title = $_POST["active_title"];
    $active_content = $_POST["active_content"];
    $nactive_date = $_POST["active_date"];
    $active_category = $_POST["active_category"];
    $active_state = $_POST["active_state"];
    $active_star = $_POST["active_star"];
    $active_end = $_POST["active_end"];

    // 检查是否存在上传的文件
    if (isset($_FILES["active_img"]) && $_FILES["active_img"]["error"] === UPLOAD_ERR_OK) {
        $uploadedFile = $_FILES["active_img"]["name"];
        $fileName = uniqid();
        $fileExt = pathinfo($uploadedFile, PATHINFO_EXTENSION);

        $targetDirectory = "../all_images/active/";
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory);
        }
        $targetFile = "{$fileName}.{$fileExt}";

        if (move_uploaded_file($_FILES["active_img"]["tmp_name"], "{$targetDirectory}{$targetFile}")) {

            $update_sql = "UPDATE activity SET active_category = :active_category, active_content = :active_content, active_title = :active_title, active_img = :active_img, active_state = :active_state, active_date = :active_date, active_star = :active_star, active_end = :active_end WHERE active_id = :active_id";
            $update_stmt = $pdo->prepare($update_sql);
            $update_stmt->bindValue(":active_id", $active_id, PDO::PARAM_INT);
            $update_stmt->bindValue(":active_title", $active_title);
            $update_stmt->bindValue(":active_content", $active_content);
            $update_stmt->bindValue(":active_date", $active_date);
            $update_stmt->bindValue(":active_category", $active_category);
            $update_stmt->bindValue(":active_state", $active_state);
            $update_stmt->bindValue(":active_star", $active_state);
            $update_stmt->bindValue(":active_end", $active_state);
            $update_stmt->bindValue(":active_img", $targetFile);
            
            if ($update_stmt->execute()) {
                $response = [
                    "success" => true,
                    "message" => "更新成功。",
                ];
                echo json_encode($response);
            } else {
                $response = [
                    "error" => true,
                    "message" => "更新失敗。",
                ];
                echo json_encode($response);
            }
        } else {
            $response = [
                "error" => true,
                "message" => "文件上傳失敗。",
            ];
            echo json_encode($response);
        }
    } else {
        // 如果没有上传新图片，只更新标题、内容等其他字段
        $update_sql = "UPDATE activity SET active_category = :active_category, active_content = :active_content, active_title = :active_title, active_state = :active_state, active_date = :active_date, active_star = :active_star, active_end = :active_end WHERE active_id = :active_id";
        $update_stmt = $pdo->prepare($update_sql);
        $update_stmt->bindValue(":active_id", $active_id, PDO::PARAM_INT);
        $update_stmt->bindValue(":active_title", $active_title);
        $update_stmt->bindValue(":active_content", $active_content);
        $update_stmt->bindValue(":active_date", $active_date);
        $update_stmt->bindValue(":active_category", $active_category);
        $update_stmt->bindValue(":active_state", $active_state);
        $update_stmt->bindValue(":active_star", $active_star);
        $update_stmt->bindValue(":active_end", $active_end);

        if ($update_stmt->execute()) {
            $response = [
                "success" => true,
                "message" => "更新成功。",
            ];
            echo json_encode($response);
        } else {
            $response = [
                "error" => true,
                "message" => "更新失敗。",
            ];
            echo json_encode($response);
        }
    }
}

// 关闭连接
$pdo = null;
?>
