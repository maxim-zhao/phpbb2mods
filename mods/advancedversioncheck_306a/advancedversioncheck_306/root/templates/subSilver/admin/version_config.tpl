<h1>{L_VERSION_CONFIG}</h1>
<p>{L_VERSION_CONFIG_EXPLAIN}</p>

{ERROR_BOX}

<form action="{S_CONFIG_ACTION}" method="post" name="post"><table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
    <tr>
        <th class="thHead" colspan="2">{L_VERSION_CONFIG}</th>
    </tr>
	<tr>
        <td class="row1">{L_VERSION_CHECK_TIME}<br />
            <span class="gensmall">{L_VERSION_CHECK_TIME_EXPLAIN}</span>
        </td>
        <td class="row2">{CHECK_TIME_SELECT}</td>
    </tr>
    <tr>
        <td class="row1">{L_BACKGROUND_CHECK}<br />
            <span class="gensmall">{L_BACKGROUND_CHECK_EXPLAIN}</span>
        </td>
        <td class="row2"><input type="radio" name="background_check" value="1" {BACKGROUND_CHECK_YES} />&nbsp;{L_YES}&nbsp;&nbsp;<input type="radio" name="background_check" value="0" {BACKGROUND_CHECK_NO} />&nbsp;{L_NO}</td>
    </tr>
    <tr>
        <td class="row1">{L_ALLOW_INDEX}<br />
            <span class="gensmall">{L_ALLOW_INDEX_EXPLAIN}</span>
        </td>
        <td class="row2"><input type="radio" name="show_admin_index" value="1" {SHOW_ADMIN_INDEX_YES} />&nbsp;{L_YES}&nbsp;&nbsp;<input type="radio" name="show_admin_index" value="0" {SHOW_ADMIN_INDEX_NO} />&nbsp;{L_NO}</td>
    </tr>
    <tr>
        <td class="row1">{L_EMAIL_ON_UPDATE}<br />
            <span class="gensmall">{L_EMAIL_ON_UPDATE_EXPLAIN}</span>
        </td>
        <td class="row2"><input type="radio" name="update_email" value="{UPDATE_EMAIL_NO}" {UPDATE_EMAIL_NO_CHECKED} />&nbsp;{L_NO}&nbsp;&nbsp;<input type="radio" name="update_email" value="{UPDATE_EMAIL_ONE}" {UPDATE_EMAIL_ONE_CHECKED} />&nbsp;{L_ONE_ADDRESS}&nbsp;&nbsp;<input type="radio" name="update_email" value="{UPDATE_EMAIL_ALL}" {UPDATE_EMAIL_ALL_CHECKED} />&nbsp;{L_ALL_ADMINS}</td>
    </tr>
    <tr>
        <td class="row1">{L_SEND_EMAIL_ADDRESS}<br />
            <span class="gensmall">{L_SEND_EMAIL_ADDRESS_EXPLAIN}</span>
        </td>
        <td class="row2"><input type="text" name="email_address" value="{SEND_EMAIL_ADDRESS}" /></td>
    </tr>
    <tr>
        <td class="row1">{L_PM_ON_UPDATE}<br />
            <span class="gensmall">{L_PM_ON_UPDATE_EXPLAIN}</span>
        </td>
        <td class="row2"><input type="radio" name="update_pm" value="{UPDATE_PM_NO}" {UPDATE_PM_NO_CHECKED} />&nbsp;{L_NO}&nbsp;&nbsp;<input type="radio" name="update_pm" value="{UPDATE_PM_ONE}" {UPDATE_PM_ONE_CHECKED} />&nbsp;{L_ONE_USER}&nbsp; &nbsp;<input type="radio" name="update_pm" value="{UPDATE_PM_ALL}" {UPDATE_PM_ALL_CHECKED} /> &nbsp;{L_ALL_ADMINS}</td>
    </tr>
    <tr>
        <td class="row1">{L_SEND_PM_USER}<br />
            <span class="gensmall">{L_SEND_PM_USER_EXPLAIN}</span>
        </td>
        <td class="row2"><input class="post" type="text" name="pm_id" value="{SEND_PM_USER}" maxlength="50" size="20" /> <input type="submit" name="usersubmit" value="{L_FIND_USERNAME}" class="liteoption" onClick="window.open('{U_SEARCH_USER}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;" /></td>
    </tr>
    <tr>
        <td class="row1">{L_POST_ON_UPDATE}<br />
            <span class="gensmall">{L_POST_ON_UPDATE_EXPLAIN}</span>
        </td>
        <td class="row2"><input type="radio" name="update_post" value="1" {UPDATE_POST_YES} />&nbsp;{L_YES}&nbsp;&nbsp;<input type="radio" name="update_post" value="0" {UPDATE_POST_NO} />&nbsp;{L_NO}</td>
    </tr>
    <tr>
        <td class="row1">{L_UPDATE_POST_FORUM}<br />
            <span class="gensmall">{L_UPDATE_POST_FORUM_EXPLAIN}</span>
        </td>
        <td class="row2">{POST_FORUM_SELECT}</td>
    </tr>
    <tr>
        <td class="row1">{L_UPDATE_POST_CONTENTS}<br />
            <span class="gensmall">{L_UPDATE_POST_CONTENTS_EXPLAIN}</span>
        </td>
        <td class="row2"><textarea name="post_contents" rows="5" cols="30">{POST_CONTENTS}</textarea></td>
    </tr>
    <tr>
        <td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
    </tr>
</table></form>
