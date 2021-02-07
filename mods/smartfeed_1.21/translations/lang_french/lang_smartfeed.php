<?php 
/***************************************************************************
                             lang_smartfeed.php
                             -------------------
    begin                : Mon, Jan 15, 2007
    copyright            : (c) Mark D. Hamill
    email                : mhamill@computer.org

    $Id: $

 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

// lang_smartfeed.php
// Written by Mark D. Hamill, mhamill@computer.org
// This software is designed to work with phpBB Version 2.0.22

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

$lang['smartfeed_atom_10'] = 'Atom 1.0';
$lang['smartfeed_rss_20'] = 'RSS 2.0';
$lang['smartfeed_rss_10'] = 'RSS 1.0';
$lang['smartfeed_rss_091'] = 'RSS 0.91 (RDF) - 15 items maximum';

$lang['smartfeed_copyright'] = ''; // Add a copyright statement for your site if it applies
$lang['smartfeed_editor'] = ''; // Most likely your site will not have a managing editor. If so enter email address of managing editor 
$lang['smartfeed_webmaster'] = ''; // If so inclined, enter email address of the webmaster of the phpBB forum

// Various error messages. Customize or internationalize as you prefer.
$lang['smartfeed_error_title'] = 'Erreur dans vote URL SmartFeed';
$lang['smartfeed_error_introduction'] = 'Il y a une erreur dans l\'URL utilisée pour récupérer ce flux. Par conséquent, aucun contenu n\'a été retourné. Utilisez cette information comme guide afin de corriger le problème. Veuillez prendre note que vous devez utiliser <a href="%s">ce lien</a> afin de créer une URL qui peut être utilisée par SmartFeed. Erreur: ';
$lang['smartfeed_no_e_param'] = 'Le paramètre "u" doit être utilisé avec le paramètre "e". ';
$lang['smartfeed_no_u_param'] = 'Le paramètre "e" doit être utilisé avec le paramètre "u". ';
$lang['smartfeed_user_table_count_error'] = 'Erreur de la base de données lors de la récupération du <i>user_id</i> de la table des utilisateurs.';
$lang['smartfeed_user_id_does_not_exist'] = 'Le paramètre "u" ne concorde avec aucun utilisateur de ce site. Le compte pourrait avoir été supprimé.';
$lang['smartfeed_user_table_password_error'] = 'Erreur de la base de données lors de la récupération des mots de passe de la table des utilisateurs.';
$lang['smartfeed_bad_password_error'] = 'L\'identification a échouée. Le paramètre "e" "%s" est invalide avec le paramètre "u" de "%s". Cette erreur peut être causée par la modification de votre mot de passe phpBB, ou une mise à jour de SmartFeed. Pour corriger ce problème, veuillez créer une nouvelle URL SmartFeed au %s, puis copiez et collez celle-ci dans votre lecteur de flux.';
$lang['smartfeed_forum_access_reg'] = 'Erreur lors de la récupération d\'une liste de <i>forum_ids</i> à laquelle tous les membres ont accès.';
$lang['smartfeed_forum_access_priv'] = 'Erreur lors de la récupération d\'une liste de <i>forum_ids</i> privées.';
$lang['smartfeed_user_error'] = 'Erreur lors de la récupération de la donnée <i>user_lastvisit</i> de la table des utilisateurs.';
$lang['smartfeed_limit_format_error'] = 'Le paramètre limitateur n\'est pas d\'une valeur reconnue.';
$lang['smartfeed_retrieve_error'] = 'Impossible de receuillir l\'information de la base de données afin de créer le flux.';
$lang['smartfeed_feed_type_error'] = 'SmartFeed n\'accepte pas le type de flux demandé.';
$lang['smartfeed_sort_by_error'] = 'SmartFeed n\'accepte pas la méthode de tri demandée.';
$lang['smartfeed_topics_only_error'] = 'SmartFeed n\'accepte pas la valeur du type de sujet demandée.';
$lang['smartfeed_lastvisit_param'] = 'Le paramètre de la dernière visite spécifié n\'est pas valide.';
$lang['smartfeed_reset_error'] = 'Erreur de la base de données: impossible de réinitialiser la date de votre dernière visite.';
$lang['smartfeed_ip_auth_error'] = 'Cette URL ne peut être utilisée afin de récupérer un flux à partir de cette adresse IP. Exécutez smartfeed_url.' . $phpEx . ' à partir de ce poste et utilisez la nouvelle URL générée afin de récupérer un flux.'; 
$lang['smartfeed_not_logged_in'] = '<b>Puisque vous n\'êtes pas connecté au site, vous pouvez uniquement souscrire à la liste des forums publics affichée ci-dessous. Veuillez vous  <a href="' . append_sid("login.$phpEx?redirect=smartfeed_url.$phpEx", true) . "\">connecter</a> ou vous <a href=\"./profile.$phpEx?mode=register\">enregistrer</a> si vous désirez également souscrire aux forums privés.</b>";
$lang['smartfeed_remove_yours_error'] = 'La valeur du paramètre <i>removemine</i> est invalide.';
$lang['smartfeed_no_arguments'] = 'Ce script nécessite des arguments.';
$lang['smartfeed_max_word_size_error'] = 'Le paramètre <i>max_word_size</i> est invalide.';
$lang['smartfeed_first_post_only_error'] = 'Le paramètre <i>firstpostonly</i> est invalide. Si présent, il ne devrait avoir qu\'une valeur de 1.';
$lang['smartfeed_pms_not_for_public_users'] = 'Le paramètre <i>pms</i> n\'est pas autorisé pour les utilisateurs non enregistrés.';
$lang['smartfeed_bad_pms_value'] = 'Le paramètre <i>pms</i> (pour les messages privés) doit avoir une valeur de 1';
$lang['smartfeed_pm_retrieve_error'] = 'Impossible de récupérer les informations concernant la messagerie privée de la base de données.';
$lang['smartfeed_pm_count_error'] = 'Impossible d\'obtenir le nombre de messages privés de l\'utilisateur de la base de données.';
$lang['smartfeed_p_parameter_obsolete'] = 'Authentication failure. Due to a software upgrade, the "p" parameter is no longer allowed. To solve this problem, create a new SmartFeed URL at %s, then copy and paste the generated URL into your newsreader application.';

// Miscellaneous variables
$lang['smartfeed_feed_title'] = $board_config['sitename'];
$lang['smartfeed_feed_description'] = $board_config['site_desc'];
$lang['smartfeed_image_title'] = $board_config['site_desc'] . ' Logo';
$lang['smartfeed_reply'] = 'Réponse';
$lang['smartfeed_reply_by'] = 'Réponse par';
$lang['smartfeed_version'] = 'version';

// These are used by smartfeed_url.php
$lang['smartfeed_feed_type'] = '<b>Sélectionnez le type de flux:</b><br />Soyez certain de choisir un format compatible avec votre lecteur de flux.';
$lang['smartfeed_page_title'] = 'SmartFeed';
$lang['smartfeed_explanation'] = "De plus en plus de gens découvrent les avantages que procurent les flux de nouvelles. En utilisant ceux-ci, vous n'avez pas à visiter le site afin de lire son contenu. Un <i>lecteur de flux</i> récupère et affiche les nouvelles de sites Web multiples pour vous.<br /><br />\r\nCertains forums sur ce site ne peuvent être lus que par les membres, alors que d'autres requièrent votre inscription à un Groupe particulier. Normalement, ces forums ne seraient pas accessibles via un flux public. Cependant, ce site utilise <i>SmartFeed</i>. Il s'agit d'un module phpBB qui permet aux utilisateurs connectés d'avoir accès aux flux des forums publics et privés de ce site. Le tout est rendu possible par votre identification via une URL particulière que vous créez sur cette page. Vous sélectionnez les forums sur ce site qui vous intéressent et que vous désirez inclure dans votre flux personnalisé. Vous pouvez choisir le format de flux que vous préférez. SmartFeed supporte les protocoles RSS et Atom. Prenez soin de sélectionner le format approprié. En cliquant sur le bouton <i>Générer l'URL</i> près du bas de cette page, vous obtiendrez l'URL particulière que vous utiliserez. Copiez et collez cette information dans votre lecteur de flux afin d'accéder au site avec celui-ci.<br /><br />\r\nSi vous êtes débutant avec les flux et les lecteurs de nouvelles, nous vous invitons à lire <a href=\"http://fr.wikipedia.org/wiki/Agr%C3%A9gateur\" target=\"_blank\">cet article de Wikipédia</a>. Il inclus un lien vers de nombreux lecteurs de flux que vous voudrez peut-être télécharger. Vous préférerez peut-être accéder aux flux via des sites Web tel que <a href=\"http://www.bloglines.com\" target=\"_blank\">Bloglines</a>, conçu spécialement à cet effet.<br /><br />Si vous n'êtes pas enregistré sur ce site, vous pouvez tout de même récupérer un flux. Cependant, vous pouvez uniquement souscrire à la liste des forums publics.";
$lang['smartfeed_lastvisit'] = '<b>Réinitialiser la date de votre dernière visite lorsque vous accédez au flux?</b><br />Sélectionnez <i>Oui</i> si vous utiliserez normalement le flux afin de lire le contenu de ce site. Sélectionnez <i>Non</i> si vous visitez régulièrement ce site <i>et</i> vous désirez que les items du flux apparaissent comme étant non lus lorsque vous visitez celui-ci. Attention: sélectionner <i>Non</i> pourrait retourner un flux de taille importante. De plus, vous pourriez remarquer une redondance des articles lors de la mise à jour du flux.';
$lang['smartfeed_yes'] = 'Oui';
$lang['smartfeed_no'] = 'Non';
$lang['smartfeed_all_forums']='Tous les forums';
$lang['smartfeed_select_forums']='<b>Le flux devrait inclure les messages de ces forums:</b>';
$lang['smartfeed_generate_url_text']='Générer l\'URL';
$lang['smartfeed_reset_text']='Réinitialiser';
$lang['smartfeed_auth_reg_text']='<i>(Membres enregistrés uniquement)</i>';
$lang['smartfeed_auth_acl_text']='<i>(Membres accès spécial uniquement)</i>';
$lang['smartfeed_auth_mod_text']='<i>(Modérateurs uniquement)</i>';
$lang['smartfeed_auth_admin_text']='<i>(Administrateurs uniquement)</i>';
$lang['smartfeed_limit_text']='<b>Lors de la récupération des messages, limiter le flux aux messages publiés depuis:</b><br />Si vous utilisez un module complémentaire pour votre navigateur comme lecteur de flux (tel que Sage pour Firefox), un cookie permanent contenant le moment de votre dernier accès au flux sera créé. Veuillez noter que la majorité des lecteurs de flux personnels ignorent les cookies.';
$lang['smartfeed_since_last_fetch_or_visit']='La dernière mise à jour du flux ou visite du site';
$lang['smartfeed_since_last_fetch_or_visit_value']='LF';
$lang['smartfeed_last_week']='7 jours';
$lang['smartfeed_last_week_value']='7 DAY';
$lang['smartfeed_last_day']='24 heures';
$lang['smartfeed_last_day_value']='1 DAY';
$lang['smartfeed_last_12_hours']='12 heures';
$lang['smartfeed_last_12_hours_value']='12 HOUR';
$lang['smartfeed_last_6_hours']='6 heures';
$lang['smartfeed_last_6_hours_value']='6 HOUR';
$lang['smartfeed_last_3_hours']='3 heures';
$lang['smartfeed_last_3_hours_value']='3 HOUR';
$lang['smartfeed_last_1_hours']='1 heure';
$lang['smartfeed_last_1_hours_value']='1 HOUR';
$lang['smartfeed_last_30_minutes']='30 minutes';
$lang['smartfeed_last_30_minutes_value']='30 MINUTE';
$lang['smartfeed_last_15_minutes']='15 minutes';
$lang['smartfeed_last_15_minutes_value']='15 MINUTE';
$lang['smartfeed_sort_by']='<b>Trier par:</b><br />L\'ordre standard est l\'ordre dans lequel les messages apparaissent sur ce Forum, c\'est-à-dire par Catégorie, Forum, Sujet (Desc), Date/heure du message.';
$lang['smartfeed_sort_forum_topic']='Ordre standard';
$lang['smartfeed_sort_forum_topic_desc']='Ordre standard, derniers messages en premier';
$lang['smartfeed_sort_post_date']='Date/heure du message';
$lang['smartfeed_sort_post_date_desc']='Date/heure du message, derniers messages en premier';
$lang['smartfeed_count_limit'] = '<b>Nombre maximum de messages dans le flux:</b><br />Entrez une valeur numérique positive. Entrez <i>All</i> afin d\'obtenir tous les messages qui répondent à vos critères.';
$lang['smartfeed_no_forums_selected']='Vous n\'avez sélectionné aucun forum; ainsi, aucune URL ne peut être générée. Veuillez sélectionner au moins un forum.';
$lang['smartfeed_topics_only']='<b>N\'afficher que les nouveaux sujets?</b>';
$lang['smartfeed_url_label']='Après avoir cliqué sur le bouton <i>Générer l\'URL</i>, celle dont vous avez besoin apparaîtra dans la boîte ci-dessous. <b>Copiez et collez cette information dans votre lecteur de flux.</b> Si vous modifiez vos options, cliquez de nouveau sur <i>Générer l\'URL</i> et vous en obtiendrez une nouvelle.';
$lang['smartfeed_ip_auth']='<b>Activer l\'identification au flux par IP?</b><br />Ceci peut être utilisé comme mesure de sécurité supplémentaire afin de prévenir le piratage d\'URL. L\'URL générée ainsi sera valide uniquement pour la plage d\'adresses IP associée à votre ordinateur. Par exemple, si votre adresse IP actuelle est 123.45.67.89 et que l\'identification au flux par IP est activée, le flux ne sera accessible qu\'à l\'intérieur de la plage d\'adresses 123.45.67.*.';
$lang['smartfeed_remove_yours']='<b>Exclure mes messages du flux?</b>';
$lang['smartfeed_max_size']='<b>Nombre maximum de mots affichés par message:</b><br />Entrez une valeur numérique positive. Entrez <i>All</i> afin d\'afficher le message en entier. Attention: entrer un nombre peut causer des erreurs de validation de flux.';
$lang['smartfeed_max_words_wanted']='All';
$lang['smartfeed_size_error']='Vous devez entrer une valeur numérique positive ou le mot All dans ce champ.';
$lang['smartfeed_count_limit_error']='Le paramètre <i>count_limit</i> doît être supérieur à 0.';
$lang['smartfeed_count_limit_consistency_error']= 'Le paramètre <i>count_limit</i> ne peut être utilisé que lorsque le paramètre <i>sort_by</i> est réglé sur <i>postdate_desc</i>.';
$lang['smartfeed_first_post_only']='Premier message uniquement?';
$lang['smartfeed_private_messages_in_feed']='<b>Afficher les messages privés dans le flux?</b>';
$lang['smartfeed_no_mcrypt'] = '<b>*** Warning! PHP mcrypt extension is not available! Consequently only public forums can be selected. ***</b>';

// Used in Admininstrator interface to smartfeed_url.php
$lang['smartfeed_advertising_interface_title'] = 'Options publicitaires de l\'administrateur';
$lang['smartfeed_enable_ads'] = '<b>Afficher des publicités dans le Flux?</b>';
$lang['smartfeed_set_ad_options'] = 'Activer les options publicitaires';
$lang['smartfeed_set_top_options'] = 'Afficher une pub en haut de page';
$lang['smartfeed_set_middle_options'] = 'Afficher une pub entre les items à l\'intérieur du flux';
$lang['smartfeed_set_bottom_options'] = 'Afficher une pub en bas de page';
$lang['smartfeed_ad_item_title'] = '<b>Titre de la publicité</b><br />Requis si cette section est activée. N\'utilisez que du texte simple; aucun caractère spécial ou HTML.';
$lang['smartfeed_ad_item_link'] = '<b>Lien vers des détails supplémentaires</b><br />Vous pouvez laisser ce champ vide si non applicable. Assurez-vous que le lien débute par http://';
$lang['smartfeed_ad_item_desc'] = '<b>Description complète de la publicité</b><br />Vous pouvez laisser ce champ vide si non applicable. Dans la plupart des cas, vous voudrez ajouter des détails supplémentaires à propos du produit ou du service offert. Vous pouvez utiliser du texte simple, HTML ou du contenu XML spécifiquement adapté pour les flux RSS ou Atom. Avertissement: ce ne sont pas tous les lecteurs de flux qui afficheront ou convertiront adéquatement le HTML. Veuillez ne PAS utiliser de Javascript puisque la majorité des lecteurs de flux ne peuvent exécuter le Javascript. Toute barre oblique inversée (\) sera supprimée.';
$lang['smartfeed_ad_item_header_top'] = 'Pub en haut de page';
$lang['smartfeed_ad_item_header_middle'] = 'Pub au milieu du flux';
$lang['smartfeed_ad_item_header_bottom'] = 'Pub en bas de page';
$lang['smartfeed_ad_item_repeat'] = '<b>Entrez le nombre d\'items du flux à afficher avant l\'insertion de la publicité</b><br />Requis et doit être supérieur à 0.';
$lang['smartfeed_ad_clear'] = 'Effacer tous les champs de la section publicitaire';
$lang['smartfeed_repeat_must_be_numeric'] = 'Le nombre de messages du flux à afficher doit être numéral';
$lang['smartfeed_repeat_must_be_greater_0'] = 'Le nombre de messages du flux à afficher doit être supérieur à 0';
$lang['smartfeed_title_required'] = 'Si une section est activée, son champ titre doit être renseigné.';
$lang['smartfeed_advertising_introduction'] = 'Cette section n\'apparaît qu\'aux administrateurs.<br /><br />Smartfeed permet l\'insertion de publicités dans les flux offerts aux usagers. Utilisez cette interface pour activer, désactiver et configurer les publicités. Celles-ci apparaissent comme tout autre item dans le flux, mais sont clairement identifiées comme étant des publicités. Les publicités peuvent apparaîtrent à trois endroits dans le flux: avant le premier item, au bas du flux, ou périodiquement à l\'intérieur du flux. Prenez note que certains lecteurs de flux, tel que IE 7, permettent à l\'utilisateur de modifier l\'ordre dans lequel les items sont affichés. Par conséquent, on ne peut garantir que les publicités s\'afficheront à l\'endroit spécifié dans le flux. Chacune des sections peut être activée ou non. Le contenu peut être activé ou non via la case à cocher principale. S\'il est désactivé, toute information présente dans les champs publicitaires peut être activée plus tard.<br /><br />Veuillez prendre note qu\'au moment d\'écrire ces lignes, Google Adsense ne supporte pas le RSS et que conséquemment, le Javascript fournit avec Google Adsense ne fonctionnera sans doute pas. Vous devriez vérifier le contenu de votre flux avec publicité vous-même à l\'aide d\'une variété de lecteurs de flux afin de vous assurer que le texte s\'affiche correctement et que votre contenu est rendu convenablement. Notez qe des lecteurs de flux différents peuvent donner des résultats tout aussi différents.<br /><br />Veuillez vous assurer que votre navigateur est configuré de telle sorte qu\'il accepte l\'ouverture de fenêtres pop-up sur ce site. Autrement, s\'il devait y avoir des messages d\'erreurs, vous pourriez ne pas être en mesure de les afficher.';
$lang['smartfeed_advertising_path_error'] = 'Impossible de lire ou de créer les fichiers contenant les données de votre publicité. Ceci pourrait être dû au fait que le répertoire où le fichier doit résider ne possède pas les autorisation nécessaires.';
$lang['smartfeed_ad_data_saved'] = 'Vos options publicitaires ont été enregistrées';
$lang['smartfeed_ad_data_invalid_user'] = 'Vos options publicitaires n\'ont PAS été enregistrées. Une tentative de piratage est sans doute à l\'origine de cette erreur, pusique l\'utilisateur qui a tenté de sauvegarder les données publicitaires n\'a pas les privilèges d\'un administrateur.';
$lang['smartfeed_ad_data_access_error'] = 'Impossible d\'accéder au fichier contenant les informations publicitaires. Sans doute un problème lié aux permissions du fichier.';
$lang['smartfeed_ad_feed_category'] = 'Publicité'; // The feed item category to use for ads, and also in the item title to distinguish the item as advertising
$lang['smartfeed_show_ads_to_public_only'] = 'Afficher des publicités aux utilisateurs publics (non enregistrés) seulement (ne s\'applique que si les publicités sont activées)';

?>