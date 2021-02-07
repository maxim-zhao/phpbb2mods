<?php
/***************************************************************************
 *                               lang_contact.php - Italian
 *                              ----------------------------
 *	Version:	9.0.0
 *	Begin:		Sunday, Sept 17, 2006
 *   	Copyright:	(C) 2006, Marcus
 *	E-mail:		marcus@phobbia.net
 *	$id:		21:22 01/06/2007
 *
 *	Translated by:	Cavallino
 *	E-mail:		kavallino@gmail.com
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

$lang['Contact_intro'] = 'Se vuoi esprimere commenti, giudizi o suggerimenti riguardo al sito, oppure se hai riscontrato problemi nella registrazione o nella connessione, utilizza questo modulo per contattare direttamente l\'amministratore.';

$lang['Username'] = 'Nome Utente'; 
$lang['Real_name'] = 'Nome Completo'; 
$lang['Rname_require'] = 'Nome Completo *'; 
$lang['E-mail'] = 'Indirizzo E-mail'; 
$lang['E-mail_require'] = 'Indirizzo E-mail *'; 
$lang['Comments'] = 'Commenti'; 
$lang['Comments_require'] = 'Commenti *'; 
$lang['Attachment'] = 'Allegato'; 

$lang['Feedback'] = 'Commento ricevuto'; 

$lang['Real_name_explain'] = 'Inserisci qui il tuo nome completo.<br />Questo ci aiuterà a contattarti meglio se non sei un utente registrato.'; 
$lang['Explain_email'] = 'Inserisci qui il tuo indirizzo e-mail.<br />Questo nel caso si renda necessaria una risposta diretta.'; 
$lang['Comments_explain'] = 'Inserisci qui i tuoi commenti.'; 
$lang['Flood_explain'] = '<br /><br />Questo modulo ha un sistema di controllo Anti-Flood.<br />Potrai inviare soltanto una richiesta ogni %s %s.'; 
$lang['Comments_limit'] = '<br /><br />L\'amministratore ha impostato un limite massimo di %s caratteri disponibili per scrivere il tuo messaggio.'; 
$lang['Attachment_explain'] = 'Se richiesto, inserisci qui un allegato, e sarà ricevuto dall\'amministratore. Sono permessi solo file di dimensione minore o uguale a %sKb.'; 

$lang['Guest'] = 'Ospite'; 
$lang['Notify_IP'] = 'Il tuo indirizzo IP sarà registrato per motivi di sicurezza.'; 
$lang['Fields_required'] = 'I campi contrassegnati con un * sono obbligatori.'; 
$lang['Contact_form'] = 'Modulo di Contatto'; 
$lang['Empty'] = 'Non specificato'; 

$lang['hours'] = 'ore'; 
$lang['hour'] = 'ora'; 

$lang['Chars'] = ' caratteri'; 

$lang['Captcha_code'] = 'Controllo Visuale *'; 
$lang['Captcha_code_explain'] = 'Per favore conferma il codice in immagine.<br />Questo è richiesto per combattere gli spambot.'; 

// 
// Errors 
// 
$lang['Rname-Empty'] = 'Il tuo nome completo non è stato inserito.'; 
$lang['Comments-Empty'] = 'Il campo commenti non è stato inserito.'; 
$lang['Comments_exceeded'] = 'Il tuo messaggio è più lungo di quanto permesso.'; 
$lang['Email-Empty'] = 'Il campo e-mail non è stato inserito.'; 
$lang['Email-Check'] = 'L\'indirizzo e-mail fornito non è valido.'; 
$lang['Attach-File_exists'] = 'Un file con quel nome esiste già dal tuo Indirizzo IP.'; 
$lang['Attach-Too_big'] = 'L\'allegato che hai provato ad inviare è troppo grande. Assicurati che sia di %sKb o inferiore.'; 
$lang['Attach_dud'] = 'L\'allegato che hai provato a caricare non esiste. Prego ricontrollare il link di caricamento.'; 
$lang['Attach-Uploaded'] = 'L\'allegato è stato caricato correttamente.'; 
$lang['Flood_limit'] = 'Spiacente, ma devi aspettare %d ora(e) per poter inserire un nuovo modulo.'; 
$lang['Illegal_ext'] = 'Questo tipo di file (%s) non è permesso!'; 
$lang['Unknown_ext'] = 'Questo tipo di file (%s) non può essere accettato!'; 
$lang['zip_advise'] = 'Se necessario, comprimi il file in zip prima di reinserirlo.'; 
$lang['POST_ERROR'] = 'Errore nel caricamento - Prego riprovare!'; 
$lang['Image_error'] = 'Errore nel caricamento - Impossibile processare questa immagine!'; 
$lang['Image_zip'] = 'Per favore comprimi in zip questo tipo di immagine prima di inviarla.'; 
$lang['Code_Empty'] = 'Non hai confermato il codice in immagine!'; 
$lang['Code_Wrong'] = 'Il codice inserito è errato!'; 

$lang['Contact_error'] = '<b>Si è verificato un errore provando ad inviare il tuo commento!</b>'; 
$lang['Contact_success'] = '<b>Il tuo messaggio è stato inviato correttamente!</b>'; 

$lang['Click_return_form'] = '<br /><br />Clicca %squi%s per ritornare al Modulo di Contatto'; 

$lang['Contact_Disabled'] = 'Il Modulo di Contatto è momentaneamente non disponibile';

// 
// Admin 
// 
$lang['General_settings'] = 'Impostazioni Generali'; 
$lang['Contact_title'] = 'Modulo di Contatto'; 
$lang['Contact_explain'] = 'Utilizza questa pagina per modificare alcune funzioni del Modulo di Contatto come il limite di Flood o i campi obbligatori.'; 
$lang['Req_settings'] = 'Impostazioni obbligatorie'; 
$lang['Attachment_settings'] = 'Impostazioni Allegati'; 
$lang['Contact_updated'] = 'Configurazione aggiornata correttamente'; 
$lang['Click_return_contact'] = 'Clicca %squi%s per ritornare alla configurazione del Modulo di Contatto'; 

$lang['Form_Enable'] = 'Abilita Modulo di Contatto';

$lang['kb'] = 'kilobytes'; 

$lang['Hash'] = 'Metodo di Hash Allegati'; 
$lang['Hash_explain'] = 'Tutti i file caricati possono essere rinominati con hash casuale, per aumentare la sicurezza.'; 
$lang['md5'] = 'MD5'; 
$lang['no_hash'] = 'No Hash'; 

$lang['auth_permission'] = 'Autorizzazioni Allegati'; 
$lang['auth_perm_explain'] = 'Se gli allegati sono permessi puoi selezionare chi può inserire file.'; 
$lang['auth_guests'] = 'Ospiti'; 
$lang['auth_members'] = 'Utenti'; 
$lang['auth_mods'] = 'Moderatori'; 
$lang['auth_admins'] = 'Amministratori'; 

$lang['Require_rname'] = 'Nome completo obbligatorio'; 
$lang['Require_email'] = 'E-mail obbligatoria'; 
$lang['Require_comments'] = 'Commenti obbligatori'; 
$lang['Permit_attachments'] = 'Permetti Allegati'; 
$lang['Prune'] = 'Abilita rimozione automatica'; 
$lang['Prune_explain'] = 'Abilita questa funzione per eliminare ogni istanza SQL che ha già eseguito il proprio lavoro di limite Flood a scopo di ridurre la dimensione del database.'; 
$lang['Max_file_size'] = 'Dimensione massima File'; 
$lang['Max_file_size_explain'] = 'La dimensione massima degli allegati per il loro salvataggio sul tuo Server Web. Ricorda che questo limite non può eccedere quello impostato nel file php.ini. (%s)'; 
$lang['File_root'] = 'Percorso File Allegati'; 
$lang['File_root_explain'] = 'Specifica la cartella nella quale sono salvati gli Allegati. La cartella dovrà avere i permessi CHMOD 777 ed è relativa al percorso di root dell\'installazione phpBB.'; 
$lang['Flood_limit_admin'] = 'Limite Flood'; 
$lang['Flood_limit_admin_explain'] = 'Questo campo definisce il tempo concesso prima che un utente possa inviare un nuovo modulo. Imposta a \'0\' per disabilitare questa funzione (raccomandato solo per test).'; 
$lang['Char_limit_admin'] = 'Numero massimo di caratteri'; 
$lang['Char_limit_admin_explain'] = 'Puoi impostare un limite adeguato su quanti caratteri possono comparire in un messaggio. Imposta a \'0\' per disabilitare questa funzione.'; 

$lang['Captcha'] = 'Opzioni Controllo Visuale'; 
$lang['Activate'] = 'Attivare il Controllo Visuale?'; 
$lang['Enable'] = 'Abilita'; 
$lang['Disable'] = 'Disabilita'; 
$lang['Captcha_explain'] = 'Abilita qui per richiedere agli utenti l\'inserimento di un codice prima di poter inviare il modulo. Questo eviterà l\'abuso del modulo dagli spambots.'; 
$lang['Type'] = 'Aspetto Controllo Visuale'; 
$lang['Type_explain'] = 'Seleziona il tipo di Controllo Visuale che desideri impostare nel tuo Modulo di Contatto.'; 
$lang['Image_bg'] = 'Immagine base'; 
$lang['Coloured'] = 'Colorato'; 
$lang['Random'] = 'Casuale'; 

$lang['Copyright'] = '"Contact Form" by <a href="http://www.phobbia.net/mods/" target="_phpbb"><b>Ma&reg;&copy;uS</b></a> &copy; 2006-2007<br />(Original mod: darkassasin93)';

//
// "Quick Delete" - Added to 7.0.0
//
$lang['QDelete'] = 'Cancella veloce';
$lang['QDelete_disabled'] = 'La cancellazione veloce è stata disabilitata';
$lang['File_Not_Here'] = 'Questo allegato non è presente.';
$lang['File_Removed'] = 'Il file è stato cancellato correttamente.';
$lang['QDelete_explain'] = 'Permetti all\'amministratore di cancellare velocemente gli allegati attraverso un collegamento e-mail?';
$lang['Remove_file'] = 'Per cancellare questo file, segui questo link: %s';

// 
// "Log Messaggi" - Aggiunto nella 8.6.0 
// 
$lang['Admin_email_explain'] = 'Se lasciato vuoto le e-mail saranno inviate all\'indirizzo dell\'amministratore di questo forum';

$lang['Contact_date'] = 'Data';
$lang['Contact_ip'] = 'IP';
$lang['Contact_get'] = '%sScarica%s';
$lang['Contact_remove'] = '%sRimuovi%s';
$lang['Msg_delete'] = 'Cancella';

$lang['Contact_msgs_title'] = 'Modulo di contatto :: Log Messaggi';
$lang['Contact_msgs_text'] = 'Questi sono i messaggi ricevuti attraverso il tuo modulo di contatto, con quelli più recenti mostrati prima.<br />&nbsp;&bull; I Messaggi si possono consultare e cancellare.<br />&nbsp;&bull; I file allegati si possono scaricare e cancellare.';

$lang['Msg_del_success'] = 'Il Messaggio è stato cancellato correttamente';
$lang['File_del_success'] = 'L\'allegato è stato cancellato correttamente';
$lang['Confirm_delete_msg'] = 'Sei sicuro di voler cancellare questo Messaggio?';
$lang['Confirm_delete_file'] = 'Sei sicuro di voler cancellare questo Allegato?';
$lang['File_Not_Here'] = 'L\'allegato non sembra essere presente.';
$lang['Click_return_msglog'] = 'Clicca %squi%s per ritornare ai Log Messaggi';

$lang['Msg_Log'] = 'Log Messaggi';
$lang['Msg_Log_explain'] = 'Attivando questa opzione potrai salvare i Messaggi nel tuo database per riferimento';

$lang['more'] = 'più';

//
// "Thank You" - Added in 8.9.8
//
$lang['Thankyou_settings'] = 'Impostazioni "Ringraziamento"';
$lang['Thankyou_option'] = 'Ringrazia il mittente';
$lang['Thankyou_explain'] = 'Imposta su "Nessuno" per disattivare, su "Membri" affinchè venga ricevuto solo dagli Utenti Registrati, oppure su "Tutti" per includere anche gli Ospiti.';
$lang['Thank_none'] = 'Nessuno';
$lang['Thank_members'] = 'Membri';
$lang['Thank_all'] = 'Tutti';
$lang['Thankyou_limit'] = 'Spiacente, non possiamo più accettare commenti da questo indirizzo e-mail per 24 ore.';

?>