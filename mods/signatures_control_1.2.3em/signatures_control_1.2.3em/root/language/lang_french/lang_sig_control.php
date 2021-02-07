<?php
/**************************************************************
*  MOD Title:   Signatures control
*  MOD Version: 1.2.2
*  Translation: Français (French)
*  Rev date:    28/05/2005
*
*  Translator:  -=ET=- < space_et@tiscali.fr > (n/a) http://www.golfexpert.net/phpbb
*
***************************************************************/

$lang['sig_settings'] = 'Options des Signatures';
$lang['sig_settings_explain'] = 'Attention : pour tous les champs numériques (sauf la taille de police imposée), saisir un "0" ou rien signifie "illimité" !';

$lang['sig_max_lines'] = 'Nb de lignes maximum';
$lang['sig_wordwrap'] = 'Nb de caractères maximum sans espace';
$lang['sig_allow_font_sizes'] = 'Taille des caractères [size]';
$lang['sig_allow_font_sizes_yes'] = 'Libre';
$lang['sig_allow_font_sizes_max'] = 'Limitée';
$lang['sig_allow_font_sizes_imposed'] = 'Imposée';
$lang['sig_font_size_limit'] = 'Limites de la taille ou taille imposée';
$lang['sig_font_size_limit_explain'] = 'phpBB ne gère pas les tailles supérieures à 29. Par ailleurs si vous voulez imposer une taille, vous ne pouvez pas paramétrer une taille inférieur à 7';
$lang['sig_min_font_size'] = 'min /';
$lang['sig_max_font_size'] = 'max ou taille imposée';
$lang['sig_text_enhancement'] = 'Autoriser les enrichissements';
$lang['sig_allow_bold'] = 'Gras [b]';
$lang['sig_allow_italic'] = 'Italique [i]';
$lang['sig_allow_underline'] = 'Souligné [u]';
$lang['sig_allow_colors'] = 'Couleurs de texte [color]';
$lang['sig_text_presentation'] = 'Autoriser les mises en forme';
$lang['sig_allow_quote'] = 'Citations [quote]';
$lang['sig_allow_code'] = 'Citations de code [code]';
$lang['sig_allow_list'] = 'Listes [list]';
$lang['sig_allow_url'] = 'Autoriser les urls [url]';
$lang['sig_allow_images'] = 'Autoriser les images [img]';
$lang['sig_max_images'] = 'Nombre maximum d\'images autorisé';
$lang['sig_max_img_size'] = 'Dimensions maximum des images';
$lang['sig_max_img_size_explain1'] = 'Le contrôle de la taille des images ne doit à priori pas poser de pb. Néanmoins, indiquez si une image n\'était pas contrôlable elle devrait être acceptée par défaut ou refusée';
$lang['sig_max_img_size_explain2'] = 'Le contrôle de la taille de certaines images est impossible sur ce forum (%s). Indiquez si les images qui ne peuvent pas être contrôlées doivent être acceptées par défaut ou refusées';
$lang['sig_max_img_size_explain3'] = 'Le contrôle de la taille des images est à priori impossible sur ce forum (%s). Indiquez si les images qui ne peuvent pas être controlées doivent être acceptées par défaut ou refusées';
$lang['sig_img_size_legend'] = '(h x l)';
$lang['sig_allow_on_max_img_size_fail'] = 'Autoriser si contrôle impossible';
$lang['sig_max_img_files_size'] = 'Taille max. du total des fichiers image';
$lang['sig_max_img_av_files_size'] = 'Taille max. du total des fichiers image+avatar';
$lang['sig_max_img_av_files_size_explain'] = 'Si une valeur est saisie dans ce champ un contrôle global de la taille des fichiers image de la signature et de l\'avatar sera activé, et les 2 contrôles séparés seront désactivés. Si aucune valeur n\'est saisie ou un 0, le contrôle global sera désactivé.';
$lang['sig_Kbytes'] = 'Ko';
$lang['sig_exotic_bbcodes_disallowed'] = 'Interdire d\'autres BBCodes';
$lang['sig_exotic_bbcodes_disallowed_explain'] = 'Indiquer les autres BBCodes qui doivent être interdit (ex. : fade,php,shadow)';
$lang['sig_allow_smilies'] = 'Autoriser les smilies';
$lang['sig_reset'] = 'Réinitialiser les signatures des membres';
$lang['sig_reset_explain'] = 'Efface les signatures des profils de <span style="color: #800000">tous les membres !</span> Cela permet de les obliger à les resaisir et donc à les faire valider';
$lang['sig_reset_confirm'] = 'Etes vous sûr de vouloir effacer les signatures de tous les membres ?';

$lang['sig_reset_successful'] = 'Les signatures de tous les membres ont été effacées des profils avec succès !';
$lang['sig_reset_failed'] = 'Erreur : les signatures des membres n\'ont pas pu être effacées.';

$lang['sig_config_error'] = 'Vos paramétrages des signatures ne sont pas corrects.';
$lang['sig_config_error_int'] = 'Les données saisies pour les champs suivant ne sont pas des nombres entiers positifs (ou les polices de caractères demandées sont supérieures à 29) :';
$lang['sig_config_error_min_max'] = 'Vous avez saisi des valeurs incohérentes pour les tailles de police minimum et maximum (min : %s / max : %s). La taille de police de caractère maximum doit être plus grande que la taille minimum.';
$lang['sig_config_error_imposed'] = 'Vous avez sélectionné le fait que la taille de caractère soit imposée mais avec une taille de caractère incorrecte (%). Le minimum est de 7 et le maximum de 29.';

$lang['sig_allow_signature'] = 'Peut afficher une signature';
$lang['sig_yes_not_controled'] = 'Oui sans contrôle';
$lang['sig_yes_controled'] = 'Oui contrôlée';

$lang['sig_explain'] = 'Une signature est un petit texte qui peut être ajouté au bas des messages que vous postez.';
$lang['sig_explain_limits'] =  'Il est limité à %s caractères%s%s%s.';
$lang['sig_explain_max_lines'] = ' sur %s ligne(s)'; // Be careful to the space at the begining!
$lang['sig_explain_font_size_limit'] = ' (taille %s à %s)'; // Be careful to the space at the begining!
$lang['sig_explain_font_size_max'] = ' (taille %s maximum)'; // Be careful to the space at the begining!
$lang['sig_explain_no_image'] = ' et aucune image'; // Be careful to the space at the begining!
$lang['sig_explain_images_limit'] = ' et %s image(s) dont aucune ne peut dépasser %sx%s pixels, pour un total de %sKo maximum'; // Be careful to the space at the begining!
$lang['sig_explain_unlimited_images'] = ' et autant d\'images que vous voulez mais aucune ne peut dépasser %sx%s pixels et pour un total de %sKo maximum'; // Be careful to the space at the begining!
$lang['sig_explain_avatar_included'] = ', avatar inclus';
$lang['sig_explain_wordwrap'] = 'Dans le texte, pas plus de %s caractères sans espace non plus.';

$lang['sig_BBCodes_are_OFF'] = 'Les BBCodes sont <u>Désactivés</u>';
$lang['sig_bbcodes_on'] = '%sBBCodes%s activés : ';
$lang['sig_bbcodes_off'] = '%sBBCodes%s désactivés : ';
$lang['sig_none'] = 'aucun';
$lang['sig_all'] = 'tous';

$lang['sig_error'] = 'Votre signature n\'est pas conforme.';
$lang['sig_error_max_lines'] = 'Votre texte comprend %s lignes alors que %s seulement sont autorisées.';
$lang['sig_error_wordwrap'] = 'Votre texte comprend %s suite(s) de plus de %s caractères sans espace alors que c\'est interdit.';
$lang['sig_error_bbcode'] = 'Vous avez utilisez ce(s) BBCode(s) interdit(s) : %s';
$lang['sig_error_font_min'] = 'Vous avez utilisé la taille de caractères %s alors que le minimum autorisé est de %s.';
$lang['sig_error_font_max'] = 'Vous avez utilisé la taille de caractères %s alors que le maximum autorisé est de %s.';
$lang['sig_error_num_images'] = 'Vous avez utilisé %s images alors que le maximum autorisé est de %s.';
$lang['sig_error_images_size'] = 'L\'image %s est trop grande.<br />Sa taille est de %s pixels de haut et %s de large alors que le maximum autorisé par image est de %s en hauteur et %s en largeur.';
$lang['sig_unlimited'] = 'illimité';
$lang['sig_error_images_size_control'] = 'Il est impossible de contrôler la taille de cette image : %s<br />Soit il n\'y a pas d\'image à cette adresse, soit le forum n\'est pas en mesure de la contrôler et vous ne pouvez donc pas l\'utiliser.';
$lang['sig_error_avatar_local'] = 'Ce fichier a un problème : %s<br />Il est impossible d\'en vérifier sa taille.';
$lang['sig_error_avatar_url'] = 'Cette url doit être erronée : %s<br />Il n\'y a pas d\'avatar à cette adresse.';
$lang['sig_error_img_files_size'] = 'Le taille totale des images utilisées est de %sKo alors que le maximum autorisé est de %sKo.';
$lang['sig_error_img_av_files_size'] = 'Le taille totale des images utilisées pour votre signature (%sKo) et votre avatar (%sKo) est supérieure aux %sKo autorisés.';

?>