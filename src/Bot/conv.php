<?php

$newsApi = "90f2a692bd1f496b8adff5a44e041546";
//--function--
function getTime()
{
    date_default_timezone_set('Europe/Rome');
    $orario = date('H:i');
    return $orario;
}
function getData()
{
    date_default_timezone_set('Europe/Rome');
    $data = date('j/n/y');
    return $data;
}
function Fest()
{
    date_default_timezone_set('Europe/Rome');
    $data = date('j/n');
    return $data;
}
function Year()
{
    date_default_timezone_set('Europe/Rome');
    $data = date('Y');
    return $data;
}
function googleNews($max) {
    global $newsApi;
    $get =json_decode(file_get_contents("https://newsapi.org/v1/articles?source=google-news&sortBy=top&apiKey=90f2a692bd1f496b8adff5a44e041546"/*.$newsApi*/),true);
    $get = $get['articles'];
    foreach($get as $id=>$article) {
        if($id > ($max-1)) {
            unset($get[$id]);
        }
    }
    return $get;
}


if(strpos($msg,"/conv")===0) {
    	$menu[] = array(
        array(
            'text'=>'Indietro ⤴️',
            'callback_data'=>'/azioni modify'
        )
    );
	$messaggio = "Per iniziare a conversare di Ciao;
Funziona in qualsiasi menù o momento";
    if($cbmid) cb_reply($cbid, "", false, $cbmid, $messaggio,$menu);
	else sm($chatID,$messaggio,$menu);
}

//--if--

if(strpos($msg,"Ciao")===0) {
	$messaggio = "Ciao 😃
Quindi ti va di conversare con me!";
    if($cbmid) cb_reply($cbid, "", false, $cbmid, $messaggio,$menu);
	else sm($chatID,$messaggio,$menu);
}
if(strpos($msg,"Arrivederci")===0) {
		$menu[] = array(
        array(
            'text'=>'Home',
            'callback_data'=>'/start'
        )
    );
	$messaggio = "Anche a te 😃";
    if($cbmid) cb_reply($cbid, "", false, $cbmid, $messaggio,$menu);
	else sm($chatID,$messaggio,$menu);
}
if(strpos($msg,"Home")===0) {
		$menu[] = array(
        array(
            'text'=>'🏠',
            'callback_data'=>'/start'
        )
    );
	$messaggio = "Ciaooo 😃";
    if($cbmid) cb_reply($cbid, "", false, $cbmid, $messaggio,$menu);
	else sm($chatID,$messaggio,$menu);
}
if(strpos($msg,"Che ore sono?")===0) {
	$messaggio = "Sono le: ".getTime();
    if($cbmid) cb_reply($cbid, "", false, $cbmid, $messaggio,$menu);
	else sm($chatID,$messaggio,$menu);
}
if(strpos($msg,"Che giorno è?")===0) {
	if(Fest()=="1/1"){
		$messaggio = "Buon ".Year()." !";
	}
	elseif(Fest()=="25/12"){
		$messaggio = "Buon Natale";
	}
	else{
		$messaggio = "Oggi è il: ".getData();
	}
    if($cbmid) cb_reply($cbid, "", false, $cbmid, $messaggio,$menu);
	else sm($chatID,$messaggio,$menu);
}
if(strpos($msg,"Come va?")===0) {
	$messaggio = "Molto bene 👍";
    if($cbmid) cb_reply($cbid, "", false, $cbmid, $messaggio,$menu);
	else sm($chatID,$messaggio,$menu);
}
if(strpos($msg,"😁")===0) {
	$messaggio = "😁";
    if($cbmid) cb_reply($cbid, "", false, $cbmid, $messaggio,$menu);
	else sm($chatID,$messaggio,$menu);
}
//----News----
if(strpos($msg,"What's the news by Google?")===0) {
 $messaggio ="The latest news by Google is".googleNews(2);
 if($cbmid) cb_reply($cbid, "", false, $cbmid, $messaggio,$menu);
	else sm($chatID,$messaggio,$menu);
}
?>