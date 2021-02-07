
<h1>{L_CONFIGURATION_TITLE}</h1>

<p>{L_CONFIGURATION_EXPLAIN}</p>

<form action="{S_CONFIG_ACTION}" method="post"><table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
	  <th class="thHead" colspan="2">{L_GENERAL_PERM}</th>
	</tr>
	<tr>
		<td class="row1">{L_AGUESTLOG}<br /><span class="gensmall"></span></td>
		<td class="row2"><input type="radio" name="allow_tnologguest" value="1" {AGUESTLOG_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="allow_tnologguest" value="0" {AGUESTLOG_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_AGUESTLOG_MOD}<br /><span class="gensmall"></span></td>
		<td class="row2"><input type="radio" name="allow_tnologguest_mod" value="1" {AGUESTLOG_MOD_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="allow_tnologguest_mod" value="0" {AGUESTLOG_MOD_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_AGUESTLOG_STARTER}<br /><span class="gensmall"></span></td>
		<td class="row2"><input type="radio" name="allow_tnologguest_starter" value="1" {AGUESTLOG_STARTER_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="allow_tnologguest_starter" value="0" {AGUESTLOG_STARTER_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_REDIRECTNOGUEST}<br /><span class="gensmall"></span></td>
		<td class="row2"><input type="radio" name="redirectnoguest" value="1" {REDIRECTNOGUEST_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="redirectnoguest" value="0" {REDIRECTNOGUEST_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_BOTNOTGUEST}<br /><span class="gensmall"></span></td>
		<td class="row2"><input type="radio" name="botnotguest" value="1" {BOTNOTGUEST_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="botnotguest" value="0" {BOTNOTGUEST_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_GLOBALNOGUEST}<br /><span class="gensmall"></span></td>
		<td class="row2"><input type="radio" name="globalnoguestt" value="1" {GLOBALNOGUEST_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="globalnoguestt" value="0" {GLOBALNOGUEST_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
	  <th class="thHead" colspan="2">{L_EDIT_LOCKS}</th>
	</tr>
	<tr>
		<td class="row1">{L_MOD_LOCK}<br /><span class="gensmall">{L_MOD_LOCK_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="allow_modlock" value="1" {MOD_LOCK_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="allow_modlock" value="0" {MOD_LOCK_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
	  <th class="thHead" colspan="2">{L_PASSWORDS}</th>
	</tr>
	<tr>
		<td class="row1">{L_TOPICPASS}<br />
		<td class="row2"><input type="radio" name="enable_topicpass" value="1" {TOPICPASS_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="enable_topicpass" value="0" {TOPICPASS_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_GUESTPASS}<br /><span class="gensmall">{L_GUESTPASS_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="allow_guestpass" value="1" {GUESTPASS_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="allow_guestpass" value="0" {GUESTPASS_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_GUESTLOGIN}<br /><span class="gensmall">{L_GUESTLOGIN_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="allow_guesttlogin" value="1" {GUESTLOGIN_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="allow_guesttlogin" value="0" {GUESTLOGIN_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_GUESTSEE}<br /><span class="gensmall">{L_GUESTSEE_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="guest_seepass" value="1" {GUESTSEE_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="guest_seepass" value="0" {GUESTSEE_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
	  <th class="thHead" colspan="2">{L_TOPIC_BANS}</th>
	</tr>
	<tr>
		<td class="row1">{L_TOPICBAN}<br />
		<td class="row2"><input type="radio" name="enable_topicban" value="1" {TOPICBAN_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="enable_topicban" value="0" {TOPICBAN_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_TOPICBAN_MOD}<br />
		<td class="row2"><input type="radio" name="allow_topicban_mod" value="1" {TOPICBAN_MOD_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="allow_topicban_mod" value="0" {TOPICBAN_MOD_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_TOPICBAN_STARTER}<br />
		<td class="row2"><input type="radio" name="allow_topicban_starter" value="1" {TOPICBAN_STARTER_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="allow_topicban_starter" value="0" {TOPICBAN_STARTER_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_BANSEE}<br />
		<td class="row2"><input type="radio" name="banned_seetopic" value="1" {BANSEE_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="banned_seetopic" value="0" {BANSEE_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_WHOSEE}<br />
		<td class="row2"><input type="radio" name="show_tban_who" value="1" {WHOSEE_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="show_tban_who" value="0" {WHOSEE_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_WHYSEE}<br />
		<td class="row2"><input type="radio" name="show_tban_why" value="1" {WHYSEE_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="show_tban_why" value="0" {WHYSEE_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table></form>

<br clear="all" />
