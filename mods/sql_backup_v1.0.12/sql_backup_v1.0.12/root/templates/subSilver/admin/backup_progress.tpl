<!-- $Id: backup_progress.tpl 8 2006-04-13 18:07:42Z vic $ -->

<h1>{L_SB_TITLE}</h1>

<br /><br />

<table width="80%" cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th>{L_SB_PROCESSING_TH}</th>
	</tr>
	<tr>
		<td align="center" class="row1">
			<span class="genmed">
				<br />{L_SB_PROCESSING_TITLE}<br />
			</span>
			<span class="gensmall">
				{L_SB_PROCESSING_EXPLAIN}
			</span>
			<br /><br /><br /><br />
			<input type="text" id="current_table" style="width: 400px; font-weight: bold; background-color: {T_TR_COLOR1}; border-style: none"><br /><br />
			<div align="left" style="width: 400px; border: 1px solid #000000">
				<div id="progress" style="height: 18px; background-color: {T_TR_COLOR3}"></div>
			</div>
			<br />&nbsp;
		</td>
	</tr>
</table>

<br clear="all" />

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td align="center">
			<span class="copyright">SQL Backup MOD &copy; 2005-2006 Vic D'Elfant<br />[ <a href="http://www.phpbb.com/phpBB/profile.php?mode=viewprofile&u=118634" class="copyright" target="_blank">phpBB.com {L_PROFILE}</a> :: <a href="http://www.coronis.nl" class="copyright" target="_blank">{L_WEBSITE}</a> ]</span>
		</td>
	</tr>
</table>

<br />

<script language="JavaScript" type="text/javascript">
	var http_request = false;
	var offset = 0;
	var next_offset = 0;

	function http_do_request(url, onready_function)
	{
		http_request = false;

		if ( window.XMLHttpRequest ) // Mozilla, Safari,...
		{
			http_request = new XMLHttpRequest();
			if ( http_request.overrideMimeType )
			{
				http_request.overrideMimeType('text/xml');
			}
		}
		else if ( window.ActiveXObject ) // IE
		{
			try
			{
				http_request = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch ( e )
			{
				try
				{
					http_request = new ActiveXObject("Microsoft.XMLHTTP");
				}
				catch ( e ) { }
			}
		}

		if ( !http_request )
		{
			alert('{L_SB_ERROR_REQUEST}');
			return false;
		}

		http_request.onreadystatechange = onready_function;
		http_request.open('GET', url, true);
		http_request.send(null);
	}

	function update_progress()
	{
		if ( http_request.readyState == 4 )
		{
			if ( http_request.status == 200 )
			{
				var source = http_request.responseXML.getElementsByTagName("backup-data")[0];

				if ( !source )
				{
					document.open();
					document.write(http_request.responseText);
					document.close();
				}

				var table_name = source.getElementsByTagName("table-name")[0];
				var progress = source.getElementsByTagName("progress")[0];
				next_offset = source.getElementsByTagName("next-offset")[0];

				// Strip all whitespace
				table_name = table_name.childNodes[0].nodeValue.replace(/^\s+|\s+$/g, "");
				progress = progress.childNodes[0].nodeValue.replace(/^\s+|\s+$/g, "");
				next_offset = next_offset.childNodes[0].nodeValue.replace(/^\s+|\s+$/g, "");

				document.getElementById("current_table").value = table_name;

				if ( progress == "finished" )
				{
					document.location.href = "{U_SUBMIT}&finished=true";
				}
				else
				{
					document.getElementById("progress").style.width = ( progress * 4 ) + "px";
					http_do_request("{U_SUBMIT}&offset=" + next_offset, update_progress);
				}
			}
			else
			{
				alert("{L_SB_ERROR_REQUEST}");
			}
		}
	}

	http_do_request("{U_SUBMIT}&offset=" + offset, update_progress);
</script>