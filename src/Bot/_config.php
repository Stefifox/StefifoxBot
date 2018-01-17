<?php


//configurazioni
$config = array(

"formattazione_predefinita" => "HTML",
     //o "Markdown" o "" per nulla


"formattazione_messaggi_globali" => "HTML",



"nascondi_anteprima_link" => true,


"tastiera_predefinita" => "inline",
       //metti "normale" per mettere le tastiere vecchie


"funziona_nei_canali" => true,
"funziona_messaggi_modificati" => true,
"funziona_messaggi_modificati_canali" => true,


);


//non toccare
require 'functions.php';



//plugins

switch($page) {
    default:
        $plugins = array(

            "_comandi.php"=>true,
            "inline.php" => false,
            "gruppi.php" => false,
            "feedback.php" => false,
            "utenti.php" => true,
			"conv.php"=> true,
        );
        break;
}





