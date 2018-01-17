<?php

echo "Versione AltervistaBot: 3.0";

if($config['funziona_nei_canali'])
{
if($update["channel_post"])
{
$update["message"] = $update["channel_post"];
$canale = true;
}
}

if($config['funziona_messaggi_modificati'])
{
if($update["edited_message"])
{
$update["message"] = $update["edited_message"];
$editato = true;
}
}

if($config['funziona_messaggi_modificati_canali'])
{
if($update["edited_channel_post"])
{
$update["message"] = $update["edited_channel_post"];
$editato = true;
$canale = true;
}
}

$chatID = $update["message"]["chat"]["id"]; 
$userID = $update["message"]["from"]["id"];
$msg = $update["message"]["text"];
$username = $update["message"]["from"]["username"];
$nome = $update["message"]["from"]["first_name"];
$cognome = $update["message"]["from"]["last_name"];
if($chatID<0)
{
$titolo = $update["message"]["chat"]["title"];
$usernamechat = $update["message"]["chat"]["username"];
}

$voice = $update["message"]["voice"]["file_id"];
$photo = $update["message"]["photo"][0]["file_id"];
$document = $update["message"]["document"]["file_id"];
$audio = $update["message"]["audio"]["file_id"];
$sticker = $update["message"]["sticker"]["file_id"];

$replyText = $update["message"]["reply_to_message"]["text"];
$replyID = $update["message"]["reply_to_message"]["message_id"];
//tastiere inline
if($update["callback_query"])
{
$cbid = $update["callback_query"]["id"];
$cbdata = $update["callback_query"]["data"];
$msg = $cbdata;
$cbmt = $update["callback_query"]["message"]["text"];
$cbmid = $update["callback_query"]["message"]["message_id"];
$chatID = $update["callback_query"]["message"]["chat"]["id"];
$userID = $update["callback_query"]["from"]["id"];
$nome = $update["callback_query"]["from"]["first_name"];
$cognome = $update["callback_query"]["from"]["last_name"];
$username = $update["callback_query"]["from"]["username"];
}

if($update['message']["forward_from_chat"] or $update['message']["forward_from"]) {
    $fwfid = $update['message']['forward_from']['id'];
    $fwfname = $update['message']['forward_from']['first_name'];
    
    $fwfcid = $update['message']['forward_from_chat']['id'];
    $fwfcname = $update['message']['forward_from_chat']['title'];
    $fwfcusername = $update['message']['forward_from_chat']['username'];
    $fwfctype = $update['message']['forward_from_chat']['type']; //determina se canale o gruppo
    $fwfmid = $update['message']['forward_from_message_id'];
}

define("chatID",$chatID);

require 'database.php';

$page = getPage();



function getPage($dato=chatID) {
    global $tabella;
    $result = implode("",mysql_fetch_assoc(mysql_query("SELECT page FROM $tabella WHERE username = '$dato' OR chat_id = '$dato'")));
    return $result;
}

function sm($chatID, $text, $rmf = false, $pm = 'pred', $dis = false, $replyto = false, $inline = 'pred')
{
global $api;
global $userID;
global $update;
global $config;


if($pm=='pred') $pm = $config["formattazione_predefinita"];

if($inline=='pred')
{
if($config["tastiera_predefinita"] == "inline") $inline = true;
elseif($config["tastiera_predefinita"] == "normale")
$inline = false;
}
if($rmf == "nascondi") $inline = false;


$dal = $config["nascondi_anteprima_link"];

if(!$inline)
{
if($rmf == 'nascondi')
{
$rm = array('hide_keyboard' => true
);
}else{
$rm = array('keyboard' => $rmf,
'resize_keyboard' => true
);
}
}else{
$rm = array('inline_keyboard' => $rmf,
);
}
$rm = json_encode($rm);

$args = array(
'chat_id' => $chatID,
'text' => $text,
'disable_notification' => $dis,
'parse_mode' => $pm
);
if($dal) $args['disable_web_page_preview'] = $dal;
if($replyto) $args['reply_to_message_id'] = $replyto;
if($rmf) $args['reply_markup'] = $rm;
if($text)
{
$r = new HttpRequest("post", "https://api.telegram.org/$api/sendmessage", $args);
$rr = $r->getResponse();
$ar = json_decode($rr, true);
$ok = $ar["ok"]; //false
$e403 = $ar["error_code"];
if($e403 == "403")
{
return false;
}elseif($e403){
return false;
}else{
return true;
}
}
}

function inoltra($a,$da,$notifiche_off=false,$mid) {
    global $api;
    global $chatID;
    global $config;
    $args = array(
        'chat_id' => $a,
        'from_chat_id'=> $da,
        'disable_notification'=>$notifiche_off,
        'message_id' => $mid,
    );
    $r = new HttpRequest("post", "https://api.telegram.org/$api/forwardMessage", $args);
    $rr = $r->getResponse();
    $ar = json_decode($rr, true);
    return $ar;
}

function dm($chatid, $msgid)
{
global $api;

$args = array(
"chat_id" => $chatid,
"message_id" => $msgid
);

$new = new HttpRequest("post", "https://api.telegram.org/$api/deleteMessage", $args);
}

function si($chatID, $img, $rmf = false, $cap = '')
{
global $api;
global $userID;
global $update;



$rm = array('inline_keyboard' => $rmf,
);
$rm = json_encode($rm);


if(strpos($img, "."))
{
$img = str_replace("index.php","",$_SERVER['SCRIPT_URI']).$img;
}
$args = array(
'chat_id' => $chatID,
'photo' => $img,
'caption' => $cap
);
if($rmf) $args['reply_markup'] = $rm;
$r = new HttpRequest("post", "https://api.telegram.org/$api/sendPhoto", $args);




$rr = $r->getResponse();
$ar = json_decode($rr, true);
$ok = $ar["ok"]; //false
$e403 = $ar["error_code"];
if($e403 == "403")
{
return false;
}elseif($e403){
return false;
}else{
return true;
}
}
function sv($chatID, $voice, $caption, $rmf = false, $inline = true)
{
	global $api;
	$args = array(
	'chat_id' => $chatID,
	'voice' => $voice,
	'caption' => $caption
	);
	
	if($inline)
	{
		$rm = array('inline_keyboard' => $rmf);
	}
	$rm = json_encode($rm);
	if ($rmf) $args['reply_markup'] = $rm;
	$r = new HttpRequest("get", "https://api.telegram.org/$api/sendVoice", $args);
}

function sa($chatID, $audio, $caption, $rmf = false, $inline = true)
{
	global $api;
	$args = array(
	'chat_id' => $chatID,
	'audio' => $audio,
	'caption' => $caption
	);
	
	if($inline)
	{
		$rm = array('inline_keyboard' => $rmf);
	}
	$rm = json_encode($rm);
	if ($rmf) $args['reply_markup'] = $rm;
	$r = new HttpRequest("get", "https://api.telegram.org/$api/sendAudio", $args);
}

function sd($chatID, $documento, $caption, $rmf = false, $inline = true)
{
	global $api;
	$args = array(
	'chat_id' => $chatID,
	'document' => $documento,
	'caption' => $caption
	);
	
	if($inline)
	{
		$rm = array('inline_keyboard' => $rmf);
	}
	$rm = json_encode($rm);
	if ($rmf) $args['reply_markup'] = $rm;
	$r = new HttpRequest("get", "https://api.telegram.org/$api/sendDocument", $args);
}

function ss($chatID, $sticker, $rmf = false, $inline = true)
{
	global $api;
	$args = array(
	'chat_id' => $chatID,
	'sticker' => $sticker
	);
	
	if($inline)
	{
		$rm = array('inline_keyboard' => $rmf);
	}
	$rm = json_encode($rm);
	if ($rmf) $args['reply_markup'] = $rm;	
	$r = new HttpRequest("get", "https://api.telegram.org/$api/sendSticker", $args);
}


function cb_reply($id, $text, $alert = false, $cbmid = false, $ntext = false, $nmenu = false, $npm = "pred")
{
global $api;
global $chatID;
global $config;

if($npm == 'pred') $npm = $config["formattazione_predefinita"];



$args = array(
'callback_query_id' => $id,
'text' => $text,
'show_alert' => $alert

);
$r = new HttpRequest("get", "https://api.telegram.org/$api/answerCallbackQuery", $args);

if($cbmid)
{
if($nmenu)
{
$rm = array('inline_keyboard' => $nmenu
);
$rm = json_encode($rm);

}


$args = array(
'chat_id' => $chatID,
'message_id' => $cbmid,
'text' => $ntext,
'parse_mode' => $npm,
);
if($nmenu) $args["reply_markup"] = $rm;
$r = new HttpRequest("post", "https://api.telegram.org/$api/editMessageText", $args);


}
}


function addcron($time, $msg)
{
global $api;
$args = array(
'api' => $api,
'time' => $time,
'msg' => $msg
);
$rp = new HttpRequest("post", "https://httpsfreebot.ssl.altervista.org/bot/httpsfree/addcron.php", $args);
}


function ban($chatID, $userID)
{
global $api;
$args = array(
'chat_id' => $chatID,
'user_id' => $userID
);
$r = new HttpRequest("get", "https://api.telegram.org/$api/kickChatMember", $args);

}

function unban($chatID, $userID)
{
global $api;
$args = array(
'chat_id' => $chatID,
'user_id' => $userID
);
$r = new HttpRequest("get", "https://api.telegram.org/$api/unbanChatMember", $args);

}





function getID($username) {
    global $tabella;
    $result = mysql_fetch_assoc(mysql_query("SELECT `chat_id` FROM $tabella WHERE `username`='".$username."'"));
    return $result['chat_id'];
}

function getUsername($id) {
    global $tabella;
    $result = mysql_fetch_assoc(mysql_query("SELECT `username` FROM $tabella WHERE `chat_id`=".$id));
    return $result['username'];
}

function adminIDisAdminInDB() {
    global $tabella;
    global $adminID;
    global $chatID;
    $query = "UPDATE $tabella SET `admin`=true WHERE `chat_id`=".$adminID;
    mysql_query($query);
}

function getAdmins() {
    global $tabella;
    $result = mysql_query("SELECT `chat_id`, `username` FROM $tabella WHERE `admin`=true");
    $admins = array();
    while($row = mysql_fetch_assoc($result)) {
        $admins[$row['chat_id']] = $row['username'];
    }
    return $admins;
}

function isSaved($dato) {
    global $tabella;
    $result = mysql_num_rows(mysql_query("SELECT admin FROM $tabella WHERE `chat_id`='".$dato."' OR `username`='".$dato."'"));
    if($result>0) {
        return true;
    } else {
        return false;
    }
}

function addAdmin($dato) {
    global $tabella;
    global $chatID;
    global $admins;
    if(is_numeric($dato) and isSaved($dato)) { ########################## ID
        if(in_array($dato,array_flip($admins)) == false) { ////////////////////////////FINISH CHECKS///////////////////////////////
            $result = mysql_query("UPDATE $tabella SET `admin`=true WHERE `chat_id`=".$dato);
            if(mysql_affected_rows()>0) {
                ##Success##
                sm($dato,"⚜️ <b>Informazioni</b> ⚜️
                
Sei stato reso admin del bot.");
                sm($chatID,"Fatto ✅
                
Hai reso @".getUsername($dato)." admin del bot.");
                foreach($admins as $id=>$user) {
                    if($id!=$chatID) {
                        sm($id,"⚜️ <b>Informazioni</b> ⚜️
                
@".getUsername($chatID)." ha reso ".getUsername($dato)." admin del bot.");
                    }
                }
            }
        } else {
            sm($chatID,"⚠️ <b>Errore</b> ⚠️

@".getUsername($dato)." è già admin.");
        }
    } elseif (is_string($dato) and $dato[0]=='@' and isSaved(substr($dato,1))) { #################### USERNAME
        if(in_array(substr($dato,1),$admins) == false) { ////////////////////////////FINISH CHECKS///////////////////////////////
            $result = mysql_query("UPDATE $tabella SET `admin`=true WHERE `username`='".substr($dato,1)."'");
            if(mysql_affected_rows()>0) { 
                ##Success##
                sm(getID(substr($dato,1)),"⚜️ <b>Informazioni</b> ⚜️
                
Sei stato reso admin del bot.");
                sm($chatID,"Fatto ✅
                
Hai reso ".$dato." admin del bot.");
                foreach($admins as $id=>$user) {
                    if($id!=$chatID) {
                        sm($id,"⚜️ <b>Informazioni</b> ⚜️
                
@".getUsername($chatID)." ha reso ".$dato." admin del bot.");
                    }
                }
            }
        } else {
            sm($chatID,"⚠️ <b>Errore</b> ⚠️
        
".$dato." è già admin.");
        }
    } else {
        sm($chatID,"⚠️ <b>Errore</b> ⚠️
        
Non hai inserito un <b>id</b> o un <b>username</b> valido.");
    }
}

function delAdmin($dato) {
    global $tabella;
    global $chatID;
    global $admins;
    if(is_numeric($dato) and isSaved($dato)) { ###################### ID
        if(in_array($dato,array_flip($admins)) == true) { ////////////////////////////FINISH CHECKS///////////////////////////////
            
            $result = mysql_query("UPDATE $tabella SET `admin`=false WHERE `chat_id`=".$dato);
            if(mysql_affected_rows()>0) {
                ##Success##
                sm($dato,"⚜️ <b>Informazioni</b> ⚜️
                
Sei stato rimosso dagli admin del bot.");
                sm($chatID,"Fatto ✅
                
Hai rimosso @".getUsername($dato)." dagli admin admin del bot.");
                foreach($admins as $id=>$user) {
                    if($id!=$chatID) {
                        sm($id,"⚜️ <b>Informazioni</b> ⚜️
                
@".getUsername($chatID)." ha rimosso ".getUsername($dato)." dagli admin del bot.");
                    }
                }
            }
            
        } else {
            sm($chatID,"⚠️ <b>Errore</b> ⚠️

@".getUsername($dato)." non è admin.");
        }
    } elseif (is_string($dato) and $dato[0]=='@' and isSaved(substr($dato,1))) { ############### USERNAME
        if(in_array(substr($dato,1),$admins) == true) { ////////////////////////////FINISH CHECKS///////////////////////////////
            
            $result = mysql_query("UPDATE $tabella SET `admin`=false WHERE `username`='".substr($dato,1)."'");
            if(mysql_affected_rows()>0) { 
                ##Success##
                sm(getID(substr($dato,1)),"⚜️ <b>Informazioni</b> ⚜️
                
Sei stato rimosso dagli admin del bot.");
                sm($chatID,"Fatto ✅
                
Hai rimosso ".$dato." dagli admin del bot.");
                foreach($admins as $id=>$user) {
                    if($id!=$chatID) {
                        sm($id,"⚜️ <b>Informazioni</b> ⚜️
                
@".getUsername($chatID)." ha rimosso ".$dato." dagli admin del bot.");
                    }
                }
            }
            
        } else {
            sm($chatID,"⚠️ <b>Errore</b> ⚠️
        
".$dato." non è admin.");
        }
    } else {
        sm($chatID,"⚠️ <b>Errore</b> ⚠️
        
Non hai inserito un <b>id</b> o un <b>username</b> valido.");
    }
}

function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

function getSaluto() {
    date_default_timezone_set('Europe/Rome');
    $orario = date('H');
    if ($orario < 12) $saluto = "Buongiorno";
    elseif ($orario >= 12 && $orario < 19) $saluto = "Buon pomeriggio";
    elseif ($orario >= 19) $saluto = "Buonasera";
    return $saluto;
}

function setPage($page,$dato = chatID) {
    global $tabella;
    return mysql_query("UPDATE $tabella SET `page`='$page' WHERE `username`='$dato' OR `chat_id`='$dato'");
}

