
<form method="post" action="{FORM_ACTION}">
	<span class="gen"><p align="left">
	&nbsp;<b><font size="5">{L_MSN_MESSENGER}</font><font size="6">&nbsp;&nbsp;&nbsp;</font></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
	</span>
	<span class="gensmall">
	<p align="left">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	{L_MSN_EXPLAIN}</p>
<p align="left">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {L_FORM_EXPLAIN}</p>
	<p>&nbsp;</p>
	</span>
<table width="90%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
<tr>
<th>
{L_BASIC_USER}</th>
</tr>
<tr> 
<td class="row2">

	<p align="center"></p>
	<p align="left">
	&nbsp;</p>
	<p align="center"><b>{L_IMAGE_SERVER} :</b>
	<select size="1" name="server_image">
	<option selected value="NULL">{L_ADVANCED}</option>
	<option value="http://osi.lishmirror.com:81/msn/">osi.lishmirror.com</option>
	<option value="http://www.funnyweb.dk:8080/msn/">funnyweb.dk</option>
	<option value="http://www.the-server.net:8000/msn/">the-server.net:8000</option>
	<option value="http://www.the-server.net:8001/msn/">the-server.net:8001</option>
	<option value="http://www.the-server.net:8002/msn/">the-server.net:8002</option>
	<option value="http://www.the-server.net:8003/msn/">the-server.net:8003</option>
	<option value="http://snind.gotdns.com:8080/msn/">snind.gotdns.com</option>
	<option value="http://checker.tdknights.com:1337/msn/">checker.tdknights.com</option>
	<option value="http://imstatus.msitgroup.co.uk:81/msn/">imstatus.msitgroup.co.uk</option>
	<option value="http://osi.hshh.org:8088/msn/">osi.hshh.org</option>
	<option value="http://ph15.net:8000/msn/">ph15.net</option>
	<option value="http://fermulator.homeip.net:8088/msn/">fermulator.homeip.net</option>
	<option value="http://technoserv.no-ip.org:8080/msn/">technoserv.no-ip.org</option>
	<option value="http://public.hmstudios.net:8000/msn/">public.hmstudios.net</option>
	<option value="http://tpnet.gotdns.org:7070/msn/">tpnet.gotdns</option>
	</select></p>
	<p>&nbsp;</td>
</tr>
</table>
<p>&nbsp;</p>
<table width="90%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
<tr>
<th>
{L_ADVANCED_USER}</th>
</tr>
<tr>
<td class="row2">	
	<p align="center">&nbsp;</p>
	<p align="center"><b>{L_IMAGE_SERVER} :
	</b>
	
	<input type="text" name="server_image_advanced" size="20" value="http://server.com/msn/"></p>
	<p align="center">
	<input type="submit" value="{L_SUBMIT}" name="B1" class="liteoption"></p>
</td>
</tr>
</table>
	<p>&nbsp;</p>
	<p>{L_ADVANCED_EXPLAIN}</p>
	<p align="center">&nbsp;</p>
</form>