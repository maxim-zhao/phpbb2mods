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

<h1>{L_STATS}</h1>

<!-- BEGIN switch_date_specific_stats -->
<p align="center" class="maintitle">{L_DATESPAN_RESULT}</p>
<!-- END switch_date_specific_stats -->

<p><span class="genmed">{L_STATS_EXPLAIN}</span></p>

<table width="98%" cellspacing="0" cellpadding="2" border="0">
	<tr>
	    <td align="left"><span class="nav"><a href="{U_PHRASES}">{L_PHRASES}</a>&nbsp;&#8226;&nbsp;<a href="{U_WORDS}">{L_WORDS}</a>&nbsp;&#8226;&nbsp;<a href="{U_CONFIG}">{L_CONFIG}</a></span></td>
	</tr>
</table>

<table width="98%" cellpadding="2" cellspacing="1" border="0">
  <tr>
	<th width="25%" nowrap="nowrap" height="25" class="cat">{L_STATISTIC}</th>
	<th width="25%" height="25" class="cat">{L_VALUE}</th>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_FIRST_SEARCH}:</td>
	<td class="row3"><b>{FIRST_SEARCH}</b></td>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_LAST_SEARCH}:</td>
	<td class="row3"><b>{LAST_SEARCH}</b></td>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_DAYS_ACTIVE}:</td>
	<td class="row3"><b>{DAYS_ACTIVE}</b></td>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_SEARCHES_PER_DAY}:</td>
	<td class="row3"><b>{SEARCHES_PER_DAY}</b></td>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_TOTAL_SEARCHES}:</td>
	<td class="row3"><b>{TOTAL_SEARCHES}</b></td>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_SUCCESFUL_SEARCHES}:</td>
	<td class="row3"><b>{SUCCESFUL_SEARCHES}</b></td>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_FAILED_SEARCHES}:</td>
	<td class="row3"><b>{FAILED_SEARCHES}</b></td>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_SUCCES_RATE}:</td>
	<td class="row3"><b>{SUCCES_RATE}</b></td>
  </tr>
</table>

<p><a href="javascript:toggle('datespan');" class="nav">{L_DATE_SPECIFIC_STATS}</a></p>

<div id="datespan" style="display: none;">
<form method="post" action="{S_MODE_ACTION}">
<table width="98%" cellspacing="1" cellpadding="2" border="0">
	<tr>
	   	<th nowrap="nowrap" height="25" class="cat">{L_DEFINE_DATESPAN}</th>
	</tr>
	<tr>
	   	<td class="row3" nowrap="nowrap">{L_DATE_SPECIFIC_STATS_EXPLAIN}</td>
	</tr>
	<tr>
		<td class="row1">{L_BEGIN_DATESPAN}&nbsp;<input type="text" name="beginspan" />&nbsp;{L_END_DATESPAN}&nbsp;<input type="text" name="endspan" />
		<input type="submit" name="submit" value="{L_SUBMIT}" class="liteoption" /></td>
	</tr>
</table>
</form>
</div>

<form method="post" action="{S_MODE_ACTION}">
<table width="98%" cellspacing="0" cellpadding="2" border="0">
	<tr>
		<td align="left" nowrap="nowrap"><h1>{L_SPECIFIC_DATA}</h1></td>
		<td align="right" nowrap="nowrap"><span class="genmed">{L_NUM_RESULTS}:&nbsp;{S_NUM_RESULTS}&nbsp;&nbsp;
		<input type="submit" name="submit" value="{L_SUBMIT}" class="liteoption" />
		</span></td>
	</tr>
</table>

<!-- BEGIN switch_no_config -->
<table width="98%" cellspacing="0" cellpadding="2" border="0">
	<tr>
		<td align="left" nowrap="nowrap"><a class="nav" href="{U_CONFIG}">{L_NO_CONFIG}</a></td>
	</tr>
</table>
<!-- END switch_no_config -->

<!-- BEGIN switch_phrases -->
<table width="98%" cellspacing="1" cellpadding="2" border="0">
	<tr>
	    <th width="15%">{L_RESULT}</th>
	    <th width="15%">{L_PERCENTAGE}</th>
	    <th>{L_SEARCH_PHRASE}</th>
	</tr>
	<!-- BEGIN phraserow -->
	<tr>
		<td align="center" class="{switch_phrases.phraserow.ROW_CLASS}">{switch_phrases.phraserow.SEARCH_PHRASE_NUM}</td>
		<td align="center" class="{switch_phrases.phraserow.ROW_CLASS}">{switch_phrases.phraserow.PERCENTAGE}</td>
		<td class="{switch_phrases.phraserow.ROW_CLASS}">{switch_phrases.phraserow.SEARCH_PHRASE}</td>
	</tr>
	<!-- END phraserow -->
</table>
<br />
<!-- END switch_phrases -->

<!-- BEGIN switch_users -->
<table width="98%" cellspacing="1" cellpadding="2" border="0">
	<tr>
	    <th width="15%">{L_RESULT}</th>
	    <th width="15%">{L_PERCENTAGE}</th>
	    <th>{L_USER}</th>
	</tr>
	<!-- BEGIN searcherrow -->
	<tr>
		<td align="center" class="{switch_users.searcherrow.ROW_CLASS}">{switch_users.searcherrow.SEARCHER_NUM}</td>
		<td align="center" class="{switch_users.searcherrow.ROW_CLASS}">{switch_users.searcherrow.PERCENTAGE}</td>
		<td class="{switch_users.searcherrow.ROW_CLASS}">{switch_users.searcherrow.SEARCHER}</td>
	</tr>
	<!-- END searcherrow -->
</table>
<br />
<!-- END switch_users -->

<!-- BEGIN switch_referer -->
<table width="98%" cellspacing="1" cellpadding="2" border="0">
	<tr>
	    <th width="15%">{L_RESULT}</th>
	    <th width="15%">{L_PERCENTAGE}</th>
	    <th>{L_REFERER}</th>
	</tr>
	<!-- BEGIN refererrow -->
	<tr>
		<td align="center" class="{switch_referer.refererrow.ROW_CLASS}">{switch_referer.refererrow.REFERER_NUM}</td>
		<td align="center" class="{switch_referer.refererrow.ROW_CLASS}">{switch_referer.refererrow.PERCENTAGE}</td>
		<td class="{switch_referer.refererrow.ROW_CLASS}">{switch_referer.refererrow.REFERER}</td>
	</tr>
	<!-- END refererrow -->
</table>
<br />
<!-- END switch_referer -->

<!-- BEGIN switch_ips -->
<table width="98%" cellspacing="1" cellpadding="2" border="0">
	<tr>
	    <th width="15%">{L_RESULT}</th>
	    <th width="15%">{L_PERCENTAGE}</th>
	    <th>{L_IP}</th>
	</tr>
	<!-- BEGIN ipsrow -->
	<tr>
		<td align="center" class="{switch_ips.ipsrow.ROW_CLASS}">{switch_ips.ipsrow.IPS_NUM}</td>
		<td align="center" class="{switch_ips.ipsrow.ROW_CLASS}">{switch_ips.ipsrow.PERCENTAGE}</td>
		<td class="{switch_ips.ipsrow.ROW_CLASS}">{switch_ips.ipsrow.IPS}</td>
	</tr>
	<!-- END ipsrow -->
</table>
<br />
<!-- END switch_ips -->

<!-- BEGIN switch_forums -->
<table width="98%" cellspacing="1" cellpadding="2" border="0">
	<tr>
	    <th width="15%">{L_RESULT}</th>
	    <th width="15%">{L_PERCENTAGE}</th>
	    <th>{L_FORUM}</th>
	</tr>
	<!-- BEGIN forumrow -->
	<tr>
		<td align="center" class="{switch_forums.forumrow.ROW_CLASS}">{switch_forums.forumrow.FORUM_NUM}</td>
		<td align="center" class="{switch_forums.forumrow.ROW_CLASS}">{switch_forums.forumrow.PERCENTAGE}</td>
		<td class="{switch_forums.forumrow.ROW_CLASS}">{switch_forums.forumrow.FORUM}</td>
	</tr>
	<!-- END forumrow -->
</table>
<br />
<!-- END switch_forums -->

<!-- BEGIN switch_cats -->
<table width="98%" cellspacing="1" cellpadding="2" border="0">
	<tr>
	    <th width="15%">{L_RESULT}</th>
	    <th width="15%">{L_PERCENTAGE}</th>
	    <th>{L_CATEGORY}</th>
	</tr>
	<!-- BEGIN catrow -->
	<tr>
		<td align="center" class="{switch_cats.catrow.ROW_CLASS}">{switch_cats.catrow.CATEGORIES_NUM}</td>
		<td align="center" class="{switch_cats.catrow.ROW_CLASS}">{switch_cats.catrow.PERCENTAGE}</td>
		<td class="{switch_cats.catrow.ROW_CLASS}">{switch_cats.catrow.CATEGORIES}</td>
	</tr>
	<!-- END catrow -->
</table>
<br />
<!-- END switch_cats -->

<!-- BEGIN switch_authors -->
<table width="98%" cellspacing="1" cellpadding="2" border="0">
	<tr>
	    <th width="15%">{L_RESULT}</th>
	    <th width="15%">{L_PERCENTAGE}</th>
	    <th>{L_AUTHOR}</th>
	</tr>
	<!-- BEGIN authorrow -->
	<tr>
		<td align="center" class="{switch_authors.authorrow.ROW_CLASS}">{switch_authors.authorrow.AUTHORS_NUM}</td>
		<td align="center" class="{switch_authors.authorrow.ROW_CLASS}">{switch_authors.authorrow.PERCENTAGE}</td>
		<td class="{switch_authors.authorrow.ROW_CLASS}">{switch_authors.authorrow.AUTHORS}</td>
	</tr>
	<!-- END authorrow -->
</table>
<br />
<!-- END switch_authors -->

<!-- BEGIN switch_terms -->
<table width="98%" cellspacing="1" cellpadding="2" border="0">
	<tr>
	    <th width="15%">{L_RESULT}</th>
	    <th width="15%">{L_PERCENTAGE}</th>
	    <th>{L_SEARCH_TERMS}</th>
	</tr>
	<!-- BEGIN termsrow -->
	<tr>
		<td align="center" class="{switch_terms.termsrow.ROW_CLASS}">{switch_terms.termsrow.TERMS_NUM}</td>
		<td align="center" class="{switch_terms.termsrow.ROW_CLASS}">{switch_terms.termsrow.PERCENTAGE}</td>
		<td class="{switch_terms.termsrow.ROW_CLASS}">{switch_terms.termsrow.TERMS}</td>
	</tr>
	<!-- END termsrow -->
</table>
<br />
<!-- END switch_terms -->

<!-- BEGIN switch_fields -->
<table width="98%" cellspacing="1" cellpadding="2" border="0">
	<tr>
	    <th width="15%">{L_RESULT}</th>
	    <th width="15%">{L_PERCENTAGE}</th>
	    <th>{L_SEARCH_FIELDS}</th>
	</tr>
	<!-- BEGIN fieldsrow -->
	<tr>
		<td align="center" class="{switch_fields.fieldsrow.ROW_CLASS}">{switch_fields.fieldsrow.FIELDS_NUM}</td>
		<td align="center" class="{switch_fields.fieldsrow.ROW_CLASS}">{switch_fields.fieldsrow.PERCENTAGE}</td>
		<td class="{switch_fields.fieldsrow.ROW_CLASS}">{switch_fields.fieldsrow.FIELDS}</td>
	</tr>
	<!-- END fieldsrow -->
</table>
<br />
<!-- END switch_fields -->

<!-- BEGIN switch_sort_by -->
<table width="98%" cellspacing="1" cellpadding="2" border="0">
	<tr>
	    <th width="15%">{L_RESULT}</th>
	    <th width="15%">{L_PERCENTAGE}</th>
	    <th>{L_SORT_BY}</th>
	</tr>
	<!-- BEGIN sortbyrow -->
	<tr>
		<td align="center" class="{switch_sort_by.sortbyrow.ROW_CLASS}">{switch_sort_by.sortbyrow.SORTBY_NUM}</td>
		<td align="center" class="{switch_sort_by.sortbyrow.ROW_CLASS}">{switch_sort_by.sortbyrow.PERCENTAGE}</td>
		<td class="{switch_sort_by.sortbyrow.ROW_CLASS}">{switch_sort_by.sortbyrow.SORTBY}</td>
	</tr>
	<!-- END sortbyrow -->
</table>
<br />
<!-- END switch_sort_by -->

<!-- BEGIN switch_sort_dir -->
<table width="98%" cellspacing="1" cellpadding="2" border="0">
	<tr>
	    <th width="15%">{L_RESULT}</th>
	    <th width="15%">{L_PERCENTAGE}</th>
	    <th>{L_SORT_DIR}</th>
	</tr>
	<!-- BEGIN sortdirrow -->
	<tr>
		<td align="center" class="{switch_sort_dir.sortdirrow.ROW_CLASS}">{switch_sort_dir.sortdirrow.SORTDIR_NUM}</td>
		<td align="center" class="{switch_sort_dir.sortdirrow.ROW_CLASS}">{switch_sort_dir.sortdirrow.PERCENTAGE}</td>
		<td class="{switch_sort_dir.sortdirrow.ROW_CLASS}">{switch_sort_dir.sortdirrow.SORTDIR}</td>
	</tr>
	<!-- END sortdirrow -->
</table>
<!-- END switch_sort_dir -->
</form>
<br />
<div align="center"><p class="genmed">{L_MOD_VERSION}</p></div>
