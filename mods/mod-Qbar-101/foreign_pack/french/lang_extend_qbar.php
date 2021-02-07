<?php
/***************************************************************************
 *						lang_extend_qbar.php [French]
 *						--------------------
 *	begin				: 28/09/2003
 *	copyright			: Ptirhiik
 *	email				: ptirhiik@clanmckeen.com
 *
 *	version				: 1.0.0 - 28/09/2003
 *
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

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

// admin part
if ( $lang_extend_admin )
{
	$lang['Lang_extend_qbar']					= 'QBar/Qmenu';

	// title
	$lang['Qbar_admin']							= 'Qbar';
	$lang['Qbar_admin_explain']					= 'Vous pouvez définir ici les barres de navigations ainsi que les menus.';
	$lang['Qbar_admin_panel']					= 'Définition d\'une Qbar';
	$lang['Qbar_admin_panel_explain']			= 'Vous pouvez ici créer et modifier les Qbars, ainsi que la façon selon laquelle elles apparaîtront sur l\'entête du forum.';
	$lang['Qbar_admin_field']					= 'Options d\'une Qbar';
	$lang['Qbar_admin_field_explain']			= 'Ici vous pouvez modifier et ajouter des options à une Qbar.';
	$lang['Qbar_admin_import']					= 'Importer une option';
	$lang['Qbar_admin_import_explain']			= 'Cette fonction permet d\'importer une option d\'une autre Qbar.';
	$lang['Qbar_settings']						= 'Réglages';

	// qbar def
	$lang['Qbar_name']							= 'Nom de la Qbar';
	$lang['Qbar_name_explain']					= 'Le nom de la Qbar n\'est jamais affiché à l\'utilisateur : il s\'agit d\'une référence interne.';
	$lang['Qbar_class']							= 'Classe';
	$lang['Qbar_class_explain']					= 'La classe permet de distinguer une barre située au-dessus de l\'entête du forum d\'un menu situé sur l\'entête du forum.';
	$lang['Qbar_display']						= 'Afficher';
	$lang['Qbar_display_explain']				= 'Choisissez "Oui" pour cette option afin que la Qbar soit affichée sur le forum.';
	$lang['Qbar_cells']							= 'Options par ligne';
	$lang['Qbar_cells_explain']					= 'Nombre d\'options par ligne : si le nombre d\'options de la Qbar dépasse cette valeur, une nouvelle ligne est créée lors de l\'affichage.';
	$lang['Qbar_in_table']						= 'Utiliser un tableau';
	$lang['Qbar_in_table_explain']				= 'Cette option permet d\'afficher une Qbar dans un tableau, donnant l\'impression d\'avoir des boutons plutôt que des liens.';
	$lang['Qbar_style']							= 'Lier à un style spécifique';
	$lang['Qbar_style_explain']					= 'Si vous sélectionnez un style spécifique, la Qbar ne sera affichée que lorsque ce style sera utilisé sur le forum.';
	$lang['Qbar_sub_template']					= 'Lier à un sous-template';
	$lang['Qbar_sub_template_explain']			= 'Si vous choisissez un sous-template, la Qbar ne sera affichée que lorsque le forum utilisera ce sous-template. Choisissez "Aucun" pour n\'afficher la Qbar que lorsqu\'aucun sous-template n\'est utilisé, "Tous" pour l\'afficher quelque soit le sous-template.';

	// field def
	$lang['Qbar_field_name']					= 'Nom de l\'option';
	$lang['Qbar_field_name_explain']			= 'Le nom de l\'option n\'est jamais affiché à l\'utilisateur : il s\'agit d\'une référence interne.';
	$lang['Qbar_shortcut']						= 'Libellé du lien';
	$lang['Qbar_shortcut_explain']				= 'Le libellé du lien est affiché dans la Qbar. Vous pouvez entrer ici du texte, ou une clé du tableau des langues. <br />(se référer à language/lang_<i>votre_language</i>/lang_main.php)';

	$lang['Qbar_explain']						= 'Survol par la souris';
	$lang['Qbar_explain_explain']				= 'Le contenu de cette zone sera affiché lorsque l\'utilisateur passera sa souris sur le lien ou sur l\'icône (mot clés HTML : title & alt). Vous pouvez entrer ici du texte, ou une clé du tableau des langues. <br />(se référer à language/lang_<i>votre_language</i>/lang_main.php)';
	$lang['Qbar_alternate']						= 'Libellé de lien contextuel';
	$lang['Qbar_alternate_explain']				= 'Le libellé de lien contextuel est utilisé pour afficher un message différent en fonction du nombre de messages privés non lus/nouveaux. Vous pouvez entrer ici du texte, ou une clé du tableau des langues. <br />(se référer à language/lang_<i>votre_language</i>/lang_main.php)';
	$lang['Qbar_icon']							= 'Icône';
	$lang['Qbar_icon_explain']					= 'Lien vers une icône ou une clé du tableau des images ($images[]). <br />(se référer à templates/<i>votre_thème</i>/<i>votre_thème</i>.cfg)';
	$lang['Qbar_use_value']						= 'Afficher le lien';
	$lang['Qbar_use_value_explain']				= 'Choisissez "Oui" si vous désirez afficher le libellé du lien dans la Qbar.';
	$lang['Qbar_use_icon']						= 'Afficher l\'icône';
	$lang['Qbar_use_icon_explain']				= 'Choisissez "Oui" si vous désirez afficher l\'icône dans la Qbar.';
	$lang['Qbar_url']							= 'URL du programme';
	$lang['Qbar_url_explain']					= 'Si le programme se trouve dans les répertoires de phpBB, n\'utilisez que l\'URI, sinon renseignez l\'URL complet.';
	$lang['Qbar_internal']						= 'Programme phpBB';
	$lang['Qbar_internal_explain']				= 'En choisissant "Oui", le lien sera considéré comme pointant sur un programme phpBB, et son appel sera sécurisé. La chaîne d\'appel incluera également l\'identifiant de session (&sid).';
	$lang['Qbar_auth_logged']					= 'Connecté';
	$lang['Qbar_auth_logged_explain']			= 'Cette option permet de n\'afficher le lien que si le statut de connection de l\'utilisateur correspond au niveau d\'autorisation demandé : "Ignorer" permettra de ne pas tenir compte du statut de connection de l\'utilisateur.';
	$lang['Qbar_auth_admin']					= 'Niveau administrateur';
	$lang['Qbar_auth_admin_explain']			= 'Cette option permet de n\'afficher le lien que si le niveau d\'autorisation de l\'utilisateur correspond au niveau d\'autorisation demandé : "Ignorer" permettra de ne pas tenir compte du niveau d\'autorisation de l\'utilisateur.';
	$lang['Qbar_auth_pm']						= 'Messages privés en attente';
	$lang['Qbar_auth_pm_explain']				= 'Cette option permet de n\'afficher le lien que si la situation des messages privés de l\'utilisateur correspond au réglage demandé : "Ignorer" permettra de ne pas tenir compte de la situation des messages privés de l\'utilisateur.';
	$lang['Qbar_tree_id']						= 'Arborescence du forum';
	$lang['Qbar_tree_id_explain']				= 'Cette option permet de n\'afficher le lien que si l\'utilisateur est autorisé à voir le forum ou la catégorie lié à l\'option : choisir "Aucun" pour ne pas tenir compte de cette protection.';

	$lang['Qbar_auths']							= 'Autorisations';
	$lang['Qbar_private_messages']				= 'Paramétrages en fonction des messages privés';

	// specific actions
	$lang['Qbar_delete_panel']					= 'Supprimer une Qbar';
	$lang['Qbar_delete_panel_confirm']			= 'Etes-vous sûr de vouloir supprimer la Qbar <b>%s</b> ?';

	$lang['Qbar_delete_field']					= 'Supprimer une option';
	$lang['Qbar_delete_field_confirm']			= 'Etes-vous sûr de vouloir supprimer l\'option <b>%s</b> de la Qbar %s ?';

	// error messages
	$lang['Qbar_error_panel_system']			= 'Vous ne pouvez pas modifier ou supprimer une Qbar système.';
	$lang['Qbar_error_panel_exists']			= 'Le nom de cette Qbar existe déjà.';
	$lang['Qbar_error_panel_not_found']			= 'Le nom de la Qbar est introuvable.';
	$lang['Qbar_error_panel_empty_name']		= 'Vous devez renseigner le nom de la Qbar.';
	$lang['Qbar_error_panel_empty_cells']		= 'Vous devez fixer un nombre d\'options par ligne pour l\'affichage.';

	$lang['Qbar_error_field_exists']			= 'Le nom de l\'option existe déjà.';
	$lang['Qbar_error_field_not_found']			= 'Le nom de l\'option est introuvable.';
	$lang['Qbar_error_field_empty_name']		= 'Vous devez renseigner un nom d\'option.';
	$lang['Qbar_error_field_system']			= 'Vous ne pouvez pas modifier ou supprimer une option d\'une Qbar système.';
	$lang['Qbar_error_field_empty_shortcut']	= 'Vous devez renseigner le libellé du lien si vous désirez l\'utiliser pour l\'affichage.';
	$lang['Qbar_error_field_empty_icon']		= 'Vous devez renseigner le lien vers l\'icône si vous souhaitez l\'utiliser pour l\'affichage.';
	$lang['Qbar_error_field_display_nothing']	= 'Vous devez sélectionner au moins le libellé du lien ou l\'icône pour l\'affichage.';
	$lang['Qbar_error_field_empty_url']			= 'Vous devez renseigner l\'URL ou l\'URI du programme cible.';
	$lang['Qbar_error_field_external_url']		= 'Ne spécifiez pas de domaine (http://) si vous désignez le programme comme étant un programme phpBB.';

	// auths
	$lang['Qbar_auth_ignore']					= 'Ignorer';
	$lang['Qbar_auth_required']					= 'Nécessaire';
	$lang['Qbar_auth_prohibited']				= 'Interdit';
	$lang['Qbar_auth_pm_new']					= 'Nouveaux Messages Privés';
	$lang['Qbar_auth_pm_no_new']				= 'Pas de nouveau message privé';
	$lang['Qbar_auth_pm_unread']				= 'Messages privés non lus';

	// classes
	$lang['Qbar_class_system']					= 'Système';
	$lang['Qbar_class_bar']						= 'Barre';
	$lang['Qbar_class_menu']					= 'Menu';

	// generic actions
	$lang['Create_field']						= 'Ajouter une option';
	$lang['Create_panel']						= 'Ajouter une Qbar';

	// misc.
	$lang['Qbar_none']							= '---------- Aucun ----------';
	$lang['Import']								= 'Importer';
	$lang['Refresh']							= 'Actualiser';
	$lang['Qbar_all']							= '---------- Tous ----------';
}

$lang['FAQ_explain']				= 'Questions fréquemment posées';
$lang['Search_explain']				= 'Rechercher dans les forums';
$lang['Memberlist_explain']			= 'Liste des membres enregistrés';
$lang['Usergroups_explain']			= 'Gestion des groupes';
$lang['Profile_explain']			= 'Editer votre profil';
$lang['Private_Messaging_explain']	= 'Consultez vos messages privés';
$lang['Login_explain']				= 'Connectez-vous sous votre profil pour utiliser votre messagerie';
$lang['Register_explain']			= 'S\'enregistrer';
$lang['Logout_explain']				= 'Se déconnecter';
$lang['Admin_explain']				= 'Aller au panneau de configuration de l\'administrateur (ACP)';
$lang['Forum_index_explain']		= 'Index du forum';

?>