<?php

echo "<br>Plugin Feedback: 2.0";


$admin_list = array_flip($admins);


$replyText = $update["message"]["reply_to_message"]["text"];

if(strpos($msg, "/feedback")===0 and $chatID>0)
{
$e = explode(" ", $msg, 2);
$text = $e[1];

if($text)
{
foreach($admin_list as $ad)
{
sm($ad, "#Feedback

<b>Utente:</b> $nome (@$username) [$userID]

<b>Messaggio:</b> ".$text."

<i>Per rispondere, rispondi a questo messaggio</i>");
}
sm($chatID, "Il messaggio è stato inoltrato agli admin, riceverai una risposta il prima possibile.");
}else{
sm($chatID, "Per inviare un messaggio allo staff scrivi
<code>/feedback testo da inviare</code>");
}
}

if(strpos($replyText, "#Feedback")===0 and in_array($userID, $admin_list) and $msg)
{
preg_match_all("#\[(.*?)\]#", $replyText, $nomea);
$replyToID = $nomea[1][0];

sm($replyToID, "<b>Risposta al Feedback</b>

".$msg);

foreach($admins as $id=>$user) {
    if($id!=$chatID) {
        $messaggio = "⚜️ <b>Informazioni</b> ⚜️
    
@$username ha risposto a @".getUsername($replyToID).":

<code>$msg</code>";
        sm($id,$messaggio);
    }
}

sm($chatID, "Inviato.");
}

