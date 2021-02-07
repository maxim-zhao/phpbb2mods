<?php

/***************************************************************************
 *                            lang_cash.php [Portuguese Brazil]
 *                              -------------------
 *     begin                : Sat Jul 20 2003
 *     copyright            : (C) 2003 Auror
 *     email                : arturmonteiro@gmail.com
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
$lang['Cmcat_main'] = 'Principal';
$lang['Cmcat_addons'] = 'Add-ons';
$lang['Cmcat_other'] = 'Outros';
$lang['Cmcat_help'] = 'Ajuda';

$lang['Cash_Configuration'] = 'Configura&ccedil;&atilde;o&nbsp;de&nbsp;Cash&nbsp;MOD';
$lang['Cash_Currencies'] = 'Moedas&nbsp;de&nbsp;Cash&nbsp;MOD';
$lang['Cash_Exchange'] = 'C&acirc;mbio&nbsp;de&nbsp;Cash&nbsp;MOD';
$lang['Cash_Events'] = 'Eventos&nbsp;de&nbsp;Cash&nbsp;MOD';
$lang['Cash_Forums'] = 'F&oacute;runs&nbsp;de&nbsp;Cash&nbsp;MOD';
$lang['Cash_Groups'] = 'Grupos&nbsp;de&nbsp;Cash&nbsp;MOD';
$lang['Cash_Help'] = 'Ajuda&nbsp;de&nbsp;Cash&nbsp;MOD';
$lang['Cash_Logs'] = 'Registros&nbsp;de&nbsp;Cash&nbsp;MOD';
$lang['Cash_Settings'] = 'Configura&ccedil;&atilde;o&nbsp;de&nbsp;Cash&nbsp;MOD';

$lang['Cmenu_cash_config'] = 'Configurações Gerais do Cash MOD que afetam todas as Moedas';
$lang['Cmenu_cash_currencies'] = 'Adicionar, Remover ou Reordenanar Moedas';
$lang['Cmenu_cash_settings'] = 'Configurações específicas para cada Moeda';
$lang['Cmenu_cash_events'] = 'Quantia de Dinheiro para distribuir a usuários em eventos';
$lang['Cmenu_cash_reset'] = 'Resetar ou Recontar quantias de Dinheiro';
$lang['Cmenu_cash_exchange'] = 'Ativar/Desativar câmbio de Moedas, taxa de câmbio';
$lang['Cmenu_cash_forums'] = 'Ativar ou Desativar Moedas para cada fórum';
$lang['Cmenu_cash_groups'] = 'Configurações Personalizadas para específicos grupos, ranks e níveis';
$lang['Cmenu_cash_log'] = 'Ver/Deletar ações de Logged Cash MOD';
$lang['Cmenu_cash_help'] = 'Ajuda do Cash MOD';

// Config
$lang['Cash_config'] = 'Configuração do Cash MOD';
$lang['Cash_config_explain'] = 'O formulário abaixo irá permitir-lhe selecionar as configurações do Cash MOD';

$lang['Cash_admincp'] = 'Modo de ACP do Cash MOD';
$lang['Cash_adminnavbar'] = 'Cash MOD Navbar';
$lang['Sidebar'] = 'Barra Lateral (Menu Esquerdo)';
$lang['Menu'] = 'Menu';

$lang['Messages'] = 'Mensagens';
$lang['Spam'] = 'Spam';
$lang['Click_return_cash_config'] = 'Clique %sAqui%s para retornar à configuração de Cash MOD';
$lang['Cash_config_updated'] = 'Configuração de Cash MOD Atualizada com Sucesso';
$lang['Cash_disabled'] = 'Desativar Cash MOD';
$lang['Cash_message'] = 'Exibir Ganhos na página de confirmação de Envio/Resposta';
$lang['Cash_display_message'] = 'Mensagem a exibir pelos ganhos de usuário';
$lang['Cash_display_message_explain'] = 'Deve haver exatemente um "%s" nisto';
$lang['Cash_spam_disable_num'] = 'Número de mensagens para desativar ganhos (prevenção anti-spam)';
$lang['Cash_spam_disable_time'] = 'Período de tempo em que estas mensagens devem exceder (horas)';
$lang['Cash_spam_disable_message'] = 'Aviso de Spam para ganhos nulos';

// Currencies
$lang['Cash_currencies'] = 'Moedas de Cash MOD';
$lang['Cash_currencies_explain'] = 'O formulário abaixo irá permitir-lhe gerenciar suas Moedas.';

$lang['Click_return_cash_currencies'] = 'Clique %sAqui%s para retornar às Moedas de Cash MOD';
$lang['Cash_currencies_updated'] = 'Moedas de Cash MOD Atualizadas com Sucesso';
$lang['Cash_field'] = 'Campo';
$lang['Cash_currency'] = 'Moeda';
$lang['Name_of_currency'] = 'Nome da Moeda';
$lang['Default'] = 'Padrão';
$lang['Cash_order'] = 'Ordem';
$lang['Cash_set_all'] = 'Selecionar para todos usuários';
$lang['Cash_delete'] = 'Deletar Moeda';
$lang['Decimals'] = 'Decimais';

$lang['Cash_confirm_copy'] = 'Copiar todos os dados de usuários para %s?<br />Isto não pode ser desfeito';
$lang['Cash_confirm_delete'] = 'Deletar %s?<br />Isto não pode ser desfeito';

$lang['Cash_copy_currency'] = 'Copiar Dados de Moeda';

$lang['Cash_new_currency'] = 'Criar nova Moeda';
$lang['Cash_currency_dbfield'] = 'Campo de Banco de Dados da Moeda';
$lang['Cash_currency_decimals'] = 'Número de decimais da Moeda';
$lang['Cash_currency_default'] = 'Valor padrão da Moeda';

$lang['Bad_dbfield'] = 'Nome de campo Incorreto, deve estar na tabela \'user_palavra\'<br /><br />%s<br /><br/>Exemplos:<br />user_points<br />user_cash<br />user_money<br />user_warnings<br /><br />';

// 0 currencies (most admin panels won't work... )
$lang['Insufficient_currencies'] = 'Você precisa criar Moedas antes de alterar configurações';

//
// Add-ons ?
//

// Events
$lang['Cash_events'] = 'Eventos do Cash MOD';
$lang['Cash_events_explain'] = 'O formulário abaixo irá permitir-lhe configurar as quantias de dinheiro a serem dadas em eventos personalizados.';

$lang['No_events'] = 'Nenhum evento listado';
$lang['Existing_events'] = 'Eventos Existentes';
$lang['Add_an_event'] = 'Adicionar um evento';
$lang['Cash_events_updated'] = 'Eventos de Cash MOD Atualizados com Sucesso';
$lang['Click_return_cash_events'] = 'Clique %sAqui%s para retornar aos Eventos de Dinheiro';

//Reset
$lang['Cash_reset_title'] = 'Resetar Cash MOD';
$lang['Cash_reset_explain'] = 'O formulário abaixo irá permitir-lhe ativar uma reconfiguração (reset) geral para as quantidades de dinheiro de todos os usuários';

$lang['Cash_resetting'] = 'Resetando Cash MOD';
$lang['User_of'] = 'Usuário %s de %s';

$lang['Set_checked'] = 'Configurar Moedas selecionadas';
$lang['Recount_checked'] = 'Recontar Moedas selecionadas';

$lang['Cash_confirm_reset'] = 'Confirmar reconfiguração de Moedas selecionadas?<br />Isto não pode ser desfeito';
$lang['Cash_confirm_recount'] = 'Confirmar recontagem de Moedas selecionadas?<br />Isto não pode ser defeito.<br /><br />Esta ação não é recomendada   para fóruns com muitos usuários e/ou tópicos.<br /><br />É recomendado que você desabilite seu fórum enquanto está ação é executada. <br />Você pode desabilitar seu fórum via %sConfiguração%s';

$lang['Update_successful'] = 'Atualizado  com Sucesso!';
$lang['Click_return_cash_reset'] = 'Clique %sAqui%s para retornar a Resetagem de Cash MOD';
$lang['User_updated'] = '%s atualizado<br />';

//
// Others
//

// Exchange
$lang['Cash_exchange'] = 'Câmbio de Cash MOD';
$lang['Cash_exchange_explain'] = 'O formulário abaixo irá permitir-lhe configurar valor relativos a suas Moedas e habilitar os usuários a converterem Moedas.';

$lang['Exchange_insufficient_currencies'] = 'Você não possui Moedas suficientes para criar taxas de câmbio<br />São necessárias pelo menos 2';

// Forums
$lang['Forum_cm_settings'] = 'Configuração de Fóruns deCash MOD';
$lang['Forum_cm_settings_explain'] = 'Deste painel você pode selecionar quais fóruns têm o Cash MOD habilitado';

// Groups
$lang['Cash_groups'] = 'Grupos de Cash MOD';
$lang['Cash_groups_explain'] = 'Deste painel você pode selecionar privilégios especial para ranks, grupos de usuários, administradores e moderadores';

$lang['Click_return_cash_groups'] = 'Clique %sAqui%s para retornar aos Grupos de Dinheiro';
$lang['Cash_groups_updated'] = 'Grupos de Dinheiro Atualizados com Sucesso!';

$lang['Set'] = 'Selecionar';
$lang['Up'] = 'Cima';
$lang['Down'] = 'Baixo';

// Help
$lang['Cmh_support'] = 'Suporte do Cash MOD';
$lang['Cmh_troubleshooting'] = 'Resolução de Problemas';
$lang['Cmh_upgrading'] = 'Atualização';
$lang['Cmh_addons'] = 'Add-Ons';
$lang['Cmh_demo_boards'] = 'Fóruns Demo';
$lang['Cmh_translations'] = 'Traduções';
$lang['Cmh_features'] = 'Funções';

$lang['Cmhe_support'] = 'Informações Gerais';
$lang['Cmhe_troubleshooting'] = 'Se você estiver tendo problemas com o Cash MOD, visite aqui para correções';
$lang['Cmhe_upgrading'] = 'Você possui atualmente a versão %s, atualizações serão postados aqui para a última versão';
$lang['Cmhe_addons'] = 'Uma lista de MODs que utilizam funções do Cash MOD';
$lang['Cmhe_demo_boards'] = 'Uma lista de alguns fóruns que usam o Cash MOD';
$lang['Cmhe_translations'] = 'Uma lista de traduções para o Cash MOD';
$lang['Cmhe_features'] = 'Uma lista de todas as características do Cash MOD, desenvolvimento e versões futuras';

// Logs
$lang['Logs'] = 'Registros do Cash MOD';
$lang['Logs_explain'] = 'Deste painel você pode ver eventos registrados do Cash MOD';

// Settings
$lang['Cash_settings'] = 'Configurações do Cash MOD';
$lang['Cash_settings_explain'] = 'O formulário abaixo irá permitir-lhe alterar todas as Configurações de Moedas.';


$lang['Display'] = 'Exibição';
$lang['Implementation'] = 'Implementação';
$lang['Allowances'] = 'Permissões';
$lang['Allowances_explain'] = 'Permissões necessitam do plugin Permissões para o Cash MOD';
$lang['Click_return_cash_settings'] = 'Clique %sAqui%s para retornar às Configurações do Cash MOD';
$lang['Cash_settings_updated'] = 'Configurações do Cash MOD Atualizadas com Sucesso';

$lang['Cash_enabled'] = 'Ativar Moeda';
$lang['Cash_custom_currency'] = 'Moeda do Cash MOD';
$lang['Cash_image'] = 'Exibir a Moeda com uma imagem';
$lang['Cash_imageurl'] = 'Imagem (Relativa ao caminho da pasta base do phpBB2):';
$lang['Cash_imageurl_explain'] = 'Use isto para definir uma pequena imagem associada à moeda';
$lang['Prefix'] = 'Prefixo';
$lang['Postfix'] = 'Sufixo';
$lang['Cash_currency_style'] = 'Estilo da Moeda para Cash MOD';
$lang['Cash_currency_style_explain'] = 'Simbolo da moeda como ' . $lang['Prefix'] . ' ou ' . $lang['Postfix'];
$lang['Cash_display_usercp'] = 'Exibir ganhos no Painel de Usuário';
$lang['Cash_display_userpost'] = 'Exibir ganhos no Perfil';
$lang['Cash_display_memberlist'] = 'Exibir ganhos na Lista de Membros';

$lang['Cash_amount_per_post'] = 'Ganho por novo tópico';
$lang['Cash_amount_post_bonus'] = 'Ganho bônus por resposta ao autor do tópico';
$lang['Cash_amount_per_reply'] = 'Ganho por resposta';
$lang['Cash_amount_per_character'] = 'Ganho por caractere';
$lang['Cash_maxearn'] = 'Máximo ganho por mensagem';
$lang['Cash_amount_per_pm'] = 'Máximo ganho por Mensagens Particulares';
$lang['Cash_include_quotes'] = 'Incluir citações quando calculando ganho por caracter';
$lang['Cash_exchangeable'] = 'Permitir que usuários troquem esta moeda';
$lang['Cash_allow_donate'] = 'Permitir que usuários doem seu dinheiro para outros usuários';
$lang['Cash_allow_mod_edit'] = 'Permitir que moderadores editem dinheiro de usuários';
$lang['Cash_allow_negative'] = 'Permitir que usuários possuam quantias negativas de dinheiro';

$lang['Cash_allowance_enabled'] = 'Ativar Permissões';
$lang['Cash_allowance_amount'] = 'Ganho como Permissões';
$lang['Cash_allownace_frequency'] = 'Período em que as Permissões são dadas';
$lang['Cash_allownace_frequencies'][CASH_ALLOW_DAY] = 'Dia';
$lang['Cash_allownace_frequencies'][CASH_ALLOW_WEEK] = 'Semana';
$lang['Cash_allownace_frequencies'][CASH_ALLOW_MONTH] = 'Mês';
$lang['Cash_allownace_frequencies'][CASH_ALLOW_YEAR] = 'Ano';
$lang['Cash_allowance_next'] = 'Tempo até próxima Permissão';

// Groups
$lang['Cash_status_type'][CASH_GROUPS_DEFAULT] = 'Padrão';
$lang['Cash_status_type'][CASH_GROUPS_CUSTOM] = 'Alterado';
$lang['Cash_status_type'][CASH_GROUPS_OFF] = 'Desligado';
$lang['Cash_status'] = 'Status';

// Cash MOD Log Text
// Note: there isn't really a whole lot i can do about it, if languages use a
// grammar that requires these arguments (%s) to be in a different order, it's stuck in
// this order. The up side is that this is about 10x more comprehensive than the
// last way i did it.
//

/* argument order: [donater id][donater name][currency list][receiver id][receiver name]

eg.
Joe donated 14 gold, $10, 3 points to Peter
*/
$lang['Cash_clause'][CASH_LOG_DONATE] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> doou <b>%s</b> a <a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a>';

/* argument order: [admin/mod id][admin/mod name][editee id][editee name][Added list][removed list][Set list]

eg.
Joe modified Peter's Cash:
Added 14 gold
Removed $10
Set 3 points
*/
$lang['Cash_clause'][CASH_LOG_ADMIN_MODEDIT] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new">%s</a> editou <a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new">a fortuna de<b>%s</b></a>:<br />Adicionou <b>%s</b><br />Removeu <b>%s</b><br />Alterou para <b>%s</b>';

/* argument order: [admin/mod id][admin/mod name][currency name]

eg.
Joe created points
*/
$lang['Cash_clause'][CASH_LOG_ADMIN_CREATE_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> criou <b>%s</b>';

/* argument order: [admin/mod id][admin/mod name][currency name]

eg.
Joe deleted $
*/
$lang['Cash_clause'][CASH_LOG_ADMIN_DELETE_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> deletou <b>%s</b>';

/* argument order: [admin/mod id][admin/mod name][old currency name][new currency name]

eg.
Joe renamed silver to gold
*/
$lang['Cash_clause'][CASH_LOG_ADMIN_RENAME_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> renomeou <b>%s</b> para <b>%s</b>';

/* argument order: [admin/mod id][admin/mod name][copied currency name][copied over currency name]

eg.
Joe copied users' gold to points
*/
$lang['Cash_clause'][CASH_LOG_ADMIN_COPY_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> copiou os <b>%s</b> dos usuários para <b>%s</b>';

$lang['Log'] = 'Registro';
$lang['Action'] = 'Ação';
$lang['Type'] = 'Tipo';
$lang['Cash_all'] = 'Todos';
$lang['Cash_admin'] = 'Admin';
$lang['Cash_user'] = 'Usuário';
$lang['Delete_all_logs'] = 'Deletar todos registros';
$lang['Delete_admin_logs'] = 'Deletar registros de Admin';
$lang['Delete_user_logs'] = 'Deletar registros de Usuários';
$lang['All'] = 'Todos';
$lang['Day'] = 'Dia';
$lang['Week'] = 'Semana';
$lang['Month'] = 'Mês';
$lang['Year'] = 'Ano';
$lang['Page'] = 'Página';
$lang['Per_page'] = 'por página';

//
// Now for some regular stuff...
//

//
// User CP
//
$lang['Donate'] = 'Doar';
$lang['Mod_usercash'] = 'Modificar Fortuna de %s';
$lang['Exchange'] = 'Converter';

//
// Exchange
//
$lang['Convert'] = 'Converter';
$lang['Select_one'] = 'Selecionar Um';
$lang['Exchange_lack_of_currencies'] = 'Não há Moedas suficientes para que você possa converter<br />Para ativar esta função, seu administrador precisa criar pelo menos 2 moedas';
$lang['You_have'] = 'Você possui';
$lang['One_worth'] = 'Um %s vale:';
$lang['Cannot_exchange'] = 'Você não pode converter %s, atualmente';

//
// Donate
//
$lang['Amount'] = 'Quantia';
$lang['Donate_to'] = 'Doar a %s';
$lang['Donation_recieved'] = 'Você recebeu uma doação de %s';
$lang['Has_donated'] = '%s doou [b]%s[/b] para você. \n\n%s escreveu:\n';

//
// Mod Edit
//
$lang['Add'] = 'Adicionar';
$lang['Remove'] = 'Remover';
$lang['Omit'] = 'Omitir';
$lang['Amount'] = 'Quantia';
$lang['Donate_to'] = 'Doar para %s';
$lang['Has_moderated'] = '%s moderou seus %s';
$lang['Has_added'] = '[*]Adicionou: [b]%s[/b]\n';
$lang['Has_removed'] = '[*]Removeu: [b]%s[/b]\n';
$lang['Has_set'] = '[*]Alterou para: [b]%s[/b]\n';

// That's all folks!

?>
