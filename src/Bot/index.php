<?php

require 'class-http-request.php';

$api = $_GET['api'];
$adminID = $_GET['admin'];
$userbot = $_GET['userbot'];

$content = file_get_contents("php://input");
$update = json_decode($content, true);

$gestione_staff = array(218214188=>'Stefifox');

require '_config.php';
adminIDisAdminInDB(); //mi assicuro che chi ha l'adminID venga segnato admin nel database.
$admins = getAdmins();


foreach($plugins as $plugin => $active) {
    
    if($active) include($plugin);

}

//creo un file input.json in cui salvo l'ultima chiamata inviata a me

$file = "input.json";
$f2 = fopen($file, 'w');
fwrite($f2, $content);
fclose($f2);



?>