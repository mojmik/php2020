<?php
function loadClasses($class) {
	echo "loaduju classy";
    require(str_replace("\\","/","$class.php"));
}

spl_autoload_register("loadClasses");
$dic=new Mik\DIC\DIcontainer(); 
//$db = new PDO('mysql:host=localhost;dbname=testdb;charset=utf8', 'root', '');
//$dic->addService($db);

$carManager=new CarManager();
$dic->addService($carManager);

$carController = $dic->getInstance("CarController");
$carController->printCars();