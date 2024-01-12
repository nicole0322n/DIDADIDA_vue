<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");



require_once("connect.php"); 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mem_id = $_POST['mem_id'];
    $mem_email = $_POST['mem_email'];
    $tic_name = $_POST['tic_name'];
    $tic_date = $_POST['tic_date'];
    $tic_pay = $_POST['tic_pay'];
    $tic_state = $_POST['tic_state'];
    $uniqid_num = $_POST['uniqid_num'];
   
    

       // 直接執行更新操作
       $update_sql = "INSERT INTO ticket_order (mem_id, mem_email, tic_date, tic_pay, tic_state, tic_name, uniqid_num) VALUES (:mem_id, :mem_email, :tic_date, :tic_pay, :tic_state, :tic_name, :uniqid_num)";

       $update_stmt = $pdo->prepare($update_sql);
       $update_stmt->bindValue(":mem_id", $mem_id);
       $update_stmt->bindValue(":mem_email", $mem_email);
       $update_stmt->bindValue(":tic_date", $tic_date);
       $update_stmt->bindValue(":tic_name", $tic_name);
       $update_stmt->bindValue(":tic_pay", $tic_pay);
       $update_stmt->bindValue(":tic_state", $tic_state);
       $update_stmt->bindValue(":uniqid_num", $uniqid_num);
      

    if ($update_stmt->execute()) {
        $result = $update_stmt->fetchAll(PDO::FETCH_ASSOC);

        // 将查询结果编码为 JSON 并返回给前端
        echo json_encode($result);
    }
}



?>