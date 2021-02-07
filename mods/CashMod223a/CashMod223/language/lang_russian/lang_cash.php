<?php

/***************************************************************************
 *                            lang_cash.php [Russian]
 *                              -------------------
 *     begin                : Sat Jul 20 2003
 *     copyright            : (C) 2003 swamper@ua.fm
 *     email                : swamper@ua.fm
 *
 *     $Id: lang_cash.php,v 1.0.0.0 2003/10/08 00:55:17 Xore Exp $
 *
 ****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

//
// Admin menu
//
$lang['Cmcat_main'] = 'Главная';
$lang['Cmcat_addons'] = '„Дополнения';
$lang['Cmcat_other'] = 'Остальное';
$lang['Cmcat_help'] = 'Помощь';

$lang['Cash_Configuration'] = 'Конфигурация';
$lang['Cash_Currencies'] = 'Валюта';
$lang['Cash_Exchange'] = 'Обмен';
$lang['Cash_Events'] = 'События';
$lang['Cash_Forums'] = 'Форумы';
$lang['Cash_Groups'] = 'Группы';
$lang['Cash_Help'] = 'Помощь';
$lang['Cash_Logs'] = 'Логи';
$lang['Cash_Settings'] = 'Настройки';

$lang['Cmenu_cash_config'] = 'Глобальные настпройки, котоыре влияют на валюта';
$lang['Cmenu_cash_currencies'] = 'Добавить, удалить, переназначить валюту';
$lang['Cmenu_cash_settings'] = 'Специальные настройки для каждой из валют';
$lang['Cmenu_cash_events'] = 'Количество которое будет начислятся пользователю за события';
$lang['Cmenu_cash_reset'] = 'Сбросить в ноль';
$lang['Cmenu_cash_exchange'] = 'Включить/выключить обмен, установить курс';
$lang['Cmenu_cash_forums'] = 'Включить /выключить на каждом форуме';
$lang['Cmenu_cash_groups'] = 'Специальные настройки для каждой из групп пользователей';
$lang['Cmenu_cash_log'] = 'Посмотреть/удалить логи';
$lang['Cmenu_cash_help'] = 'Помощь';

// Config
$lang['Cash_config'] = 'Конфигурация';
$lang['Cash_config_explain'] = 'Форма, позволит выставить индивидуальные настройки';

$lang['Cash_admincp'] = 'Админский режим управления';
$lang['Cash_adminnavbar'] = 'Навигационная строка';
$lang['Sidebar'] = 'Навигационная колонка';
$lang['Menu'] = 'Меню';

$lang['Messages'] = 'Сообщения';
$lang['Spam'] = 'Спам нах!';
$lang['Click_return_cash_config'] = 'Нажмите %sсюда%s для того чтобы вернуться к конфигурированию';
$lang['Cash_config_updated'] = 'Конфигурация успешно обновлена';
$lang['Cash_disabled'] = 'Выключить';
$lang['Cash_message'] = 'Показать участников в Новой/Ответе, в окошке подтверждения ';
$lang['Cash_display_message'] = 'Сообщение которое показывать участником';
$lang['Cash_display_message_explain'] = 'Должен иметь хотя бы "%s" такой';
$lang['Cash_spam_disable_num'] = 'Количество постов для отключения участников (превентация спама)';
$lang['Cash_spam_disable_time'] = 'Временной период после которого пост должен быть расширен (часов)';
$lang['Cash_spam_disable_message'] = 'Анонс спама для нулевых пользователей';

// Currencies
$lang['Cash_currencies'] = 'Валюта';
$lang['Cash_currencies_explain'] = 'Приведённая форма позволяет управлять валютой';

$lang['Click_return_cash_currencies'] = 'Нажмите %sсдесь%s чтобы вернуться к валюте';
$lang['Cash_currencies_updated'] = 'Валюта успешно обновлена';
$lang['Cash_field'] = 'Поле';
$lang['Cash_currency'] = 'Валюта';
$lang['Name_of_currency'] = 'Название валюты';
$lang['Default'] = 'По умолчанию';
$lang['Cash_order'] = 'Получить';
$lang['Cash_set_all'] = 'Задать для всех пользователей';
$lang['Cash_delete'] = 'Удалить валюту';
$lang['Decimals'] = 'Еденицы измерения';

$lang['Cash_confirm_copy'] = 'Скопировать всю пользовательскую %s информацию в %s?<br />не может быть завершено';
$lang['Cash_confirm_delete'] = 'Удалить %s?<br />не может быть завершено';

$lang['Cash_copy_currency'] = 'Копировать текущую информацию';

$lang['Cash_new_currency'] = 'Создать новую валюту';
$lang['Cash_currency_dbfield'] = 'Поле в БД для валюты';
$lang['Cash_currency_decimals'] = 'Кол-во едениц для валюты';
$lang['Cash_currency_default'] = 'Значенние по умолчанию для валюты';

$lang['Bad_dbfield'] = 'Bad field name, must be in the form \'user_word\'<br /><br />%s<br /><br/>Examples:<br />user_points<br />user_cash<br />user_money<br />user_warnings<br /><br />';

// 0 currencies (most admin panels won't work... )
$lang['Insufficient_currencies'] = 'Для того чтобы использовать другие настройки, нужно создать валюту';

//
// Add-ons ?
//

// Events
$lang['Cash_events'] = 'События';
$lang['Cash_events_explain'] = 'Эта форма позволяет вам устранавиливать вознаграждения за ваши события.';

$lang['No_events'] = 'Нет событий';
$lang['Existing_events'] = 'Существующие события';
$lang['Add_an_event'] = 'Добавить событие';
$lang['Cash_events_updated'] = 'Добавление события завершено успешно';
$lang['Click_return_cash_events'] = 'Нажмите %sсюда%s для возвращения в события';

//Reset
$lang['Cash_reset_title'] = 'Глобальный сброс мода';
$lang['Cash_reset_explain'] = 'Приведённая форма разрешит вам активировать глобальный сброс\' валюты';

$lang['Cash_resetting'] = 'Сброс валюты';
$lang['User_of'] = 'Пользователь %s of %s';

$lang['Set_checked'] = 'Выставить провереные валюты';
$lang['Recount_checked'] = 'Пересчитать провереную валюту';

$lang['Cash_confirm_reset'] = 'Подтвердить сброс выделеных валют?<br />не может быть завершено';
$lang['Cash_confirm_recount'] = 'Подтвердить пересчёт выделеных валют?<br />не может быть завершено.<br /><br />Действие не рекомендовано для форумов с большим кол-вом пользователей и топиков.<br /><br />Перед тем как провести сброс рекомендовано выключить форумы. <br />Вы можете выключить форумы благодаря %sConfiguration%s';

$lang['Update_successful'] = 'Успешно обновлено';
$lang['Click_return_cash_reset'] = 'Нажмите %sсюда%s чтобы вернуться к сбросу валют';
$lang['User_updated'] = '%s Обновлено<br />';

//
// Others
//

// Exchange
$lang['Cash_exchange'] = 'Обмен валют';
$lang['Cash_exchange_explain'] = 'Эта форма позволит установить значение валюты, и разрешает обмен для пользователей.';

$lang['Exchange_insufficient_currencies'] = 'У вас не хватает нужно го количества для валют чтобы создать обменный курс<br />Минимум 2 необходимы';

// Forums
$lang['Forum_cm_settings'] = 'Cash Mod Настройки форума';
$lang['Forum_cm_settings_explain'] = 'На этой панели вы можете задать форумы на которых Cash Mod будет активирован';

// Groups
$lang['Cash_groups'] = 'Cash Mod Группы';
$lang['Cash_groups_explain'] = 'на этой панели вы можете задать специальные привилегии в ранге, группе пользователей, администраторов и модераторов';

$lang['Click_return_cash_groups'] = 'Нажмите %sсюда%s чтобы вернутьяс к группам валюты';
$lang['Cash_groups_updated'] = 'Группы успешно обновлены';

$lang['Set'] = 'Установить';
$lang['Up'] = 'Вверх';
$lang['Down'] = 'Вниз';

// Help
$lang['Cmh_support'] = 'Cash Mod Поддержка';
$lang['Cmh_troubleshooting'] = 'Проблемы';
$lang['Cmh_upgrading'] = 'Обновление';
$lang['Cmh_addons'] = 'Дополнения';
$lang['Cmh_demo_boards'] = 'Демо форумы';
$lang['Cmh_translations'] = 'Переводы';
$lang['Cmh_features'] = 'Возможности';

$lang['Cmhe_support'] = 'Общая информация';
$lang['Cmhe_troubleshooting'] = 'Если у вас проблемы с модом посмотрите сюда, может быть быть есть багфикс';
$lang['Cmhe_upgrading'] = 'У вас сейчас версия %s, обновления до последней версии буду опубликованы сдесь';
$lang['Cmhe_addons'] = 'Список дополнений которые могу расширить возможности мода';
$lang['Cmhe_demo_boards'] = 'Список некоторых форумов которые используют Cash Mod';
$lang['Cmhe_translations'] = 'Список преводов для Cash Mod';
$lang['Cmhe_features'] = 'Список возможностей Cash Mod\'s,и разрабатываемые версии';

// Logs
$lang['Logs'] = 'Логи Cash Mod';
$lang['Logs_explain'] = 'На этой панели, вы можете посмотреть логованые Cash Mod события';

// Settings
$lang['Cash_settings'] = 'Настройки Cash Mod';
$lang['Cash_settings_explain'] = 'Форма позволит изменить все валютные настройки.';


$lang['Display'] = 'Отображение';
$lang['Implementation'] = 'Начисления';
$lang['Allowances'] = 'Allowances';
$lang['Allowances_explain'] = 'Allowances requires the Cash Mod Allowances plug-in';
$lang['Click_return_cash_settings'] = 'Нажмите %sсюда%s чтобы вернуться к настройкам';
$lang['Cash_settings_updated'] = 'Настройки успешно обновлены';

$lang['Cash_enabled'] = 'Включить валюту';
$lang['Cash_custom_currency'] = 'Специальная валюта для Cash Mod';
$lang['Cash_image'] = 'Показывать валюту как на картинке';
$lang['Cash_imageurl'] = 'Картинка (Путь к phpBB2 главной директории):';
$lang['Cash_imageurl_explain'] = 'Используйте для того чтобы изображение было ассоциировано с валютой';
$lang['Prefix'] = 'Префикс';
$lang['Postfix'] = 'Постфикс';
$lang['Cash_currency_style'] = 'Стиль валюты для Cash Mod';
$lang['Cash_currency_style_explain'] = 'Валютный символ как ' . $lang['Prefix'] . ' или ' . $lang['Postfix'];
$lang['Cash_display_usercp'] = 'Показать начисленые очки в Пользвательской контрольной панели';
$lang['Cash_display_userpost'] = 'Показать начисленые очки, в профиле поста';
$lang['Cash_display_memberlist'] = 'Показать начисленые очки в списке пользователей';

$lang['Cash_amount_per_post'] = 'Количество валюты начисляемой за новый топик';
$lang['Cash_amount_post_bonus'] = 'Количество бонусных очков начисляемых автору за ответ в его топик';
$lang['Cash_amount_per_reply'] = 'Количество очков начисляемых за ответ';
$lang['Cash_amount_per_character'] = 'Amount of cash earned per character';
$lang['Cash_maxearn'] = 'Maximum amount of cash earned for posting';
$lang['Cash_amount_per_pm'] = 'Кличество очков начисляемых за личное сообщение';
$lang['Cash_include_quotes'] = 'Обсчитывать цитирование когда обчки начисляются пользователю';
$lang['Cash_exchangeable'] = 'Резрешить обмен валют';
$lang['Cash_allow_donate'] = 'Разрешить пожертвования другим пользователям';
$lang['Cash_allow_mod_edit'] = 'Разрешить администратору редактировать пользовательские деньги';
$lang['Cash_allow_negative'] = 'Разрешить отрицательный остаток';

$lang['Cash_allowance_enabled'] = 'Enable allowances';
$lang['Cash_allowance_amount'] = 'Amount of cash earned as allowances';
$lang['Cash_allownace_frequency'] = 'How often allowances are given';
$lang['Cash_allownace_frequencies'][CASH_ALLOW_DAY] = 'День';
$lang['Cash_allownace_frequencies'][CASH_ALLOW_WEEK] = 'Неделя';
$lang['Cash_allownace_frequencies'][CASH_ALLOW_MONTH] = 'Месяц';
$lang['Cash_allownace_frequencies'][CASH_ALLOW_YEAR] = 'Год';
$lang['Cash_allowance_next'] = 'Time until next allowance';

// Groups
$lang['Cash_status_type'][CASH_GROUPS_DEFAULT] = 'По умолчанию';
$lang['Cash_status_type'][CASH_GROUPS_CUSTOM] = 'Индивидуальные';
$lang['Cash_status_type'][CASH_GROUPS_OFF] = 'Выключено';
$lang['Cash_status'] = 'Статус';

// Cash Mod Log Text
// Note: there isn't really a whole lot i can do about it, if languages use a
// grammar that requires these arguments (%s) to be in a different order, it's stuck in
// this order. The up side is that this is about 10x more comprehensive than the
// last way i did it.
//

/* argument order: [donater id][donater name][currency list][receiver id][receiver name]

eg.
Joe donated 14 gold, $10, 3 points to Peter
*/
$lang['Cash_clause'][CASH_LOG_DONATE] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> Перечислено <b>%s</b> <a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a>';

/* argument order: [admin/mod id][admin/mod name][editee id][editee name][Added list][removed list][Set list]

eg.
Joe modified Peter's Cash:
Added 14 gold
Removed $10
Set 3 points
*/
$lang['Cash_clause'][CASH_LOG_ADMIN_MODEDIT] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new">%s</a> edited <a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a>\'s Валюта:<br />Добавлено <b>%s</b><br />Удалено <b>%s</b><br />Установить <b>%s</b>';

/* argument order: [admin/mod id][admin/mod name][currency name]

eg.
Joe created points 
*/
$lang['Cash_clause'][CASH_LOG_ADMIN_CREATE_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> создано <b>%s</b>';

/* argument order: [admin/mod id][admin/mod name][currency name]

eg.
Joe deleted $ 
*/
$lang['Cash_clause'][CASH_LOG_ADMIN_DELETE_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> удалено <b>%s</b>';

/* argument order: [admin/mod id][admin/mod name][old currency name][new currency name]

eg.
Joe renamed silver to gold
*/
$lang['Cash_clause'][CASH_LOG_ADMIN_RENAME_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> renamed <b>%s</b> to <b>%s</b>';

/* argument order: [admin/mod id][admin/mod name][copied currency name][copied over currency name]

eg.
Joe copied users' gold to points
*/
$lang['Cash_clause'][CASH_LOG_ADMIN_COPY_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> copied users\' <b>%s</b> to <b>%s</b>';

$lang['Log'] = 'Лог';
$lang['Action'] = 'Действие';
$lang['Type'] = 'Тип';
$lang['Cash_all'] = 'Все';
$lang['Cash_admin'] = 'Админ';
$lang['Cash_user'] = 'Пользователь';
$lang['Delete_all_logs'] = 'Удалить все логи';
$lang['Delete_admin_logs'] = 'Удалить админские логи';
$lang['Delete_user_logs'] = 'Удалить пользовательские логи';
$lang['All'] = 'Все';
$lang['Day'] = 'День';
$lang['Week'] = 'Неделя';
$lang['Month'] = 'Месяц';
$lang['Year'] = 'Год';
$lang['Page'] = 'Страница';
$lang['Per_page'] = 'на страницу';

//
// Now for some regular stuff...
//

//
// User CP
//
$lang['Donate'] = 'Перечислить опыт';
$lang['Mod_usercash'] = 'Модифицировать %s нал';
$lang['Exchange'] = 'Обменять';

//
// Exchange
//
$lang['Convert'] = 'Конвертировать';
$lang['Select_one'] = 'Выберите одно';
$lang['Exchange_lack_of_currencies'] = 'There aren\'t enough Currencies for you to be able to exchange<br />To enable this feature, your admin needs to create at least 2 currencies';
$lang['You_have'] = 'У вас';
$lang['One_worth'] = 'One %s is worth:';
$lang['Cannot_exchange'] = 'Вы не можете обменять %s, прямо сейчас';

//
// Donate
//
$lang['Amount'] = 'Перечислить';
$lang['Donate_to'] = 'Подарить %s';
$lang['Donation_recieved'] = '%s Вам помог';
$lang['Has_donated'] = '%s перечислил вам [b]%s[/b] . \n\n%s и написал:\n';

//
// Mod Edit
//
$lang['Add'] = 'Добавить';
$lang['Remove'] = 'Удалить';
$lang['Omit'] = 'Omit';
$lang['Amount'] = 'Перечислить';
$lang['Donate_to'] = 'Перечислить %s';
$lang['Has_moderated'] = '%s отмодерировал ваше %s';
$lang['Has_added'] = '[*]Добавлено: [b]%s[/b]\n';
$lang['Has_removed'] = '[*]Удалено: [b]%s[/b]\n';
$lang['Has_set'] = '[*]Установлено в : [b]%s[/b]\n';

// That's all folks!

?>
