<h1>{L_RSS_CONFIG}</h1>

<p>{L_RSS_CONFIG_EXPLAIN}</p>

<form action="{S_CONFIG_ACTION}" method="post"><table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
        <tr>
          <th class="thHead" colspan="2">{L_RSS_CONFIG}</th>
        </tr>
        <tr>
                <td class="row1">{L_RSS_IMAGE}<br /><span class="gensmall">{L_RSS_IMAGE_EXP}</span></td>
                <td class="row2"><input class="post" type="text" maxlength="255" size="40" name="rss_image" value="{RSS_IMAGE}" /></td>
        </tr>
        <tr>
                <td class="row1">{L_RSS_MAX_TOPICS}</td>
                <td class="row2"><input class="post" type="text" maxlength="5" size="5" name="rss_max_topics" value="{RSS_MAX_TOPICS}" /></td>
        </tr>
        <tr>
                <td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
                </td>
        </tr>
</table>
</form>
