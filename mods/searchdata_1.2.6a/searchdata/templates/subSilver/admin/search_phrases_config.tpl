<script language="javascript" type="text/javascript">
<!--
function toggle(id) {
	var obj = "";

	if(document.getElementById) {
		obj = document.getElementById(id);
	}
	else if(document.all) {
		obj = document.all[id];
	}
	else if(document.layers) {
		obj = document.layers[id];
	}
	else {
		return 1;
	}

	if (!obj) {
		return 1;
	}
	else if (obj.style)
	{
		obj.style.display = ( obj.style.display != "none" ) ? "none" : "";
	}
	else
	{
		obj.visibility = "show";
	}
}
//-->
</script>

<h1>{L_CONFIG}</h1>

<p><span class="genmed">{L_CONFIG_EXPLAIN}</span></p>

<form action="{S_CONFIG_ACTION}" method="post">
<table width="98%" cellspacing="1" cellpadding="2" border="0">
	<tr>
	    <td align="left"><span class="nav"><a href="{U_PHRASES}">{L_PHRASES}</a>&nbsp;&#8226;&nbsp;<a href="{U_STATS}">{L_STATS}</a>&nbsp;&#8226;&nbsp;<a href="{U_WORDS}">{L_WORDS}</a>
		<!-- BEGIN switch_rebuild_search -->
		&#8226;&nbsp;<a href="{U_REBUILD_SEARCH}" class="nav">{L_REBUILD_SEARCH}</a>
		<!-- END switch_rebuild_search -->
		</span></td>
	</tr>
</table>

<table width="98%" cellpadding="2" cellspacing="1" border="0">
  <tr>
	<th width="25%" nowrap="nowrap" height="25" class="cat">{L_OPTION}</th>
	<th width="25%" height="25" class="cat">{L_VALUE}</th>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_DISABLE_MOD}</td>
	<td class="row2"><input name="status" type="checkbox" {CHECKED_STATUS} /></td>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_DISABLE_MOD_ADMIN}</td>
	<td class="row2"><input name="admin" type="checkbox" {CHECKED_NOT_ADMIN} /></td>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_DISABLE_MOD_MODERATOR}</td>
	<td class="row2"><input name="mod" type="checkbox" {CHECKED_NOT_MOD} /></td>
  </tr>
  <tr>
	<td class="cat" nowrap="nowrap" colspan="2" align="center">&nbsp;</td>
  </tr>
</table>

<h1>{L_STATS_PAGE_SETTINGS}</h1>
<table width="98%" cellpadding="2" cellspacing="1" border="0">
  <tr>
	<th width="25%" nowrap="nowrap" height="25" class="cat">{L_OPTION}</th>
	<th width="25%" height="25" class="cat">{L_VALUE}</th>
  </tr>
  <tr>
	<td class="row3" nowrap="nowrap" colspan="2">{L_CHECKBOXES}</td>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_PHRASES}</td>
	<td class="row2"><input name="phrases" type="checkbox" {CHECKED_PHRASES} /></td>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_USER}</td>
	<td class="row2"><input name="users" type="checkbox" {CHECKED_USERS} /></td>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_REFERER}</td>
	<td class="row2"><input name="referer" type="checkbox" {CHECKED_REFERER} /></td>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_IP}</td>
	<td class="row2"><input name="ips" type="checkbox" {CHECKED_IPS} /></td>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_FORUM}</td>
	<td class="row2"><input name="forums" type="checkbox" {CHECKED_FORUM} /></td>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_CATS}</td>
	<td class="row2"><input name="cats" type="checkbox" {CHECKED_CATS} /></td>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_AUTHOR}</td>
	<td class="row2"><input name="authors" type="checkbox" {CHECKED_AUTHOR} /></td>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_TERMS}</td>
	<td class="row2"><input name="terms" type="checkbox" {CHECKED_TERMS} /></td>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_FIELDS}</td>
	<td class="row2"><input name="fields" type="checkbox" {CHECKED_FIELDS} /></td>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_SORT_BY}</td>
	<td class="row2"><input name="sort_by" type="checkbox" {CHECKED_SORT_BY} /></td>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_SORT_DIR}</td>
	<td class="row2"><input name="sort_dir" type="checkbox" {CHECKED_SORT_DIR} /></td>
  </tr>
  <tr>
	<td class="catBottom" nowrap="nowrap" colspan="2" align="center"><input name="submit" type="submit" class="liteoption" value="{L_SUBMIT}" /></td>
  </tr>
</table>
</form>

<!-- BEGIN switch_options -->
<p><a href="javascript:toggle('backup');" class="nav">{L_BACKUP}</a>&nbsp;&#8226;&nbsp;<a href="javascript:toggle('selective');" class="nav">{L_DELETE_SELECTIVE}</a>&nbsp;&#8226;&nbsp;<a href="javascript:toggle('purge');" class="nav">{L_PURGE_SEARCH_PHRASES}</a>&nbsp;&#8226;&nbsp;<a href="javascript:toggle('tidy');" class="nav">{L_TIDY}</a>&nbsp;&#8226;&nbsp;<a href="javascript:toggle('version');" class="nav">{L_VERSION_CHECK}</a>&nbsp;&#8226;&nbsp;<a href="javascript:toggle('stopwords');" class="nav">{L_STOPWORDS}</a>&nbsp;&#8226;&nbsp;<a href="javascript:toggle('synonyms');" class="nav">{L_SYNONYMS}</a>
</p>

<div id="backup" style="display: none;">
<table width="98%" cellpadding="2" cellspacing="1" border="0">
	<tr>
		<th nowrap="nowrap" height="25" class="cat" colspan="2">{L_BACKUP}</th>
	</tr>
	<tr>
		<td class="row3" colspan="2">{L_BACKUP_EXPLAIN}</td>
	</tr>
	<tr>
		<td class="row1" nowrap="nowrap" width="50%"><a href="{U_BACKUP_DATA}" class="nav">{L_BACKUP_DATA}</a></td>
		<td class="row2"><a href="{U_BACKUP_DATA_STRUCTURE}" class="nav">{L_BACKUP_DATA_STRUCTURE}</a></td>
	</tr> 
	<tr>
		<td class="catBottom" nowrap="nowrap" colspan="2" align="center">&nbsp;</td>
	</tr>
</table>
</div>

<div id="selective" style="display: none;">
<form action="{S_CONFIG_ACTION}" method="post">
<table width="98%" cellpadding="2" cellspacing="1" border="0">
	<tr>
		<th width="25%" nowrap="nowrap" height="25" class="cat">{L_DELETE_SELECTIVE}</th>
	</tr>
	<tr>
		<td class="row3" nowrap="nowrap">{L_DELETE_SELECTIVE_EXPLAIN}</td>
	</tr>
	<tr>
		<td class="row1" nowrap="nowrap">{L_VALUE}:&nbsp;{S_MODE_SELECT}</td>
	</tr>
	<tr>
		<td class="catBottom" nowrap="nowrap" align="center"><input type="submit" name="delete" class="liteoption" value="{L_DELETE}" /></td>
	</tr>
</table>
</form>
</div>

<div id="purge" style="display: none;">
<form method="post" action="{S_MODE_ACTION}">
<table width="98%" cellpadding="2" cellspacing="1" border="0">
	<tr>
		<th align="center" height="25" class="cat" nowrap="nowrap">{L_PURGE_SEARCH_PHRASES}</th>
	</tr>
	<tr>
		<td class="row1" height="25" align="center">{L_PURGE_SEARCH_PHRASES_WARN}</td>
	</tr>
	<tr>
		<td class="catBottom" align="center">
		<input type="submit" name="purge" class="liteoption" value="{L_PURGE_SEARCH_PHRASES}" />
		</td>
	</tr>
</table>
</form>
</div>

<div id="tidy" style="display: none;">
<form method="post" action="{S_MODE_ACTION}">
<table width="98%" cellpadding="2" cellspacing="1" border="0">
	<tr>
		<th align="center" colspan="2" height="25" class="cat" nowrap="nowrap">{L_TIDY}</th>
	</tr>
	<tr>
		<td class="row3" colspan="2">{L_TIDY_EXPLAIN}</td>
	</tr>
	<tr>
		<td class="row1" width="50%">{L_BOGUS_CHARS} {BOGUS_CHARS}</td>
		<td class="row2"><input type="checkbox" name="bogus" /></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">
		<input type="submit" name="tidy" class="liteoption" value="{L_TIDY}" />
		</td>
	</tr>
</table>
</form>
</div>

<div id="version" style="display: none;">
<form method="post" action="{S_MODE_ACTION}">
<table width="98%" cellpadding="2" cellspacing="1" border="0">
	<tr>
		<th align="center" height="25" class="cat" nowrap="nowrap">{L_VERSION_CHECK}</th>
	</tr>
	<tr>
		<td class="row1" height="25" align="center">{L_VERSION_CHECK_EXPLAIN}</td>
	</tr>
	<tr>
		<td class="catBottom" align="center"><input type="submit" name="version" class="liteoption" value="{L_CHECK_NOW}" /></td>
	</tr>
</table>
</form>
</div>

<div id="stopwords" style="display: none;">
<table width="98%" cellpadding="2" cellspacing="1" border="0">
	<tr>
		<th align="center" height="25" class="cat" nowrap="nowrap">{L_STOPWORDS}</th>
	</tr>
	<!-- BEGIN stopwords_row -->
	<tr>
		<td class="{switch_options.stopwords_row.ROW_CLASS}">{switch_options.stopwords_row.STOPWORD}</td>
	</tr>
	<!-- END stopwords_row -->
	<tr>
		<td class="catBottom" align="center"><span class="cattitle">{COUNT_STOPWORDS}</span></td>
	</tr>
</table>
</div>

<div id="synonyms" style="display: none;">
<table width="98%" cellpadding="2" cellspacing="1" border="0">
	<tr>
		<th align="center" height="25" class="cat" nowrap="nowrap" colspan="2">{L_SYNONYMS}</th>
	</tr>
	<!-- BEGIN synonyms_row -->
	<tr>
		<td class="{switch_options.synonyms_row.ROW_CLASS}">{switch_options.synonyms_row.ORIG}</td>
		<td class="{switch_options.synonyms_row.ROW_CLASS}">{switch_options.synonyms_row.SYNONYM}</td>
	</tr>
	<!-- END synonyms_row -->
	<tr>
		<td class="catBottom" align="center" colspan="2"><span class="cattitle">{COUNT_SYNONYMS}</span></td>
	</tr>
</table>
</div>
<!-- END switch_options -->

<br />
<div align="center"><p class="genmed">{L_MOD_VERSION}</p></div>