<!-- BEGIN: Pseudo WYSIWYG BBcode Editor -->			
         <table border="2px">
             <tr>
              <td bgcolor="#DEE3E7" border="2px">
            <table cellspacing="0" cellpadding="2" border="0"><tr>
              <td>
               <select name="addbbcodefontfamily" onChange="bbfontstyle('[font=' + this.form.addbbcodefontfamily.options[this.form.addbbcodefontfamily.selectedIndex].value + ']', '[/font]');this.selectedIndex=0;" onMouseOver="helpline('d')">
                <option value="-" class="genmed">{L_FONT_FAMILY}</option>
                <option value="{L_FONT_ARIAL}" class="genmed">{L_FONT_ARIAL}</option>
                <option value="{L_FONT_GEORGIA}" class="genmed">{L_FONT_GEORGIA}
			    </option>
                <option value="{L_FONT_IMPACT}" class="genmed">{L_FONT_IMPACT}
				</option>
                <option value="{L_FONT_SYMBOL}" class="genmed">{L_FONT_SYMBOL}      
				</option>
                <option value="{L_FONT_TAHOMA}" class="genmed">{L_FONT_TAHOMA}    
				</option>
                <option value="{L_FONT_TIMES_NEW_ROMAN}" class="genmed">{L_FONT_TIMES_NEW_ROMAN}</option>
                <option value="{L_FONT_VERDANA}" class="genmed">{L_FONT_VERDANA}
	   		    </option>
                <option value="{L_FONT_WEBDINGS}" class="genmed">{L_FONT_WEBDINGS}
          	    </option>
               </select>
              </td>
              <td>
               <select name="addbbcodefontcolor" onChange="bbfontstyle('[color=' + this.form.addbbcodefontcolor.options[this.form.addbbcodefontcolor.selectedIndex].value + ']', '[/color]');this.selectedIndex=0;" onMouseOver="helpline('s')">
                <option value="-" class="genmed">{L_FONT_COLOR}</option>
                <option value="{L_COLOR_BLACK}" class="genmed" style="color: #000000; background-color: #000000;">{L_COLOR_BLACK}</option>
                <option value="{L_COLOR_DARK_BLUE}" class="genmed" style="color: #00008b; background-color: #00008b;">{L_COLOR_DARK_BLUE}</option>
                <option value="{L_COLOR_BLUE}" class="genmed" style="color: #0000ff; background-color: #0000ff;">{L_COLOR_BLUE}</option>
                <option value="{L_COLOR_DARK_RED}" class="genmed" style="color: #8b0000; background-color:  #8b0000;">{L_COLOR_DARK_RED}</option>
                <option value="{L_COLOR_RED}" class="genmed" style="color: #ff0000; background-color: #ff0000;">{L_COLOR_RED}</option>
                <option value="{L_COLOR_BROWN}" class="genmed" style="color: #a52a2a; background-color: #a52a2a;">{L_COLOR_BROWN}</option>
                <option value="{L_COLOR_ORANGE}" class="genmed" style="color: #ffa500; background-color: #ffa500;">{L_COLOR_ORANGE}</option>
                <option value="{L_COLOR_OLIVE}" class="genmed" style="color: #808000; background-color: #808000;">{L_COLOR_OLIVE}</option>
                <option value="{L_COLOR_GREEN}" class="genmed" style="color: #008000; background-color: #008000;">{L_COLOR_GREEN}</option>
                <option value="{L_COLOR_YELLOW}" class="genmed" style="color: #ffff00; background-color: #ffff00;">{L_COLOR_YELLOW}</option>
                <option value="{L_COLOR_INDIGO}" class="genmed" style="color: #4b0082; background-color: #4b0082;">{L_COLOR_INDIGO}</option>
                <option value="{L_COLOR_VIOLET}" class="genmed" style="color: #ee82ee; background-color: #ee82ee;">{L_COLOR_VIOLET}</option>
                <option value="{L_COLOR_CYAN}" class="genmed" style="color: #00ffff; background-color: #00ffff;">{L_COLOR_CYAN}</option>
                <option value="{L_COLOR_WHITE}" class="genmed" style="color: #ffffff; background-color: #ffffff;">{L_COLOR_WHITE}</option>
               </select>
              </td>
              <td>
               <select name="addbbcodefontsize" onChange="bbfontstyle('[size=' + this.form.addbbcodefontsize.options[this.form.addbbcodefontsize.selectedIndex].value + ']', '[/size]')" onMouseOver="helpline('f')">
                <option value="-" class="genmed">{L_FONT_SIZE}</option>
                <option value="7" class="genmed">{L_FONT_TINY}</option>
                <option value="9" class="genmed">{L_FONT_SMALL}</option>
                <option value="12" class="genmed">{L_FONT_NORMAL}</option>
                <option value="18" class="genmed">{L_FONT_LARGE}</option>
                <option value="24" class="genmed">{L_FONT_HUGE}</option>
               </select>
              </td>
             </tr>
			</table>
              </td>
              <td nowrap bgcolor="#DEE3E7" align="right">
               <img src="{WYSIWYG_EDITOR_CLOSE_ALL_TAGS}" onMouseOver="helpline('a')" onclick="javascript:bbstyle(-1)" alt="{L_BBCODE_A_HELP}" />
              </td>
             </tr>
             <tr>
              <td nowrap bgcolor="#DEE3E7" colspan="2">
            <table cellspacing="0" cellpadding="2" border="0"><tr>
              <td>
               <img src="{WYSIWYG_EDITOR_BOLD}" accesskey="b" name="addbbcode0" onclick="bbstyle(0)" onMouseOver="helpline('b')" alt="{L_BBCODE_B_HELP}" />
               <img src="{WYSIWYG_EDITOR_ITALIC}" accesskey="i" name="addbbcode2" onClick="bbstyle(2)" onMouseOver="helpline('i')" alt="{L_BBCODE_I_HELP}" />
               <img src="{WYSIWYG_EDITOR_UNDERLINE}" accesskey="u" name="addbbcode4" onClick="bbstyle(4)" onMouseOver="helpline('u')" alt="{L_BBCODE_U_HELP}" />
               <img src="{WYSIWYG_EDITOR_SPACER}" />
               <img src="{WYSIWYG_EDITOR_JUSTLEFT}" accesskey="x" name="addbbcode6" onClick="bbstyle(6)" onMouseOver="helpline('x')" alt="{L_BBCODE_X_HELP}" />
               <img src="{WYSIWYG_EDITOR_JUSTCENTER}" accesskey="y" name="addbbcode8"onClick="bbstyle(8)" onMouseOver="helpline('y')" alt="{L_BBCODE_Y_HELP}" />
               <img src="{WYSIWYG_EDITOR_JUSTRIGHT}" accesskey="z" name="addbbcode10"onClick="bbstyle(10)" onMouseOver="helpline('z')" alt="{L_BBCODE_Z_HELP}" />
               <img src="{WYSIWYG_EDITOR_JUSTIFY}" accesskey="j" name="addbbcode12"onClick="bbstyle(12)" onMouseOver="helpline('j')" alt="{L_BBCODE_J_HELP}" />               <img src="{WYSIWYG_EDITOR_SPACER}" />
               <img src="{WYSIWYG_EDITOR_ORDERLIST}" accesskey="o" name="addbbcode14"onClick="bbstyle(14)" onMouseOver="helpline('o')" alt="{L_BBCODE_O_HELP}" />
               <img src="{WYSIWYG_EDITOR_LIST}" accesskey="l" name="addbbcode16" onClick="bbstyle(16)" onMouseOver="helpline('l')" alt="{L_BBCODE_L_HELP}" />
               <img src="{WYSIWYG_EDITOR_SPACER}" />
               <img src="{WYSIWYG_EDITOR_IMAGELEFT}" accesskey="e" name="addbbcode18"onClick="bbstyle(18)" onMouseOver="helpline('e')" alt="{L_BBCODE_E_HELP}" />               <img src="{WYSIWYG_EDITOR_IMAGE}" accesskey="p" name="addbbcode20" onClick="bbstyle(20)" onMouseOver="helpline('p')" alt="{L_BBCODE_P_HELP}" />
              <img src="{WYSIWYG_EDITOR_IMAGERIGHT}" accesskey="g" name="addbbcode22"onClick="bbstyle(22)" onMouseOver="helpline('g')" alt="{L_BBCODE_G_HELP}" />   			<img src="{WYSIWYG_EDITOR_SPACER}" />
               <img src="{WYSIWYG_EDITOR_HTTP_WWW}" accesskey="w" name="addbbcode24" onClick="bbstyle(24)" onMouseOver="helpline('w')" alt="{L_BBCODE_W_HELP}" />
               <img src="{WYSIWYG_EDITOR_SPACER}" />
               <img src="{WYSIWYG_EDITOR_X_CODE}" accesskey="c" name="addbbcode26" onClick="bbstyle(26)" onMouseOver="helpline('c')" alt="{L_BBCODE_C_HELP}" />
               <img src="{WYSIWYG_EDITOR_QUOTE}" accesskey="q" name="addbbcode28" onClick="bbstyle(28)" onMouseOver="helpline('q')" alt="{L_BBCODE_Q_HELP}" />
              </td>
		</tr>
	</table>	
<!-- END: Pseudo WYSIWYG BBcode Editor -->