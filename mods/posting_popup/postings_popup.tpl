<title>{PAGE_TITLE}</title>

<!-- link rel="stylesheet" href="templates/subSilver/{T_HEAD_STYLESHEET}" type="text/css" -->
<style type="text/css">
<!--
body { background-color: {T_BODY_BGCOLOR}; }
font,th,td,p { font-family: {T_FONTFACE1} }
a:hover		{ text-decoration: underline; color : {T_BODY_HLINK}; }
.forumline	{ background-color: {T_TD_COLOR2}; border: 2px {T_TH_COLOR2} solid; }
td.row1	{ background-color: {T_TR_COLOR1}; }
td.row3	{ background-color: {T_TR_COLOR3}; }
th	{color: {T_FONTCOLOR3}; font-size: {T_FONTSIZE2}px; font-weight : bold; background-color: {T_BODY_LINK}; height: 25px;}
.gensmall { font-size : {T_FONTSIZE1}px; }
.name	  { font-size : {T_FONTSIZE2}px; color : {T_BODY_TEXT};}
-->
</style>

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<th colspan="2" align="center" class="row1" nowrap="nowrap">{L_TOTAL_POSTS}&nbsp;:&nbsp;{TOTAL_TOPICS}</th>
	</tr>
	<tr> 
		<td class="row3"><span class="name">&nbsp;&nbsp;&nbsp;{L_USER}</span></td>
		<td align="center" class="row3"><span class="name">{L_POSTS}</span></td>
	</tr>
	<!-- BEGIN topicrow -->
	<tr>
		<td class="row1"><span class="name">{topicrow.POSTER}</span></td>
		<td class="row1" align="center"><span class="name">{topicrow.POSTS}</span></td>
	</tr>
	<!-- END topicrow -->
	<tr>
		<td colspan="2" align="left"class="row3"><span class="name">*&nbsp;=&nbsp;{L_AUTHOR}</span></td>
	</tr>
	<tr>
		<td colspan="2" align="center"class="row3"><span class="name">{L_CLOSE_WINDOW}</span></td>
	</tr>
</table>