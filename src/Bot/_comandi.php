<?php

//comandi del bot

#

if(strpos($msg,"/start")===0) {
    $messaggio = "Benvenuto $nome!
In questo bot potrai fare tantissime cose; usa i tasti qui sotto per scoprire che puoi fare";
	$menu[] = array(
            array(
                'text'=>'Cosa vuoi fare ❓',
                'callback_data'=>'/azioni'
            )
    );
	$menu[] = array(
            array(
                'text'=>'💻 Social 💻',
                'callback_data'=>'/social'
            )
    );
	$menu[] = array(
        array(
            'text'=>'💲 Dona 💲',
            'url'=>'https://paypal.me/Stefifox'
        )
    );
	$menu[] = array(
        array(
            'text'=>'📲 Sito 📲',
            'url'=>'https://stefifoxhost.altervista.org'
        )
    );
	$menu[] = array(
            array(
                'text'=>'👮🏼 Staff 👮🏼',
                'callback_data'=>'/staff'
            )
    );
    if($cbmid) cb_reply($cbid, "", false, $cbmid, $messaggio,$menu);
	else sm($chatID,$messaggio,$menu);
}

if(strpos($msg,"/azioni")===0) {
    $menu[] = array(
            array(
                'text'=>'📄 Richiedere Sponsor 📄',
                'url'=>'https://t.me/sponsor_channel_richiestebot'
            )
    );
	$menu[] = array(
            array(
                'text'=>'Il mio chat🆔',
                'callback_data'=>'/chatid'
            )
    );
	$menu[] = array(
            array(
                'text'=>'Conversiamo❕❕',
                'callback_data'=>'/conv'
            )
    );
	$menu[] = array(
            array(
                'text'=>'📙 Aiutami 📙',
                'callback_data'=>'/help'
            )
    );
	$menu[] = array(
        array(
            'text'=>'Indietro ⤴️',
            'callback_data'=>'/start'
        )
    );
	$messaggio = "<b>Ecco cosa puoi fare!</b>";
    if($cbmid) cb_reply($cbid, "", false, $cbmid, $messaggio,$menu);
	else sm($chatID,$messaggio,$menu);
}

if(strpos($msg,"/help")===0) {
    	$menu[] = array(
        array(
            'text'=>'💵 Donazioni 💵',
            'callback_data'=>'/dhelp'
        )
    );
		$menu[] = array(
        array(
            'text'=>'🆔 ChatId 🆔',
            'callback_data'=>'/idhelp'
        )
	);
			$menu[] = array(
        array(
            'text'=>'😃 Conversazione 😃',
            'callback_data'=>'/chelp'
        )
    );
		$menu[] = array(
        array(
            'text'=>'📄 Sponsor 📄',
            'callback_data'=>'/shelp'
        )
    );
	$menu[] = array(
        array(
            'text'=>'Indietro ⤴️',
            'callback_data'=>'/azioni modify'
        )
    );
	$messaggio = "<b>📙 Help Menù 📙</b>";
    if($cbmid) cb_reply($cbid, "", false, $cbmid, $messaggio,$menu);
	else sm($chatID,$messaggio,$menu);
}

if(strpos($msg,"/chatid")===0) {
    	$menu[] = array(
        array(
            'text'=>'Indietro ⤴️',
            'callback_data'=>'/azioni modify'
        )
    );
	$messaggio = "il tuo chatid è: ".$chatID;
    if($cbmid) cb_reply($cbid, "", false, $cbmid, $messaggio,$menu);
	else sm($chatID,$messaggio,$menu);
}

if(strpos($msg,"/social")===0) {
    	$menu[] = array(
            array(
                'text'=>'Twitter ',
                'url'=>'https://twitter.com/Stefifox'
            )
    );
	 	$menu[] = array(
            array(
                'text'=>'Instagram ',
                'url'=>'https://www.instagram.com/stefifox003/'
            )
    );
	 	$menu[] = array(
            array(
                'text'=>'Telegram',
                'url'=>'https://t.me/Stefifox'
            )
    );
	 	$menu[] = array(
            array(
                'text'=>'📄 Sponsor Channel 📄',
                'url'=>'https://t.me/Sponsor_channel'
            )
    );
	$menu[] = array(
        array(
            'text'=>'Indietro ⤴️',
            'callback_data'=>'/start modify'
        )
    );
	$messaggio = "<b>💻 Social Menù 💻</b>
Clicca uno di questi pulsanti per connetterti a uno dei nostri social";
    if($cbmid) cb_reply($cbid, "", false, $cbmid, $messaggio,$menu);
	else sm($chatID,$messaggio,$menu);
}
//--Help--
if(strpos($msg,"/dhelp")===0) {
    	$menu[] = array(
        array(
            'text'=>'Indietro ⤴️',
            'callback_data'=>'/help modify'
        )
    );
	$messaggio = "💵 Help Donazioni 💵
Benvenuto nel menù Help delle donazioni:
-Tutte le donazioni sono sicure e fatte con PayPal.
-Ti preghiamo di non chiedere il rimborso se vuoi sostenerci; perchè non ha senso fare una donazione e poi chiederne il rimborso.
-Se hai buon senso sostienici; anche con una piccola donazione di 1€.";
    if($cbmid) cb_reply($cbid, "", false, $cbmid, $messaggio,$menu);
	else sm($chatID,$messaggio,$menu);
}
if(strpos($msg,"/idhelp")===0) {
    	$menu[] = array(
        array(
            'text'=>'Indietro ⤴️',
            'callback_data'=>'/help modify'
        )
    );
	$messaggio = "🆔 Help ChatId 🆔 
Benvenuto nel menù Help del chatId:
-Il chatId è un codice univoco che viene assegnato a tutti gli utenti Telegram; viene usato dai bot per contattare gli utenti.
Il nostro bot lo registra in un Database per salvare i dati; non verrà condiviso con nessuno";
    if($cbmid) cb_reply($cbid, "", false, $cbmid, $messaggio,$menu);
	else sm($chatID,$messaggio,$menu);
}
if(strpos($msg,"/shelp")===0) {
    	$menu[] = array(
        array(
            'text'=>'Indietro ⤴️',
            'callback_data'=>'/help modify'
        )
    );
	$messaggio = "📄 Help Sponsor 📄
Benvenuto nel menù Help degli Sponsor:
-Gli sponsor si effettuano trammite @Sponsor_Channel con il bot @Sponsor_Channel_richiestebot .
-Tutti gli sponsor sono gratuiti, vedi regolamento canale.
-Possono essere rifiutati o accettati in base a vari fattori, vedi regolamento canale.";
    if($cbmid) cb_reply($cbid, "", false, $cbmid, $messaggio,$menu);
	else sm($chatID,$messaggio,$menu);
}
if(strpos($msg,"/chelp")===0) {
    	$menu[] = array(
        array(
            'text'=>'Indietro ⤴️',
            'callback_data'=>'/help modify'
        )
    );
	$messaggio = "😁 Help conversazione 😁
Benvenuto nel menù Help della Conversazione:
-Ti basta scrivere <code>Ciao</code>
-Per tornare all'home scrivi <code>Home</code> o <code>Arrivederci</code>
-Mentre conversi prova a dire<code> Cosa sai fare?</code> per scoprire cosa puoi chiediergli";
    if($cbmid) cb_reply($cbid, "", false, $cbmid, $messaggio,$menu);
	else sm($chatID,$messaggio,$menu);
}
//preimpostati

if($msg=="/staff") {
    $menu[] = array(
        array(
            'text'=>'Indietro ⤴️',
            'callback_data'=>'/start'
        )
    );
    $messaggio = "<b>Staff di StefifoxBot</b>
    ";
    foreach($admins as $id=>$user) {
        $messaggio .="
- @".$user;
    }
    $messaggio .= "

<code>Programmato da </code>@Stefifox <code>in PHP 5.6</code>\n<code>Template di </code>@Lolmaster_human";
    if($cbmid) cb_reply($cbid, "", false, $cbmid, $messaggio,$menu);
	else sm($chatID,$messaggio,$menu);
}


if(strpos($msg,"/addadmin")===0) {
    if (substr($msg,10)!=null) {
        
        if(in_array($chatID,array_flip($gestione_staff))) {
                addAdmin(substr($msg,10));           
        } else {
            sm($chatID,"📛 <b>Azione Vietata</b> 📛

Lo staff è stato notificato.");
            foreach($admins as $id=>$user) {
                sm($id,"⚠️ <b>Attenzione</b> ⚠️
                
@".getUsername($chatID)." ha provato ad aggiungere ".substr($msg,10)." agli admin del bot. L'azione è stata annullata.");
            }
        }
        
        
    } else {
        sm($chatID,"Si usa così questo comando:
        
<code>/addadmin (username)</code> oppure <code>/addadmin (id)</code>");
    }
}

if(strpos($msg,"/deladmin")===0) {
    if (substr($msg,10)!=null) {
        
        if(in_array($chatID,array_flip($gestione_staff))) {
            if (in_array(substr($msg,11),$gestione_staff)==false and in_array(substr($msg,10),array_flip($gestione_staff))==false) {
                delAdmin(substr($msg,10));
            } else {
                sm($chatID,"📛 <b>Azione Vietata</b> 📛");
            }
        } else {
            sm($chatID,"📛 <b>Azione Vietata</b> 📛

Lo staff è stato notificato.");
            foreach($admins as $id=>$user) {
                sm($id,"⚠️ <b>Attenzione</b> ⚠️m
                
@".getUsername($chatID)." ha provato a rimuovere ".substr($msg,10)." dagli admin del bot. L'azione è stata annullata.");
            }
        }
        
        
    } else {
        sm($chatID,"Si usa così questo comando:
        
<code>/deladmin (username)</code> oppure <code>/deladmin (id)</code>");
    }
}
?>
