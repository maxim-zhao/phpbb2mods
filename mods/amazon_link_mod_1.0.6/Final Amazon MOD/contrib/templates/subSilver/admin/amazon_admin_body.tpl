<h1>{L_PAGE_TITLE}</h1>

<P>{L_PAGE_DESC}</p>
<br />

<form method="post" action="{S_CHARTS_ACTION}"><table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th colspan="2" class="catHead">{L_EDITING_TITLE}</th>
	</tr>
	<tr valign="middle">
		<td class="row1"><span class="mainmenu">{L_COUNTRY}</span></td>
	  <td class="row2"><span class="mainmenu"><select name="amazon" id="amazon">
		  <option value="0"></option>
		  <option value="0" {S_UK_SELECTED}>{L_UK}</option>
		  <option value="1" {S_US_SELECTED}>{L_US}</option>
		  <option value="2" {S_CANADA_SELECTED}>{L_CANADA}</option>
		  <option value="3" {S_GERMANY_SELECTED}>{L_GERMANY}</option>
		  <option value="4" {S_FRANCE_SELECTED}>{L_FRANCE}</option>
		  <option value="5" {S_JAPAN_SELECTED}>{L_JAPAN}</option>
        </select>
          </span>
      </td>
	</tr>
	<tr valign="middle">
		<td class="row1"><span class="mainmenu">{L_POSTS}</span></td>
		<td class="row2"><input type="checkbox" name="normal" value="1" {S_ENABLED_NORMAL} />
		  {L_NORMAL}<br />
	        <input type="checkbox" name="sticky" value="1" {S_ENABLED_STICKY} /> 
	        {L_STICKY}
<br />
<input type="checkbox" name="announce" value="1" {S_ENABLED_ANNOUNCE} /> 
{L_ANNOUNCE} 
</td>
	</tr>
	<tr valign="middle">
	  <td class="row1">{L_USERNAME}</td>
	  <td class="row2"><input name="username" type="text" value="{L_AFFILIATE}" /></td>
    </tr>
	<tr valign="middle">
      <td class="row1">{L_IMAGES}</td>
      <td class="row2"><input name="images" type="text" value="{S_IMAGE_LOCATION}" /></td>
    </tr>
	<tr valign="middle">
	  <td class="row1">{L_WINDOW}</td>
	  <td class="row2"><input type="checkbox" name="newwindow" value="1" {S_ENABLE_WINDOW} /></td>
    </tr>
	<tr valign="middle">
	  <td class="row1">{L_ENABLE}</td>
	  <td class="row2"><input name="enable" type="checkbox" id="enabled" value="1" {S_ENABLED_AMAZON} /></td>
    </tr>
	<tr valign="middle">
	  <td colspan="2" align="center" class="row2">{L_INFO_TEXT}</td>
    </tr>
	<tr valign="middle">
	  <td colspan="2" align="center" class="catBottom"><input type="hidden" name="id" value="1" /><input type="submit" name="save" value="{L_SAVE}" class="mainoption" />	    </td>
	</tr>
	<tr valign="middle">
	  <td colspan="2" align="center" class="row2"><span class="mainmenu">{L_CREATED_BY}<a href="http://www.dvdsandstuff.net"></a></span></td>
    </tr>
</table>
  <div align="center"></div>
</form>
