<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
<tr><td align="left"><h1>{L_TITLE}</h1></td></tr>
<tr><td align="left">{L_DESCRIPTION}</td></tr>
</table>

<P />
<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center"><tr><th class="thHead" colspan="7">{L_FORUM_TITLE}</th></tr>

<!-- BEGIN catrow -->

<tr>
<td class="catLeft"><span class="cattitle"><b><a href="{catrow.U_VIEWCAT}">{catrow.CAT_DESC}</a></b></span></td>
<td class="catLeft" align="center">{L_FILTER_STATUS}</td>
<td class="catLeft" align="center">{L_CHANGE}</td>
</tr>

<!-- BEGIN forumrow -->

<tr>
<td class="row2"><span class="gen"><a href="{catrow.forumrow.U_VIEWFORUM}" target="_new">{catrow.forumrow.FORUM_NAME}</a></span><br /><span class="gensmall">{catrow.forumrow.FORUM_DESC}</span></td>
<td class="row1" align="center">{catrow.forumrow.I_STATUS}</td>
<td class="row2" align="center"><a href="{catrow.forumrow.U_ENABLE}">{L_ENABLE}</a><br /><a href="{catrow.forumrow.U_DISABLE}">{L_DISABLE}</a></td>
</tr>

<!-- END forumrow -->

<!-- END catrow -->
</table>

