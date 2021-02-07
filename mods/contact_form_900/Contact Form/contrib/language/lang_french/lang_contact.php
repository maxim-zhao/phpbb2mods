<?php
/***************************************************************************
 *                               lang_contact.php
 *                              ------------------
 *	Version:	9.0.0
 *	Begin:		Sunday, Sept 17, 2006
 *	Copyright:	(C) 2006, Marcus
 *	E-mail:		marcus@phobbia.net
 *	$id:		21:21 01/06/2007
 *	Translated by:	Ram (www.phpbb-fr.com)
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

$lang['Contact_intro'] = 'Si vous avez le moindre commentaires, retour ou suggestions à propos du site, ou si vous avez recontrer des problème avec L\'enregistrement ou logging de votre compte, merci d\'utiliser ce formulaire pour contacer L\'administrateur directement.';

$lang['Username'] = 'Nom d\'utilisateur';
$lang['Real_name'] = 'Nom';
$lang['Rname_require'] = 'Nom *';
$lang['E-mail'] = 'Adresse E-mail';
$lang['E-mail_require'] = 'Adresse E-mail *';
$lang['Comments'] = 'Commentaires';
$lang['Comments_require'] = 'Commentaires *';
$lang['Attachment'] = 'Fichiers Attachés';

$lang['Feedback'] = 'Retour recu';

$lang['Real_name_explain'] = 'Entrer votre nom ici. Cela nous aidera à vous contacter plus facile si vous n\'êtes pas enregistré.';
$lang['Explain_email'] = 'Entrer votre adresse e-mail ici. Utilisée au cas où nous devrions vous répondre directement.';
$lang['Comments_explain'] = 'Entrer vos commentaires ici.';
$lang['Flood_explain'] = '<br /><br />Ce formulaire utilise un système de contrôle de flood. Vous pouvez soumettre votre formulaire une fois toutes les %s %s.';
$lang['Comments_limit'] = '<br /><br />L\'administrateur a entré un nombre de %s caractères maximun pour ce message.';
$lang['Attachment_explain'] = 'Postez votre fichier attaché ici, si requis, et il sera reçu par L\'administrateur du forum. Seulement les fichiers qui font %sKb ou moins peuvent être liés.';

$lang['Guest'] = 'Invité';
$lang['Notify_IP'] = 'Votre adresse IP va être enregistré pour des raisons de sécurité.';
$lang['Fields_required'] = 'Les champs avec un * sont requis.';
$lang['Contact_form'] = 'Formulaire';
$lang['Empty'] = 'Non Specifié';

$lang['hours'] = 'heures';
$lang['hour'] = 'heure';

$lang['Chars'] = ' caractères';

$lang['Captcha_code'] = 'Captcha *';
$lang['Captcha_code_explain'] = 'Merci de confirmer le code de L\'image. Ce champ est requis afin de dissuader le spam des éventuels robots.';

//
// Errors
//
$lang['Rname-Empty'] = 'Votre vrai nom n\'a pas été approuvé.';
$lang['Comments-Empty'] = 'Le champ du commentaire n\'a pas été rempli.';
$lang['Comments_exceeded'] = 'Votre message est plus long que le nombre de caractères spécifiés.';
$lang['Email-Empty'] = 'Le champ du courrier électronique n\'a pas été rempli.';
$lang['Email-Check'] = 'L\'adresse e-mail que vous avez entré n\'est pas valide.';
$lang['Attach-File_exists'] = 'Un fichier existe déjà avec ce nom depuis votre adresse IP.';
$lang['Attach-Too_big'] = 'Le fichier que vous essayez d\'attacher est trop gros. Vérifiez qu\'il pèse %sKb ou moins.';
$lang['Attach_dud'] = 'Le fichier que vous avez essayé d\'envoyer n\'existe pas. Vérifiez votre fichier avant de recommencer.';
$lang['Attach-Uploaded'] = 'Votre fichier a été correctement uploadé.';
$lang['Flood_limit'] = 'Désolé, mais vous d\'avez attendre %d heure(s) avant de pouvoir soumettre à nouveau.';
$lang['Illegal_ext'] = 'Ce type de fichier (%s) n\'est pas permis!';
$lang['Unknown_ext'] = 'Ce type de fichier (%s) ne peut pas être accepté!';
$lang['zip_advise'] = 'Si nécessaire, merci de faire un zip du fichier afin de le soumettre à nouveau.';
$lang['POST_ERROR'] = 'Erreur d\'upload - réessayez!';
$lang['Image_error'] = 'Erreur d\'pload - Incapable de traiter cette image!';
$lang['Image_zip'] = 'Merci de zip l\'image avant de l\'envoyer.';
$lang['Code_Empty'] = 'Vous n\'avez pas confirmer le code sur l\'image!';
$lang['Code_Wrong'] = 'Le code entré est incorrecte!';

$lang['Contact_error'] = '<b>Une erreur est survenue lors de L\'envoie de votre commentaire!</b>';
$lang['Contact_success'] = '<b>Votre message a été envoyé avec succès!</b>';

$lang['Click_return_form'] = '<br /><br />Cliquez %sIci%s pour retourner au formulaire';

$lang['Contact_Disabled'] = 'Le formulaire est actuellement inaccessible.';

//
// Admin
//
$lang['General_settings'] = 'Configuration Général';
$lang['Contact_title'] = 'Formulaire de Contact';
$lang['Contact_explain'] = 'Utilisez cette page pour jouer sur les configurations du Formulaire, ainsi que les conditions des champs.';
$lang['Req_settings'] = 'Configuration requise';
$lang['Attachment_settings'] = 'Configurations des Fichiers Attachés';
$lang['Contact_updated'] = 'Configuration du Contact mis à jour avec succès';
$lang['Click_return_contact'] = 'Cliquez %sICI%s pour retourner à la configuration du Formulaire';
$lang['Disable'] = 'Désactivé';

$lang['Form_Enable'] = 'Activer Le Formulaire';

$lang['kb'] = 'kilobytes';

$lang['Hash'] = 'Attacehment Hashing Méthode';
$lang['Hash_explain'] = 'Chaque uploads peuvent être renommé avec un nom aléatoire, afin d\'augmenter la sécurité.';
$lang['md5'] = 'MD5';
$lang['no_hash'] = 'Pas de Hash';

$lang['auth_permission'] = 'Permissions des Attachments';
$lang['auth_perm_explain'] = 'Si les fichiers attachés sont permis vous pouvez selectionner qui peut uploader des fichiers.';
$lang['auth_guests'] = 'Invités';
$lang['auth_members'] = 'Membres';
$lang['auth_mods'] = 'Modérateurs';
$lang['auth_admins'] = 'Administrateurs';

$lang['Require_rname'] = 'Votre nom est requis';
$lang['Require_email'] = 'Votre e-mail est requis';
$lang['Require_comments'] = 'Votre commentaire est requis';
$lang['Permit_attachments'] = 'Vous pouvez attacher des fichiers';
$lang['Prune'] = 'Activé Pruning';
$lang['Prune_explain'] = 'Activez cette option pour supprimer n\'importe quelles entrées SQL qui ont déjà fait leur "travail" afin de réduire la taille de base de données.';
$lang['Max_file_size'] = 'Taille Maximun des Fichiers';
$lang['Max_file_size_explain'] = 'Taille maximale des fichiers attachés stocker sur votre serveur Web. Souvenez-vous, que cela ne peut pas excéder les configurations de php.ini. (%s)';
$lang['File_root'] = 'Répertoire des Fichiers Attachés';
$lang['File_root_explain'] = 'Le dossier dans lequel les fichers attachés sont stockés. Ce dossier doit être en CHMOD 777 et se trouver à la racine du répertoire de phpBB..';
$lang['Flood_limit_admin'] = 'Limit de Flood';
$lang['Flood_limit_admin_explain'] = 'Duré avant que l\'utilisateur puisse soumettre à nouveau un formulaire. Mettez à \'0\' pour désactiver cette fonction (recommandé seulement pour les tests).';
$lang['Char_limit_admin'] = 'Maximum de Caractères';
$lang['Char_limit_admin_explain'] = 'Fixer un nombre limité de caractères par message.  Mettez l\'option à \'0\' pour la désactiver.';

$lang['Captcha'] = 'Configurations de la Confirmation Visuelle';
$lang['Activate'] = 'Activer la Confirmation Visuelle?';
$lang['Enable'] = 'Activé';
$lang['Disable'] = 'Désactivé';
$lang['Captcha_explain'] = 'Activer ceci pour obliger les utilisateurs à entrer un code avant de soumettre leur formulaire. Cela empêchera un éventuel spam.';
$lang['Type'] = 'Apparance du Captcha';
$lang['Type_explain'] = 'Selectionner le type de Captcha que vous voulez montrer sur votre formulaire.';
$lang['Image_bg'] = 'Image basé';
$lang['Coloured'] = 'Coloré';
$lang['Random'] = 'Aléatoire';

$lang['Copyright'] = '"Contact Form" par <a href="http://www.phobbia.net/mods/" target="_phpbb"><b>Ma&reg;&copy;uS</b></a> &copy; 2006-2007<br />(Original mod: darkassasin93)';

//
// "Quick Delete" - Added to 7.0.0
//
$lang['QDelete'] = 'Quick Delete';
$lang['QDelete_disabled'] = 'L\'option de suppression rapide a été désactivée';
$lang['File_Not_Here'] = 'Cette extension ne semble pas exister.';
$lang['File_Removed'] = 'Le fichier a été correctement supprimé.';
$lang['QDelete_explain'] = 'Permettre à l\'administrateur de supprimer rapidement l\'attachment via le lien de l\'E-mail?';
$lang['Remove_file'] = 'Pour supprimer ce fichier, suivez ce lien: %s';

//
// "Messages Log" - Added in 8.6.0
//
$lang['Admin_email_explain'] = 'Si il y a aucune adresse dans ce champ, les messages seront envoyés à l\'administrateur de ce forum.';

$lang['Contact_date'] = 'Date';
$lang['Contact_ip'] = 'IP';
$lang['Contact_get'] = '%sTélécharger%s';
$lang['Contact_remove'] = '%sEnlever%s';
$lang['Msg_delete'] = 'Supprimer';

$lang['Contact_msgs_title'] = 'Contact Form :: Messages Log';
$lang['Contact_msgs_text'] = 'Ce sont les messages que vous avez reçu via votre Formulaire, avec les derniers messages en tête de liste.<br />&nbsp;&bull; Les messages peuvent être vus et supprimés.<br />&nbsp;&bull; Les fichiers attachés peuvent être recouvrés et supprimés.';

$lang['Msg_del_success'] = 'Le Message a été correctement effacé';
$lang['File_del_success'] = 'Le fichier attaché a été correctement effacé';
$lang['Confirm_delete_msg'] = 'Etes vous sûr de vouloire supprimer ce message?';
$lang['Confirm_delete_file'] = 'Etes vous sûr de vouloire supprimer ce fichier attaché?';
$lang['File_Not_Here'] = 'Ce fichier attaché ne devrait pas exister.';
$lang['Click_return_msglog'] = 'Cliquez %sIci%s pour retourner au Log des Messages';

$lang['Msg_Log'] = 'Messages Log';
$lang['Msg_Log_explain'] = 'Activer cette option vous permet de stocker les messages in votre base de donnée pour servir de référence';

$lang['more'] = 'plus';

//
// "Thank You" - Added in 8.9.8
//
$lang['Thankyou_settings'] = '"Remerciement" Configuration';
$lang['Thankyou_option'] = 'Remercier l\'envoyeur';
$lang['Thankyou_explain'] = 'Mettre "Aucun" pour désactiver, "Membres" pour que seul les utilisateurs enregistrés le recoivent ou "Tous" pour les invités l\'aient aussi.';
$lang['Thank_none'] = 'Aucun';
$lang['Thank_members'] = 'Membres';
$lang['Thank_all'] = 'Tous';
$lang['Thankyou_limit'] = 'Désolé, nous ne pouvons pas accepter plus de retour depuis cette adresse e-mail pour une durée de 24 heures.';

?>