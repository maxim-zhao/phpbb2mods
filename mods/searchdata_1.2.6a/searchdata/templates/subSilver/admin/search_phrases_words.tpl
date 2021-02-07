
<h1>{L_WORDS}</h1>

<p><span class="genmed">{L_WORDS_EXPLAIN}</span></p>

<table width="98%" cellspacing="0" cellpadding="2" border="0">
	<tr>
	    <td align="left"><span class="nav"><a href="{U_PHRASES}">{L_PHRASES}</a>&nbsp;&#8226;&nbsp;<a href="{U_STATS}">{L_STATS}</a>&nbsp;&#8226;&nbsp;<a href="{U_CONFIG}">{L_CONFIG}</a></span></td>
	</tr>
</table>

<table width="98%" cellpadding="2" cellspacing="1" border="0">
  <tr>
	<th width="25%" nowrap="nowrap" height="25" class="cat">{L_STATISTIC}</th>
	<th width="25%" height="25" class="cat">{L_VALUE}</th>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_MAX_WORDS}:</td>
	<td class="row3"><b>{MAX_WORDS}</b></td>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_MAX_WORD}:</td>
	<td class="row3"><b>{MAX_WORD}</b></td>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_MAX_WORD_OCC}:</td>
	<td class="row3"><b>{MAX_WORD_OCC}</b></td>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_PERCENTAGE}:</td>
	<td class="row3"><b>{PERCENTAGE_MAX}</b></td>
  </tr>
</table>

<form method="post" action="{S_DISPLAY_RESULTS_ACTION}">
<table width="98%" cellspacing="0" cellpadding="2" border="0">
	<tr>
		<td align="right" nowrap="nowrap" valign="middle"><span class="genmed">{L_FILTER_STOP_WORDS}:&nbsp;{S_FILTER_STOP_WORDS}&nbsp;&nbsp;{L_SORT_OPTIONS}:&nbsp;{S_SORT_RESULTS}&nbsp;&nbsp;{L_NUM_RESULTS}:&nbsp;{S_NUM_RESULTS}&nbsp;&nbsp;
		<input type="submit" name="submit" value="{L_SUBMIT}" class="liteoption" />
		</span></td>
	</tr>
</table>

<table width="98%" cellpadding="2" cellspacing="1" border="0">
  <tr>
	<th width="10%" nowrap="nowrap" height="25" class="cat">{L_RESULT}</th>
	<th width="10%" height="25" class="cat">{L_PERCENTAGE}</th>
	<th width="80%" height="25" class="cat">{L_WORD}</th>
  </tr>
  <!-- BEGIN wordrow -->
  <tr>
	<td class="{wordrow.ROW_CLASS}" nowrap="nowrap" align="center">{wordrow.NUM_WORD}</td>
	<td class="{wordrow.ROW_CLASS}" align="center">{wordrow.PERCENTAGE}</td>
	<td class="{wordrow.ROW_CLASS}">{wordrow.WORD}</td>
  </tr>
  <!-- END wordrow -->
</table>

<table width="98%" cellspacing="1" cellpadding="2" border="0">
	<tr>
		<td align="left" nowrap="nowrap"><span class="nav">{PAGE_NUMBER}</span></td>
		<td align="right" nowrap="nowrap"><span class="nav">{PAGINATION}</span></td>
	</tr>
</table>
</form>
<br />
<div align="center"><p class="genmed">{L_MOD_VERSION}</p></div>
