<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");



require_once("connect.php"); 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mem_email = $_POST['mem_email'];

    $update_sql = "SELECT * FROM ticket_order WHERE mem_email = :mem_email  ";
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->bindParam(":mem_email", $mem_email);

    if ($update_stmt->execute()) {
        $result = $update_stmt->fetchAll(PDO::FETCH_ASSOC);

        // 将查询结果编码为 JSON 并返回给前端
        echo json_encode($result);
    }
}



?>