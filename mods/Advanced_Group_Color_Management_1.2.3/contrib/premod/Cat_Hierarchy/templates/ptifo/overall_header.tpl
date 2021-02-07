<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html dir="{S_CONTENT_DIRECTION}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}">
<meta http-equiv="Content-Style-Type" content="text/css">
{META}
{NAV_LINKS}
<title>{SITENAME} :: {PAGE_TITLE}</title>
<link rel="stylesheet" href="{S_ROOT}templates/ptifo/{T_HEAD_STYLESHEET}" type="text/css">
<!-- BEGIN switch_enable_pm_popup -->
<script language="Javascript" type="text/javascript">
<!--
	if ( {PRIVATE_MESSAGE_NEW_FLAG} )
	{
		window.open('{U_PRIVATEMSGS_POPUP}', '_phpbbprivmsg', 'HEIGHT=225,resizable=yes,WIDTH=400');;
	}
//-->
</script>
<!-- END switch_enable_pm_popup -->
</head>
<body>

<a name="top"></a>

<table width="100%" cellspacing="0" cellpadding="10" border="0" align="center"> 
<tr>
	<td class="bodyline"><table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr> 
		<td><a href="{U_INDEX}"><img src="{I_LOGO}" border="0" alt="{L_INDEX}" vspace="1" /></a>
		</td>
		<td align="center" width="100%" valign="middle"><span class="maintitle">{SITENAME}</span><span class="gen"><br />&nbsp;{SITE_DESCRIPTION}&nbsp;<br /></span>
			<table cellspacing="0" cellpadding="2" border="0">
			<tr>
				<td align="center" valign="top" nowrap="nowrap"><span class="mainmenu">
					<!-- BEGIN topic_calendar -->&nbsp;<a href="{U_CALENDAR}" class="mainmenu"><img src="{I_CALENDAR}" border="0" alt="{L_CALENDAR}" hspace="3" />{L_CALENDAR}</a>&nbsp; <!-- END topic_calendar -->&nbsp;<a href="{U_FAQ}" class="mainmenu"><img src="{I_FAQ}" border="0" alt="{L_FAQ}" hspace="3" />{L_FAQ}</a>&nbsp; &nbsp;<a href="{U_SEARCH}" class="mainmenu"><img src="{I_SEARCH}" border="0" alt="{L_SEARCH}" hspace="3" />{L_SEARCH}</a>&nbsp; &nbsp;<a href="{U_MEMBERLIST}" class="mainmenu"><img src="{I_MEMBERLIST}" border="0" alt="{L_MEMBERLIST}" hspace="3" />{L_MEMBERLIST}</a>&nbsp; &nbsp;<a href="{U_GROUP_CP}" class="mainmenu"><img src="{I_GROUP_CP}" border="0" alt="{L_USERGROUPS}" hspace="3" />{L_USERGROUPS}</a>&nbsp;
				</span></td>
			</tr>
			<tr>
				<td align="center" valign="top" nowrap="nowrap"><span class="mainmenu">
					<!-- BEGIN switch_user_logged_out -->&nbsp;<a href="{U_REGISTER}" class="mainmenu"><img src="{I_REGISTER}" border="0" alt="{L_REGISTER}" hspace="3" />{L_REGISTER}</a>&nbsp; <!-- BEGINELSE switch_user_logged_out -->&nbsp;<a href="{U_PROFILE}" class="mainmenu"><img src="{I_PROFILE}" border="0" alt="{L_PROFILE}" hspace="3" />{L_PROFILE}</a>&nbsp; &nbsp;<a href="{U_PREFERENCES}" class="mainmenu"><img src="{I_PREFERENCES}" border="0" alt="{L_PREFERENCES}" hspace="3" />{L_PREFERENCES}</a>&nbsp; &nbsp;<a href="{U_PRIVATEMSGS}" class="mainmenu"><img src="{PRIVMSG_IMG}" border="0" alt="{PRIVATE_MESSAGE_INFO}" hspace="3" />{PRIVATE_MESSAGE_INFO}</a>&nbsp; <!-- END switch_user_logged_out -->&nbsp;<a href="{U_LOGIN_LOGOUT}" class="mainmenu"><img src="<!-- BEGIN switch_user_logged_out -->{I_LOGIN}<!-- BEGINELSE switch_user_logged_out -->{I_LOGOUT}<!-- END switch_user_logged_out -->" width="12" height="13" border="0" alt="{L_LOGIN_LOGOUT}" hspace="3" />{L_LOGIN_LOGOUT}</a>&nbsp;
				</span></td>
			</tr>
			<!-- BEGIN user_is_admin -->
			<tr>
				<td align="center" valign="top" nowrap="nowrap"><span class="mainmenu">
					&nbsp;<a href="{U_ADMIN_LINK}" class="mainmenu"><img src="{I_ADMIN_LINK}" border="0" alt="{L_ADMIN_LINK}" hspace="3" />{L_ADMIN_LINK}</a>&nbsp;
				</span></td>
			</tr>
			<!-- END user_is_admin -->
			</table>
		</td>
	</tr>
	</table>

	<br class="nav" />
	<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center">
	<tr>
		<td align="left" valign="bottom"><span class="gensmall">
			<!-- BEGIN switch_user_logged_in -->
			{LAST_VISIT_DATE}<br />
			<!-- END switch_user_logged_in -->
			{CURRENT_TIME}<br />
			{S_TIMEZONE}
		</span></td>
		<td align="right" valign="bottom" class="gensmall">
			<a href="{U_SEARCH_NEW}" class="gensmall">{L_SEARCH_NEW}</a><br />
			<a href="{U_SEARCH_UNANSWERED}" class="gensmall">{L_SEARCH_UNANSWERED}</a><br />
			<!-- BEGIN switch_user_logged_in --><a href="{U_SEARCH_SELF}" class="gensmall">{L_SEARCH_SELF}</a><br /><!-- END switch_user_logged_in -->
			<!-- BEGIN full_month_ELSE --><!-- BEGIN java --><a href="#" onClick="dom_toggle.toggle('calrow','calrow_pic', '{DOWN_ARROW}', '{UP_ARROW}'); return false;" class="gensmall"><img src="{TOGGLE_ICON}" id="calrow_pic" hspace="2" border="0" align="middle" alt="" />{L_CALENDAR}</a><!-- END java --><!-- END full_month_ELSE -->
		</td>
	</tr>
	<!-- BEGIN full_month_ELSE -->
	<tr><td colspan="2">{CALENDAR_BOX}</td></tr>
	<!-- END full_month_ELSE -->
	</table>
