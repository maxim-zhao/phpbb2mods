<?php
/**************************************************************
* MOD Title:   Signatures control
* MOD Version: 1.0.0
* Translation: Russian
* Rev date:    04/09/2004
*
* Translator:  micron < unit86@mail.ru > (n/a) n/a
*
***************************************************************/

$lang['sig_settings'] = 'Настройки подписи';
$lang['sig_settings_explain'] = 'Внимание: в полях цифровых значений (кроме размера шрифта) ноль или пустое поле означает "бесконечно"!';

$lang['sig_max_lines'] = 'Максимальное количество строк';
$lang['sig_wordwrap'] = 'Максимальное количество символов, не разделенных пробелами';
$lang['sig_allow_font_sizes'] = 'Размер шрифта';
$lang['sig_allow_font_sizes_yes'] = 'Любой';
$lang['sig_allow_font_sizes_max'] = 'Ограниченный';
$lang['sig_allow_font_sizes_imposed'] = 'Строго определенный';
$lang['sig_font_size_limit'] = 'Ограничения размера шрифта или строго определенный размер';
$lang['sig_font_size_limit_explain'] = 'phpBB не воспринимает шрифты, чей размер более 29. В то же время, строго определенном размер шрифта не может быть меньше 7';
$lang['sig_min_font_size'] = 'min /';
$lang['sig_max_font_size'] = 'max или строго определенный размер';
$lang['sig_text_enhancement'] = 'Разрешить стиль текста';
$lang['sig_allow_bold'] = 'Жирный [b]';
$lang['sig_allow_italic'] = 'Курсив [i]';
$lang['sig_allow_underline'] = 'Подчеркнутый [u]';
$lang['sig_allow_colors'] = 'Цвет шрифта [color]';
$lang['sig_text_presentation'] = 'Разрешить способ показа текста';
$lang['sig_allow_quote'] = 'Цитаты [quote]';
$lang['sig_allow_code'] = 'Код [code]';
$lang['sig_allow_list'] = 'Список [list]';
$lang['sig_allow_url'] = 'URL [url]';
$lang['sig_allow_images'] = 'Изображения [img]';
$lang['sig_max_images'] = 'Максимальное количество изображений';
$lang['sig_max_img_size'] = 'Максимальный объем изображения';
$lang['sig_max_img_size_explain1'] = 'В приниципе, проверка объема изображения не должна быть проблемой. Однако, если объем все же не может быть проверен, вы должны выбрать, будет ли разрешаться или запрещаться изображение по умолчанию';
$lang['sig_max_img_size_explain2'] = 'Проверка объема изображений может давать сбои (%s). Выберите, будут ли изображения, объем которых невозможно проверить, разрешаться или запрещаться по умолчанию';
$lang['sig_max_img_size_explain3'] = 'Проверка объема изображений невозможна (%s). Выберите, будут ли изображения разрешаться или запрещаться по умолчанию';
$lang['sig_img_size_legend'] = '(ВхШ)';
$lang['sig_allow_on_max_img_size_fail'] = 'Разрешить если невозможно проверить';
$lang['sig_max_img_files_size'] = 'Максимальный объем всех изображений в подписи';
$lang['sig_max_img_av_files_size'] = 'Максимальный объем изображений и аватара';
$lang['sig_max_img_av_files_size_explain'] = 'Если в это поле установлено значение, будет проверяться суммарный объем изображений в подписи и аватара.';
$lang['sig_Kbytes'] = 'Кб';

$lang['sig_config_error'] = 'Ваши настройки подписей неверны';
$lang['sig_config_error_int'] = 'Данные в этих полях содержат отрицательные числа, или размер шрифта установле более 29):';
$lang['sig_config_error_min_max'] = 'Вы установили несвязанные между собой значения минимального и максимального размера шрифта (min: %s / max: %s). Максимальный размер должен быть больше минимального.';
$lang['sig_config_error_imposed'] = 'Вы выбрали строго определенный размер шрифта в подписи, и он оказался ошибочным (%). Значение должно быть от 7 до 29.';

$lang['sig_explain'] = 'Подпись это небольшой текст, который может быть добавлен к вашим сообщениям. Ограничения: %s символов%s%s%s.';
$lang['sig_explain_max_lines'] = ' на %s строке(ах)'; // Be careful to the space at the begining!
$lang['sig_explain_font_size_limit'] = ' (размер от %s до %s)'; // Be careful to the space at the begining!
$lang['sig_explain_font_size_max'] = ', (max размер %s )'; // Be careful to the space at the begining!
$lang['sig_explain_no_image'] = ', без изображений'; // Be careful to the space at the begining!
$lang['sig_explain_images_limit'] = ', %s картинка(ок) размером не более %sx%s пикселей и объемом не более %s Кб'; // Be careful to the space at the begining!
$lang['sig_explain_unlimited_images'] = ', любое количество картинок размером не более %sx%s пикселей и объемом не более %s Кб'; // Be careful to the space at the begining!
$lang['sig_explain_avatar_included'] = ', включая аватар';
$lang['sig_explain_wordwrap'] = 'Также, не допускается более %s символов, не разделенных пробелом.';

$lang['sig_BBCodes_are_OFF'] = 'BBCode <u>ВЫКЛ</u>';
$lang['sig_bbcodes_on'] = '%sBBCodes%s ВКЛ: ';
$lang['sig_bbcodes_off'] = 'BBCodes ВЫКЛ: ';
$lang['sig_none'] = 'ничего';
$lang['sig_all'] = 'все';

$lang['sig_error'] = 'Ваша подпись не удовлетворяет установленным требованиям.';
$lang['sig_error_max_lines'] = 'В вашей подписи %s строк, однако разрешено только %s.';
$lang['sig_error_wordwrap'] = 'В вашей подписи %s группа(ы), длинной более %s символо, не разделенных пробелом.';
$lang['sig_error_bbcode'] = 'Вы использовали следующие запрещенные BBCode: %s';
$lang['sig_error_font_size_min'] = 'Вы использовали размер шрифта %s, однако минимально разрешенный размер составляет %s.';
$lang['sig_error_font_size_max'] = 'Вы использовали размер шрифта %s, однако максимально разрешенный размер составляет %s.';
$lang['sig_error_num_images'] = 'Вы использовани %s картинки(у), однако разрешено использовать лишь %s.';
$lang['sig_error_images_size'] = 'Изображение %s слишком велико по размеру.<br />Его размер составляет %sх%s пикселей, однако макчимально разрешенный размер составляет %х%s пикселей.';
$lang['sig_unlimited'] = 'неограниченно';
$lang['sig_error_images_size_control'] = 'Невозможно проверить размер изображения %s<br />Возможно по этому адресу нету изображения или же не поддерживается формат изображения.';
$lang['sig_error_avatar_local'] = 'Возникла проблема с изображением %s<br />Невозможно проверить объем изображения.';
$lang['sig_error_avatar_url'] = 'Этот адрес является ошибочным: %s<br />По указанному адресу аватар не найден.';
$lang['sig_error_img_files_size'] = 'Общий объем изображений в подписи составляет %s Кб, что превышает максимально допустимый размер (%s Кб).';
$lang['sig_error_img_av_files_size'] = 'Общий объем изображений в подписи(%s Кб) и аватара (%s Кб) превышает установленный на уровне %s Кб максимальный размер.';

?>