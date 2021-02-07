
<h1>{L_PROFILE_CONFIGURATION_TITLE}</h1>

<p>{L_PROFILE_CONFIGURATION_EXPLAIN}</p>

<form action="{S_CONFIG_ACTION}" method="post"><table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
	  <th class="thHead" colspan="2">{L_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row1">{L_USER_ICQ}</td>
		<td class="row2"><input type="radio" name="icq" value="1" {ICQ_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="icq" value="0" {ICQ_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_USER_AIM}</td>
		<td class="row2"><input type="radio" name="aim" value="1" {AIM_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="aim" value="0" {AIM_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_USER_YIM}</td>
		<td class="row2"><input type="radio" name="yim" value="1" {YIM_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="yim" value="0" {YIM_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_USER_MSN}</td>
		<td class="row2"><input type="radio" name="msnm" value="1" {MSN_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="msnm" value="0" {MSN_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_USER_WWW}</td>
		<td class="row2"><input type="radio" name="website" value="1" {WWW_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="website" value="0" {WWW_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_USER_FROM}</td>
		<td class="row2"><input type="radio" name="location" value="1" {FROM_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="location" value="0" {FROM_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_USER_OCC}</td>
		<td class="row2"><input type="radio" name="occupation" value="1" {OCC_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="occupation" value="0" {OCC_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_USER_INTEREST}</td>
		<td class="row2"><input type="radio" name="interests" value="1" {INTEREST_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="interests" value="0" {INTEREST_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_USER_SIG}</td>
		<td class="row2"><input type="radio" name="signature" value="1" {SIG_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="signature" value="0" {SIG_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table></form>

<center><span class="copyright">{L_CMPRF_MOD_VERSION}</span></center>

<br clear="all" />
