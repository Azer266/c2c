<?php 

try {

	$db=new PDO("mysql:host=localhost;dbname=c2c;charset=utf8",'root','0702665666');

	//echo "veritabanı bağlantısı başarılı";
}

catch (PDOExpception $e) {

	echo $e->getMessage();

}

?>