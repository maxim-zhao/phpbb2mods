<?php 
/************************************************************** 
* MOD Title:   Signatures control 
* MOD Version: 1.0.0
* Translation: Português (Portuguese) 
* Rev date:    09/07/2004 
* 
* Translator:  cifroes < cifroes@netcabo.pt > (n/a) n/a
* 
***************************************************************/ 

$lang['sig_settings'] = 'Signature Settings'; 
$lang['sig_settings_explain'] = 'Warning: for all numeric fields (except for imposed font size), set a "0" or nothing means "unlimited"!'; 

$lang['sig_max_lines'] = 'Maximum number of lines'; 
$lang['sig_wordwrap'] = 'Maximum number of characters with no space'; 
$lang['sig_allow_font_sizes'] = 'Text font size [size]'; 
$lang['sig_allow_font_sizes_yes'] = 'Livre'; 
$lang['sig_allow_font_sizes_max'] = 'Limitado'; 
$lang['sig_allow_font_sizes_imposed'] = 'Forçado'; 
$lang['sig_font_size_limit'] = 'Font size limitations or imposed size'; 
$lang['sig_font_size_limit_explain'] = 'phpBB does not manage fonts larger than 29. Moreover if you want to impose a font size, you can not set a size smaller than 7'; 
$lang['sig_min_font_size'] = 'min /'; 
$lang['sig_max_font_size'] = 'max or imposed size'; 
$lang['sig_text_enhancement'] = 'Allow text enhancements'; 
$lang['sig_allow_bold'] = 'Bold [b]'; 
$lang['sig_allow_italic'] = 'Italic [i]'; 
$lang['sig_allow_underline'] = 'Underline [u]'; 
$lang['sig_allow_colors'] = 'Font colors [color]'; 
$lang['sig_text_presentation'] = 'Allow text presentations'; 
$lang['sig_allow_quote'] = 'Quotes [quote]'; 
$lang['sig_allow_code'] = 'Code quotes [code]'; 
$lang['sig_allow_list'] = 'Lists [list]'; 
$lang['sig_allow_url'] = 'Allow urls [url]'; 
$lang['sig_allow_images'] = 'Allow images [img]'; 
$lang['sig_max_images'] = 'Número máximo de imagens'; 
$lang['sig_max_img_size'] = 'Tamanho máximo das imagens'; 
$lang['sig_max_img_size_explain1'] = 'In principle, image size control must not be problematic on this board. Nevertheless, if an image size cannot be checked, set if the image must be allowed by default or refused'; 
$lang['sig_max_img_size_explain2'] = 'Image size control for some images may be impossible on this board (%s). Set if uncontrollable images must be allowed by default or refused'; 
$lang['sig_max_img_size_explain3'] = 'In principle, image size control is impossible on this board (%s). Set if uncontrollable images must be allowed by default or refused'; 
$lang['sig_img_size_legend'] = '(h x w)'; 
$lang['sig_allow_on_max_img_size_fail'] = 'Allow if impossible to control'; 
$lang['sig_max_img_files_size'] = 'Maximum total image files size'; 
$lang['sig_max_img_av_files_size'] = 'Maximum total image+avatar files size'; 
$lang['sig_max_img_av_files_size_explain'] = 'If a value is set in this field, a global control for the file size of the signature\'s images and poster\'s avatar will proceed, and the 2 separate controls will be disabled. If no value or a 0 is set, the global control will be disabled.'; 
$lang['sig_Kbytes'] = 'Kb'; 

$lang['sig_config_error'] = 'Your signature settings are not valid.'; 
$lang['sig_config_error_int'] = 'Data set for these fields are not positive integers (or font sizes resquested are larger than 29):'; 
$lang['sig_config_error_min_max'] = 'You have set incoherent values for minimum and maximum font sizes (min: %s / max: %s). The maximum font size must be larger than the minimum one.'; 
$lang['sig_config_error_imposed'] = 'You have chosen to impose the signature font size but the font size is not valid (%). The minimum is 7 and the maximum 29.'; 

$lang['sig_explain'] = 'A assinatura é um pequeno texto que pode ser adicionado no final das suas mensagens. Está limitada a %s caracteres%s%s%s.'; 
$lang['sig_explain_max_lines'] = ' em %s linha(s)'; // Be careful to the space at the begining! 
$lang['sig_explain_font_size_limit'] = ' (com tamanho entre %s e %s)'; // Be careful to the space at the begining! 
$lang['sig_explain_font_size_max'] = ' (com tamanho máximo de %s)'; // Be careful to the space at the begining! 
$lang['sig_explain_no_image'] = ' e sem imagens'; // Be careful to the space at the begining! 
$lang['sig_explain_images_limit'] = ' e %s imagem(s) com nenhuma delas maior que %sx%s pixels e um tamanho total de %sKb'; // Be careful to the space at the begining! 
$lang['sig_explain_unlimited_images'] = ' e quantas imagens quiser mas nenhuma delas pode exceder %sx%s pixels, e um tamanho total de %sKb'; // Be careful to the space at the begining! 
$lang['sig_explain_avatar_included'] = ', com o avatar incluido'; 
$lang['sig_explain_wordwrap'] = 'No texto, não pode haver mais que %s caracteres sem um espaço no meio deles.'; 

$lang['sig_BBCodes_are_OFF'] = 'BBCodes estão <u>Inactivos</u>'; 
$lang['sig_bbcodes_on'] = '%sBBCodes%s <u>Activos</u>: '; 
$lang['sig_bbcodes_off'] = 'BBCodes <u>Inactivos</u>: '; 
$lang['sig_none'] = 'nenhum'; 
$lang['sig_all'] = 'todos'; 

$lang['sig_error'] = 'A sua assinatura não é válida.'; 
$lang['sig_error_max_lines'] = 'O seu texto inclui %s linhas mas apenas são permitidas %s.'; 
$lang['sig_error_wordwrap'] = 'O seu texto inclui %s grupo(s) com mais de %s caracteres sem espaço no meio deles, o que não é permitido.'; 
$lang['sig_error_bbcode'] = 'Utilizou este(s) BBCode(s) não autorizados: %s'; 
$lang['sig_error_font_size_min'] = 'Utilizou o tamanho de fonte %s enquanto que o minimo autorizado é de %s.'; 
$lang['sig_error_font_size_max'] = 'Utilizou o tamanho de fonte %s enquanto que o máximo autorizado é de %s.';
$lang['sig_error_num_images'] = 'Utilizou %s imagens enquanto que o máximo autorizado é de %s.'; 
$lang['sig_error_images_size'] = 'A imagem: %s é muito grande.<br />O seu tamanho é de %s pixels por %s, enquanto que o máximo autorizado é de  %s por %s.'; 
$lang['sig_unlimited'] = 'ilimitado'; 
$lang['sig_error_images_size_control'] = 'Não é possivel determinar o tamanho da imagem: %s<br />Ou não há nenhuma imagem nesse endereço ou então o forum não foi capaz de a verificar. Assim sendo não pode utilizar essa imagem.'; 
$lang['sig_error_avatar_local'] = 'Há um problema com o ficheiro: %s<br />É impossivel verificar o seu tamanho.'; 
$lang['sig_error_avatar_url'] = 'Este url é errado: %s<br />Não há nenhum avatar nesse endereço.'; 
$lang['sig_error_img_files_size'] = 'O tamanho total dos ficheiros de imagem usados são de %sKb enquanto que o máximo autorizado é de %sKb.'; 
$lang['sig_error_img_av_files_size'] = 'O tamanho total das suas imagens usadas na assinatura (%sKb) mais o seu avatar (%sKb) excedem o máximo autorizado de %sKb.'; 

?>