<h1>{L_CONTACT_TITLE} <span class="gen">v.{L_VERSION}</span></h1>

<p>{L_CONTACT_EXPLAIN}</p>

<form action="{S_CONFIG_ACTION}" method="post">
 <table width="100%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
	  <th class="thHead" colspan="2">{L_GENERAL_SETTINGS}</th>
	</tr>
	<tr>
		<td width="40%" class="row1"><b>{L_FORM_ENABLE}</b></td>
		<td width="60%" class="row2"><input type="radio" name="contact_form_enable" value="1" {S_FORM_ENABLE_YES} /> {L_YES}&nbsp; &nbsp;<input type="radio" name="contact_form_enable" value="0" {S_FORM_ENABLE_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td width="49%" class="row1"><b>{L_ADMIN_EMAIL}</b><br /><span class="gensmall">{L_ADMIN_EMAIL_EXPLAIN}</span></td>
		<td width="49%" class="row2"><input class="post" type="text" size="30" maxlength="100" name="contact_admin_email" value="{ADMIN_EMAIL}" /></td>
	</tr>
	<tr>
		<td class="row1"><b>{L_FLOOD_LIMIT}</b><br /><span class="gensmall">{L_FLOOD_LIMIT_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" size="8" maxlength="4" name="contact_flood_limit" value="{FLOOD_LIMIT}" /> {L_HOURS}</td>
	</tr>
	<tr>
		<td class="row1"><b>{L_CHAR_LIMIT}</b><br /><span class="gensmall">{L_CHAR_LIMIT_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" size="8" maxlength="4" name="contact_char_limit" value="{CHAR_LIMIT}" /></td>
	</tr>
	<tr>
		<td class="row1"><b>{L_HASH}</b><br /><span class="gensmall">{L_HASH_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="contact_hash" value="1" {S_HASH_YES} /> {L_MD5}&nbsp; &nbsp;<input type="radio" name="contact_hash" value="0" {S_HASH_NO} /> {L_NO_HASH}</td>
	</tr>
	<tr>
		<td class="row1"><b>{L_STORAGE}</b><br /><span class="gensmall">{L_STORAGE_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="contact_storage" value="1" {S_STORE_MSGS_YES} /> {L_YES}&nbsp; &nbsp;<input type="radio" name="contact_storage" value="0" {S_STORE_MSGS_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1"><b>{L_PRUNE}</b><br /><span class="gensmall">{L_PRUNE_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="contact_prune" value="1" {S_PRUNE_YES} /> {L_YES}&nbsp; &nbsp;<input type="radio" name="contact_prune" value="0" {S_PRUNE_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1"><b>{L_DELETE}</b><br /><span class="gensmall">{L_DELETE_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="contact_delete" value="1" {S_DELETE_FILES_YES} /> {L_YES}&nbsp; &nbsp;<input type="radio" name="contact_delete" value="0" {S_DELETE_FILES_NO} /> {L_NO}</td>
	</tr>
	<tr>
	  <th class="thHead" colspan="2">{L_REQ_SETTINGS}</th>
	</tr>
	<tr>
		<td width="40%" class="row1"><b>{L_REQUIRE_RNAME}</b></td>
		<td width="60%" class="row2"><input type="radio" name="contact_require_rname" value="1" {S_REQUIRE_RNAME_YES} /> {L_YES}&nbsp; &nbsp;<input type="radio" name="contact_require_rname" value="0" {S_REQUIRE_RNAME_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1"><b>{L_REQUIRE_EMAIL}</b></td>
		<td class="row2"><input type="radio" name="contact_require_email" value="1" {S_REQUIRE_EMAIL_YES} /> {L_YES}&nbsp; &nbsp;<input type="radio" name="contact_require_email" value="0" {S_REQUIRE_EMAIL_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1"><b>{L_REQUIRE_COMMENTS}</b></td>
		<td class="row2"><input type="radio" name="contact_require_comments" value="1" {S_REQUIRE_COMMENTS_YES} /> {L_YES}&nbsp; &nbsp;<input type="radio" name="contact_require_comments" value="0" {S_REQUIRE_COMMENTS_NO} /> {L_NO}</td>
	</tr>
	<tr>
	  <th class="thHead" colspan="2">{L_THANKYOU_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row1"><b>{L_THANKYOU_OPTION}</b><br /><span class="gensmall">{L_THANKYOU_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="contact_thankyou" value="{THANK_NONE}" {THANK_NONE_CHECKED} />{L_THANK_NONE}&nbsp; &nbsp;<input type="radio" name="contact_thankyou" value="{THANK_MEMBERS}" {THANK_MEMBERS_CHECKED} />{L_THANK_MEMBERS}&nbsp; &nbsp;<input type="radio" name="contact_thankyou" value="{THANK_ALL}" {THANK_ALL_CHECKED} />{L_THANK_ALL}</td>
	</tr>
<!-- BEGIN captcha_config -->
	<tr>
	  <th class="thHead" colspan="2">{L_CAPTCHA_TITLE}</th>
	</tr>
	<tr>
		<td class="row1"><b>{L_ACTIVATE}</b><br /><span class="gensmall">{L_ACTIVATE_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="contact_captcha" value="1" {S_CAPTCHA_ENABLE} /> {L_ENABLE}&nbsp; &nbsp;<input type="radio" name="contact_captcha" value="0" {S_CAPTCHA_DISABLE} /> {L_DISABLE}</td>
	</tr>
	<tr>
		<td class="row1"><b>{L_CAPTCHA_TYPE}</b><br /><span class="gensmall">{L_CAPTCHA_TYPE_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="contact_captcha_type" value="{TYPE_IMAGE}" {CAPTCHA_TYPE_IMAGE_CHECKED} />{L_IMAGEBG}&nbsp; &nbsp;<input type="radio" name="contact_captcha_type" value="{TYPE_COLOUR}" {CAPTCHA_TYPE_COLOUR_CHECKED} />{L_COLOURED}&nbsp; &nbsp;<input type="radio" name="contact_captcha_type" value="{TYPE_RANDOM}" {CAPTCHA_TYPE_RANDOM_CHECKED} />{L_RANDOM}</td>
	</tr>
<!-- END captcha_config -->
	<tr>
	  <th class="thHead" colspan="2">{L_ATTACHMENTS}</th>
	</tr>
	<tr>
		<td width="40%" class="row1"><b>{L_PERMIT_ATTACHMENTS}</b></td>
		<td width="60%" class="row2"><input type="radio" name="contact_permit_attachments" value="1" {S_PERMIT_ATTACHMENTS_YES} /> {L_YES}&nbsp; &nbsp;<input type="radio" name="contact_permit_attachments" value="0" {S_PERMIT_ATTACHMENTS_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1" valign="top"><b>{L_AUTH_PERMISSION}</b><br /><span class="gensmall">{L_AUTH_PERMISSION_EXPLAIN}</span></td>
		<td class="row2">
			<table width="100%" cellpadding="2" cellspacing="1" border="0" align="left">
			 <tr>
				<td width="20%">{L_ANON}:</td>
				<td width="80%"><input type="radio" name="contact_auth_guest" value="1" {S_PERM_GUEST_YES} /> {L_YES}&nbsp; &nbsp;<input type="radio" name="contact_auth_guest" value="0" {S_PERM_GUEST_NO} /> {L_NO}</td>
			 </tr>
			 <tr>
				<td>{L_USER}:</td>
				<td><input type="radio" name="contact_auth_user" value="1" {S_PERM_USER_YES} /> {L_YES}&nbsp; &nbsp;<input type="radio" name="contact_auth_user" value="0" {S_PERM_USER_NO} /> {L_NO}</td>
			 </tr>
			 <tr>
				<td>{L_MOD}:</td>
				<td><input type="radio" name="contact_auth_mod" value="1" {S_PERM_MOD_YES} /> {L_YES}&nbsp; &nbsp;<input type="radio" name="contact_auth_mod" value="0" {S_PERM_MOD_NO} /> {L_NO}</td>
			 </tr>
			 <tr>
				<td>{L_ADMIN}:</td>
				<td><input type="radio" name="contact_auth_admin" value="1" {S_PERM_ADMIN_YES} /> {L_YES}&nbsp; &nbsp;<input type="radio" name="contact_auth_admin" value="0" {S_PERM_ADMIN_NO} /> {L_NO}</td>
			 </tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="row1"><b>{L_MAX_FILE_SIZE}</b><br /><span class="gensmall">{L_MAX_FILE_SIZE_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" size="8" maxlength="10" name="contact_max_file_size" value="{MAX_FILE_SIZE}" /> {L_KB}</td>
	</tr>
	<tr>
		<td class="row1"><b>{L_FILE_ROOT}</b><br /><span class="gensmall">{L_FILE_ROOT_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" size="25" maxlength="50" name="contact_file_root" value="{FILE_ROOT}" /></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
	</tr>
 </table>
</form>

<p align="center"><span class="gensmall">{COPYRIGHT}</span></p>