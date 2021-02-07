<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
  <tr> 
    <td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
  </tr>
</table>
<form action="{S_VOTE_ACTION}" method="get">
  <table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
    <tr>
      <th class="thTop" nowrap="nowrap">{L_SELECT_POLL} {L_SORT_TOPIC}</th>
    </tr>
    <tr>
      <td class="row1" align="center">
        <select name="vote_id">
<!-- BEGIN topic_subj -->
          <option value="{topic_subj.KEY}">{topic_subj.VAL}</option>
<!-- END topic_subj -->
        </select>
        <input type="submit" value="{L_SUBMIT}" class="mainoption" />
      </td>
    </tr>
	<tr> 
      <td class="catBottom" height="28">&nbsp;</td>
    </tr>
  </table>
</form>
<table width="100%" border="0" cellpadding="2" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<form action="{S_VOTE_ACTION}" method="get">
  <table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
    <tr>
      <th class="thTop" nowrap="nowrap">{L_SELECT_POLL} {L_SORT_QUESTION}</th>
    </tr>
    <tr>
      <td class="row1" align="center">
        <select name="vote_id">
<!-- BEGIN poll_subj -->
          <option value="{poll_subj.KEY}">{poll_subj.VAL}</option>
<!-- END poll_subj -->
        </select>
        <input type="submit" value="{L_SUBMIT}" class="mainoption" />
      </td>
    </tr>
	<tr> 
      <td class="catBottom" height="28">&nbsp;</td>
    </tr>
  </table>
</form>
