
<h1>{DENY_TEXT_AND_BBCODE_TITLE}</h1>

<P>{DENY_TEXT_AND_BBCODE_TEXT}</p>

<!-- BEGIN output -->
<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
        <tr>
                <th class="thHead" colspan="2" valign="middle">{output.INFORMATION_TITLE}</th>
        </tr>
        <tr>
                <td class="row1" align="center"><span class="genmed">{output.MESSAGE}</span></td>
        </tr>
</table><br />
<!-- END output -->

<form method="post" action="{DENY_TEXT_BBCODE_ACTION}">
<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
        <tr>
                <th class="thHead" colspan="2" valign="middle">{SETTINGS_TITLE}</th>
        </tr>
        <tr>
                <td class="row1">{STATUS_TEXT}</td>
                <td class="row2"><input type="radio" name="status" value="1" {STATUS_ENABLED} /> {ENABLED_TEXT} &nbsp;&nbsp;<input type="radio" name="status" value="0" {STATUS_DISABLED} /> {DISABLED_TEXT}</td>
        </tr>
        <tr>
                <td class="row1">{BBCODE_TEXT}<br /><span class="gensmall">{BBCODE_EXPLAIN}</span></td>
                <td class="row2"><input type="radio" name="bbcode" value="1" {BBCODE_ENABLED} /> {ENABLED_TEXT} &nbsp;&nbsp;<input type="radio" name="bbcode" value="0" {BBCODE_DISABLED} /> {DISABLED_TEXT}</td>
        </tr>
        </tr>
                <td class="row1">{POST_RESTRICTION_TEXT}<br /><span class="gensmall">{POST_RESTRICTION_EXPLAIN}</span></td>
                <td class="row2"><input class="post" type="text" maxlength="4" size="4" name="postrestrict" value="{POST_RESTRICTION}" /></td>
        </tr>
        <tr>
                <td colspan="2" align="center" class="catBottom"><input type="submit" name="update" value="{UPDATE}" class="mainoption" /> &nbsp;<input type="reset" name="reset" value="{RESET}" class="liteoption" /></td>
        </tr>
</table></form>

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
        <tr>
                <th class="thCornerL">{L_TEXT}</th>
                <th colspan="2" class="thCornerR">{L_ACTION}</th>
        </tr>
        <!-- BEGIN text -->
        <tr>
                <td class="{text.ROW_CLASS}" align="center">{text.TEXT}</td>
                <td class="{text.ROW_CLASS}"><a href="{text.U_TEXT_DELETE}">{L_DELETE}</a></td>
        </tr>
        <!-- END text -->
</table>
<br />

<form method="post" action="{DENY_TEXT_BBCODE_ACTION}">
<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
        <tr>
                <th class="thHead" colspan="2" valign="middle">{TEXT_TITLE}</th>
        </tr>
        <tr>
                <td class="row1"><input class="post" type="text" size="14" name="newtext" /></td>
        </tr>
        <tr>
                <td colspan="2" align="center" class="catBottom"><input type="submit" name="submit" value="{SUBMIT}" class="mainoption" /></td>
        </tr>
</table></form>
