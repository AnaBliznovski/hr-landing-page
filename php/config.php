<?php
define('DB_SERVER','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','vladodev123AA');
define('DB_NAME','hrlandingpage');
//probuvame da se konektirame so bazata
try {

    $pdo = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);
    
    // $pdo->exec("SET time_zone='+03:00';");
    // za error exeption
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    // set charset to utf8 for cirilyc support
    $pdo->query('SET NAMES utf8');
    // echo "Konekcijata so Bazata preku PDO e uspeshna";
    // poraka za uspeshna konekcija
    } catch(PDOException $e) {
        echo "Konekcijata ne e uspeshna". $e->getMessage();
    }
?>
