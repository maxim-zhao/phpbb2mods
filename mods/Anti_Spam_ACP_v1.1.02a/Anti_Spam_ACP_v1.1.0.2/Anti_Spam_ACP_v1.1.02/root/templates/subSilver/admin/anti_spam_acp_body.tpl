<h1>{L_ANTI_SPAM_ACP} <span class="genmed">{L_ANTI_SPAM_ACP_CREATED_BY}</span></h1>

<form action="{S_CONFIG_ACTION}" method="post">
{VERSION_INFO}
<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
	  <th class="thHead" colspan="2">{L_ANTI_SPAM_ACP_PAGE_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row1">{L_ICQ}: <br /></td>
		<td class="row2">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td><input type="radio" name="as_acp_icq" value="off" {ICQ_OFF} />{L_OFF}</td>
					<td><input type="radio" name="as_acp_icq" value="reg off" {ICQ_REG_OFF} />{L_REG_OFF}</td>
					<td><input type="radio" name="as_acp_icq" value="on" {ICQ_ON} />{L_ON}</td>
				</tr>
			</table>
			<br />
			<table  width="100%" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td><input type="radio" name="as_acp_icq" value="post count" {ICQ_POST_COUNT} />{L_POST_COUNT}</td>
					<td><input class="post" type="text" maxlength="4" size="5" name="as_acp_icq_post" value="{ICQ_POSTS}" /> {L_POSTS}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="row1">{L_AIM}: <br /></td>
		<td class="row2">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td><input type="radio" name="as_acp_aim" value="off" {AIM_OFF} />{L_OFF}</td>
					<td><input type="radio" name="as_acp_aim" value="reg off" {AIM_REG_OFF} />{L_REG_OFF}</td>
					<td><input type="radio" name="as_acp_aim" value="on" {AIM_ON} />{L_ON}</td>
				</tr>
			</table>
			<br />
			<table  width="100%" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td><input type="radio" name="as_acp_aim" value="post count" {AIM_POST_COUNT} />{L_POST_COUNT}</td>
					<td><input class="post" type="text" maxlength="4" size="5" name="as_acp_aim_post" value="{AIM_POSTS}" /> {L_POSTS}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="row1">{L_MSN}: <br /></td>
		<td class="row2">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td><input type="radio" name="as_acp_msn" value="off" {MSN_OFF} />{L_OFF}</td>
					<td><input type="radio" name="as_acp_msn" value="reg off" {MSN_REG_OFF} />{L_REG_OFF}</td>
					<td><input type="radio" name="as_acp_msn" value="on" {MSN_ON} />{L_ON}</td>
				</tr>
			</table>
			<br />
			<table  width="100%" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td><input type="radio" name="as_acp_msn" value="post count" {MSN_POST_COUNT} />{L_POST_COUNT}</td>
					<td><input class="post" type="text" maxlength="4" size="5" name="as_acp_msn_post" value="{MSN_POSTS}" /> {L_POSTS}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="row1">{L_YIM}: <br /></td>
		<td class="row2">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td><input type="radio" name="as_acp_yim" value="off" {YIM_OFF} />{L_OFF}</td>
					<td><input type="radio" name="as_acp_yim" value="reg off" {YIM_REG_OFF} />{L_REG_OFF}</td>
					<td><input type="radio" name="as_acp_yim" value="on" {YIM_ON} />{L_ON}</td>
				</tr>
			</table>
			<br />
			<table  width="100%" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td><input type="radio" name="as_acp_yim" value="post count" {YIM_POST_COUNT} />{L_POST_COUNT}</td>
					<td><input class="post" type="text" maxlength="4" size="5" name="as_acp_yim_post" value="{YIM_POSTS}" /> {L_POSTS}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="row1">{L_WEBSITE}: <br /></td>
		<td class="row2">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td><input type="radio" name="as_acp_web" value="off" {WEB_OFF} />{L_OFF}</td>
					<td><input type="radio" name="as_acp_web" value="reg off" {WEB_REG_OFF} />{L_REG_OFF}</td>
					<td><input type="radio" name="as_acp_web" value="on" {WEB_ON} />{L_ON}</td>
				</tr>
			</table>
			<br />
			<table  width="100%" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td><input type="radio" name="as_acp_web" value="post count" {WEB_POST_COUNT} />{L_POST_COUNT}</td>
					<td><input class="post" type="text" maxlength="4" size="5" name="as_acp_web_post" value="{WEB_POSTS}" /> {L_POSTS}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="row1">{L_LOCATION}: <br /></td>
		<td class="row2">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td><input type="radio" name="as_acp_loc" value="off" {LOC_OFF} />{L_OFF}</td>
					<td><input type="radio" name="as_acp_loc" value="reg off" {LOC_REG_OFF} />{L_REG_OFF}</td>
					<td><input type="radio" name="as_acp_loc" value="on" {LOC_ON} />{L_ON}</td>
				</tr>
			</table>
			<br />
			<table  width="100%" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td><input type="radio" name="as_acp_loc" value="post count" {LOC_POST_COUNT} />{L_POST_COUNT}</td>
					<td><input class="post" type="text" maxlength="4" size="5" name="as_acp_loc_post" value="{LOC_POSTS}" /> {L_POSTS}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="row1">{L_OCCUPATION}: <br /></td>
		<td class="row2">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td><input type="radio" name="as_acp_occ" value="off" {OCC_OFF} />{L_OFF}</td>
					<td><input type="radio" name="as_acp_occ" value="reg off" {OCC_REG_OFF} />{L_REG_OFF}</td>
					<td><input type="radio" name="as_acp_occ" value="on" {OCC_ON} />{L_ON}</td>
				</tr>
			</table>
			<br />
			<table  width="100%" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td><input type="radio" name="as_acp_occ" value="post count" {OCC_POST_COUNT} />{L_POST_COUNT}</td>
					<td><input class="post" type="text" maxlength="4" size="5" name="as_acp_occ_post" value="{OCC_POSTS}" /> {L_POSTS}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="row1">{L_INTERESTS}: <br /></td>
		<td class="row2">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td><input type="radio" name="as_acp_int" value="off" {INT_OFF} />{L_OFF}</td>
					<td><input type="radio" name="as_acp_int" value="reg off" {INT_REG_OFF} />{L_REG_OFF}</td>
					<td><input type="radio" name="as_acp_int" value="on" {INT_ON} />{L_ON}</td>
				</tr>
			</table>
			<br />
			<table  width="100%" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td><input type="radio" name="as_acp_int" value="post count" {INT_POST_COUNT} />{L_POST_COUNT}</td>
					<td><input class="post" type="text" maxlength="4" size="5" name="as_acp_int_post" value="{INT_POSTS}" /> {L_POSTS}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="row1">{L_SIGNATURE}: <br /></td>
		<td class="row2">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td><input type="radio" name="as_acp_sig" value="off" {SIG_OFF} />{L_OFF}</td>
					<td><input type="radio" name="as_acp_sig" value="reg off" {SIG_REG_OFF} />{L_REG_OFF}</td>
					<td><input type="radio" name="as_acp_sig" value="on" {SIG_ON} />{L_ON}</td>
				</tr>
			</table>
			<br />
			<table  width="100%" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td><input type="radio" name="as_acp_sig" value="post count" {SIG_POST_COUNT} />{L_POST_COUNT}</td>
					<td><input class="post" type="text" maxlength="4" size="5" name="as_acp_sig_post" value="{SIG_POSTS}" /> {L_POSTS}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="row1">{L_CHECK_VERSION}<br /><span class="gensmall">{L_CHECK_VERSION_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="as_acp_check_version" value="1" {CHECK_VERSION_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="as_acp_check_version" value="0" {CHECK_VERSION_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_EMAIL_ADDRESS}: <br /><span class="gensmall">{L_EMAIL_ADDRESS_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="255" size="25" name="as_acp_email_for_spam" value="{EMAIL}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_SHOW_MAIL}: <br /><span class="gensmall">{L_SHOW_MAIL_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="as_acp_show_email_on_die" value="1" {SHOW_MAIL_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="as_acp_show_email_on_die" value="0" {SHOW_MAIL_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_SEND_MAIL}: <br /><span class="gensmall">{L_SEND_MAIL_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="as_acp_notify_on_spam" value="1" {SEND_MAIL_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="as_acp_notify_on_spam" value="0" {SEND_MAIL_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_TEST_MAIL}: <br /><span class="gensmall">{L_TEST_MAIL_EXPLAIN}</span></td>
		<td class="row2"><input type="submit" name="test_mail" value="{L_TEST_MAIL}" class="mainoption" /></td>
	</tr>
	<tr>
		<td class="catBottom" align="center" colspan="2">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table>
</form>

<div align="center">{L_NUM_BOTS_CAUGHT}: {NUM_BOTS_CAUGHT}</div>

<br clear="all" />
