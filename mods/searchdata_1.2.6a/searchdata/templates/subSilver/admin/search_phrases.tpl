
<h1>{L_SEARCH_PHRASES}</h1>

<p><span class="genmed">{L_SEARCH_PHRASES_EXPLAIN}</span></p>

<form method="post" action="{S_MODE_ACTION}">
<table width="98%" cellspacing="1" cellpadding="2" border="0">
	<tr>
	    <td align="left"><span class="nav"><a href="{U_STATS}">{L_STATS}</a>&nbsp;&#8226;&nbsp;<a href="{U_WORDS}">{L_WORDS}</a>&nbsp;&#8226;&nbsp;<a href="{U_CONFIG}">{L_CONFIG}</a></span></td>
		<td align="right" nowrap="nowrap"><span class="genmed">{L_SELECT_SORT_METHOD}:&nbsp;{S_MODE_SELECT}&nbsp;&nbsp;{L_ORDER}&nbsp;{S_ORDER_SELECT}&nbsp;&nbsp;
		<input type="submit" name="submit" value="{L_SUBMIT}" class="liteoption" />
		</span></td>
	</tr>
</table>

<!-- BEGIN switch_specific_data -->
<table width="98%" cellpadding="2" cellspacing="1" border="0">
  <tr>
	<th width="25%" nowrap="nowrap" height="25" class="cat">{L_QUERY}</th>
	<th width="25%" height="25" class="cat">{L_RECORDS}</th>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{MODE} = <b>{FIND}</b></td>
	<td class="row3"><b>{RESULT}</b></td>
  </tr>
</table>
<br />
<!-- END switch_specific_data -->

<table border="0" cellpadding="4" cellspacing="1" width="98%">
	<tr>
		<th align="center" width="15%" height="25" class="thCornerL" nowrap="nowrap">{L_USER}</th>
		<th align="center" class="thTop" nowrap="nowrap">{L_SEARCH_PHRASES}</th>
	</tr>
	<!-- BEGIN no_search_data -->
	<tr>
		<td class="row1" align="center" colspan="2"><span class="gen">{no_search_data.L_NO_SEARCH_PHRASES}</span></td>
	</tr>
	<!-- END no_search_data -->
	<!-- BEGIN searchrow -->
	<tr>
		<td width="150" align="left" valign="top" class="{searchrow.ROW_CLASS}"><span class="name"><b>{searchrow.POSTER}</b></span><br />{searchrow.USER_AVATAR}<br /><span class="gensmall">{searchrow.L_STATUS}:</span> {searchrow.STATUS}<br /><span class="gensmall">{searchrow.L_USER_IP}: {searchrow.USER_IP}</span><br /></td>
		<td class="{searchrow.ROW_CLASS}" width="100%" height="28" valign="top">
		<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<td><b>{searchrow.L_SEARCH_TIME}:</b> {searchrow.SEARCH_TIME}</td>
				<td align="right"><span class="gensmall">{searchrow.DELETE_SINGLE}</span></td>
			</tr>
			<tr>
				<td colspan="2"><b>{searchrow.L_SEARCH_FIELDS}:</b> {searchrow.SEARCH_FIELDS}<br /><b>{searchrow.L_SEARCH_TERMS}:</b> {searchrow.SEARCH_TERMS}<br /><b>{searchrow.L_SORT_BY}:</b> {searchrow.SORT_BY}<br /><b>{searchrow.L_SORT_DIR}:</b> {searchrow.SORT_DIR}</td>
			</tr>
			<tr>
				<td colspan="2"><b>{searchrow.L_FORUM}:</b> {searchrow.FORUM_NAME}&nbsp;&nbsp;<b>{searchrow.L_CATEGORY}:</b> {searchrow.CAT_NAME}<br />{searchrow.REFERER}<br />{searchrow.AUTHOR}</td>
			</tr>
			<tr>
				<td colspan="2"><hr /></td>
			</tr>
			<tr>
				<td colspan="2"><span class="maintitle"><b>{searchrow.SEARCH_PHRASE}</b></span></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td class="spaceRow" colspan="2" height="1"></td>
	</tr>
	<!-- END searchrow -->
	<tr>
		<td class="catBottom" align="center" colspan="2"><b>{L_RECORDS}: {RESULT}</b></td>
	</tr>
</table>
</form> 

<table width="98%" cellspacing="1" cellpadding="2" border="0">
	<tr>
		<td align="left" nowrap="nowrap"><span class="nav">{PAGE_NUMBER}</span></td>
		<td align="right" nowrap="nowrap"><span class="nav">{PAGINATION}</span></td>
	</tr>
</table>
<br />
<div align="center"><p class="genmed">{L_MOD_VERSION}</p></div>
