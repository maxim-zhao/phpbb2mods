<h1>{L_CONFIGURATION_TITLE}</h1>

<p>{L_CONFIGURATION_EXPLAIN}</p>

<form action="{S_CONFIG_ACTION}" method="post"><table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">	
	<tr>
	  <th class="thHead" colspan="2">{L_IMAGE_CACHE}</th>
	</tr>
	<tr>
		<td class="row1">{L_IMG_CACHE_ENABLE}<br />{L_IMG_CACHE_ENABLE_EXP}&nbsp;<input type="submit" name="check_gd" value="{L_CHECK}" class="mainoption" style="height: 15px;" /></td>
		<td class="row2"><input type="radio" name="enable_img_cache" value="1" {IMGCACHE_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="enable_img_cache" value="0" {IMGCACHE_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_EMPTY_IMGCACHE}</td>
		<td class="row2"><input type="submit" name="empty_imgcache" value="{L_EMPTY}" class="mainoption" /></td>
	</tr>
	<tr>
		<td class="row1">{L_CACHEPATH}</td>
		<td class="row2"><input type="text" name="cachepath" value="{CACHEPATH}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_MAXSIZE}<br /><span class="gensmall">{L_MAXSIZE_EXP}</span></td>
		<td class="row2"><input type="text" name="max_image_size" value="{MAXSIZE}" size="6" maxlength="5" /></td>
	</tr>
	<tr>
		<td class="row1">{L_CACHEMAXSIZE}<br /><span class="gensmall">{L_CACHEMAXSIZE_EXP}</span></td>
		<td class="row2"><input type="text" name="image_cache_maxsize" value="{CACHEMAXSIZE}" size="6" maxlength="5" /></td>
	</tr>
	<tr>
		<td class="row1">{L_CACHEUSAGE}<br /><input type="submit" name="sizesync" value="{L_SYNC}" class="mainoption" /></td>
		<td class="row2"><img src="{CACHEUSAGE}"></td>
	</tr>
	<tr>
	  <th class="thHead" colspan="2">{L_FTP_CONF}</th>
	</tr>
	<tr>
		<td class="row1">{L_FTP_USE}<br /><span class="gensmall">{L_FTP_USE_EXP}</span></td>
		<td class="row2"><input type="radio" name="cache_useftp" value="1" {USEFTP_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="cache_useftp" value="0" {USEFTP_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_FTP}</td>
		<td class="row2"><input type="text" name="cache_ftp" value="{FTP}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_FTP_PORT}</td>
		<td class="row2"><input type="text" name="cache_ftp_port" value="{FTP_PORT}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_FTP_PATH}</td>
		<td class="row2"><input type="text" name="cache_ftp_path" value="{FTP_PATH}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_FTP_USER}</td>
		<td class="row2"><input type="text" name="cache_ftp_user" value="{FTP_USER}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_FTP_PASS}</td>
		<td class="row2"><input type="password" name="cache_ftp_pass" value="{FTP_PASS}" /></td>
	</tr>
	<tr>
	  <th class="thHead" colspan="2">{L_THUMBS}</th>
	</tr>
	<tr>
		<td class="row1">{L_USETHUMBS}</td>
		<td class="row2"><input type="radio" name="display_thumbs" value="1" {USETHUMBS_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="display_thumbs" value="0" {USETHUMBS_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_POSTIMG_SIZE}</td>
		<td class="row2"><input type="text" size="5" maxlength="5" name="postimg_width" value="{POSTIMG_WIDTH}" /> X <input type="text" size="5" maxlength="5" name="postimg_height" value="{POSTIMG_HEIGHT}" /></td>
	</tr>
	<tr>
	  <th class="thHead" colspan="2">{L_ERRORS}</th>
	</tr>
	<tr>
		<td class="row2" colspan="2" align="center"><span class="genbig"><font color="#EE0000">{ERRORS}</font></span></td>
	</tr>
	<tr>
	  <th class="thHead" colspan="2">{L_CACHE_VIEW}</th>
	</tr>
	<tr>
		<td class="row2" colspan="2" align="center">{CACHE_BROWSER}</td>
	</tr>
	<tr>
		<td class="catBottom" colspan="4" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table></form>

<br clear="all" />