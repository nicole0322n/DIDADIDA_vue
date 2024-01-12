<?php 
	// $dbname = "";
	// $user = "";
	// $password = "";
    ////////
	$dbname = "dida";
	$user = "root";
	$password = "root";

	$dsn = "mysql:host=localhost;port=3306;dbname=$dbname;charset=utf8";

	$options = array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_CASE=>PDO::CASE_NATURAL);
   ////////
	//建立pdo物件
	//??????
	$pdo = new PDO($dsn, $user, $password, $options);	


	//改成老師的路徑
	// $dbname = "tibamefe_chd103g4";
	// $user = "tibamefe_since2021";
	// $password = "vwRBSb.j&K#E";
	// $port = 3306;
	// $dsn = "mysql:host=localhost;port=$port;dbname=$dbname;charset=UTF8";

	// $options = array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_CASE=>PDO::CASE_NATURAL);
	// $pdo = new PDO($dsn, $user, $password, $options);	
	

?>