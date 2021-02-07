
<h1>{L_CONFIGURATION_TITLE}</h1>


<form action="{S_CONFIG_ACTION}" method="post"><table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
	  <th class="thHead" colspan="2">{L_CONFIGURATION_TITLE}</th>
	</tr>
	<tr>
		<td>
			{L_AD_AFTER_POST}: <input class="post" type="text" maxlength="3" size="5" name="ad_after_post" value="{AD_AFTER_POST}" /><br />
			{L_AD_EVERY_POST}: <input class="post" type="text" maxlength="3" size="5" name="ad_every_post" value="{AD_EVERY_POST}" /><br />
			{L_AD_STYLE}: <input type="radio" name="ad_style" value="0" {AD_NEW_STYLE} />{L_AD_NEW_STYLE}<input type="radio" name="ad_style" value="1" {AD_OLD_STYLE} />{L_AD_OLD_STYLE}<br />
			{L_AD_DISPLAY}: <input type="radio" name="ad_who" value="1" {AD_ALL} />{L_AD_ALL}<input type="radio" name="ad_who" value="0" {AD_REG} />{L_AD_REG}<input type="radio" name="ad_who" value="-1" {AD_GUEST} />{L_AD_GUEST}<br />
			{L_AD_EXCLUDE}:  <input class="post" type="text" maxlength="255" size="15" name="ad_no_groups" value="{AD_NO_GROUPS}" /><br />
			{L_AD_FORUMS}:  <input class="post" type="text" maxlength="255" size="15" name="ad_forums" value="{AD_FORUMS}" /><br />
			{L_AD_POST_THRESHOLD}:  <input class="post" type="text" maxlength="5" size="8" name="ad_post_threshold" value="{AD_POST_THRESHOLD}" /><br />
		</td>
	</tr>
	<tr>
		<td class="catBottom" align="center" colspan="2">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>

</table></form>

<br clear="all" />
