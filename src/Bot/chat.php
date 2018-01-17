<?php

if($msg=="/chat") {
    $messaggio = "<i>Fai </i>#c<i> all'inizio di ogni messaggio che vuoi che arrivi a noi</i>👍😁

(<i>Es. </i><code>#c Ciao </code><i>o</i><code> #c Vorrei una info...</code>)";
$menu[] = array(
        array(
            'text'=>'Indietro ⤴️',
            'callback_data'=>'/start modify'
        )
    );
cb_reply($cbid, "", false, $cbmid, $messaggio,$menu);
}

if(strpos($msg,"#c ")===0 and strlen($msg)>4) {
    $messaggio = "⚜️ <b>Chat</b> ⚜️

@".$username." [$chatID]

<code>".substr($msg,3)."</code>


<i>Rispondi a questo messaggio per rispondere all'utente. Gli verrà inviata la risposta automaticamente.</i>";
    $menu[] = array(
        array(
            'text'=>'Menù Principale',
            'callback_data'=>'/start modify'
        )
    );
    foreach($admins as $id=>$name) {
        sm($id,$messaggio,$menu);
    }
}

if(strpos($replyText,"⚜️ Chat ⚜️")===0 and $msg) {
    $utente = explode(PHP_EOL,$replyText);
    preg_match("/\[([^\]]*)\]/", $utente[2], $matches);
    $menu[] = array(
        array(
            'text'=>'Menù Principale',
            'callback_data'=>'/start modify'
        )
    );
    $utente = array('id'=>$matches[1],'username'=>get_string_between($utente[2], "@", " ["));
    sm($utente['id'],"👮🏻 <i>Risposta dallo staff:</i>

<code>".$msg."</code>",$menu);
    sm($chatID,"<i>Risposta Inviata ✅</i>",$menu);
    foreach($admins as $id=>$name) {
        if($id != $chatID) {
            sm($id,"⚜️ <b>Risposte Chat</b> ⚜️

@".getUsername($chatID)." <i>ha risposto a  </i>@".$utente['username']." [".$utente['id']."]:

<code>$msg</code>",$menu);
        }
    }
}