/**
 * Select onclick
 * This script is partically based on the Select/Expand BBCodes MOD
 *
 * Copyright (c) 2005 phpBB Group, http://www.phpbb.com, All Rights Reserved
 *
 * This script is distributed under the terms of the GNU General Public License
 * For details, please visit: http://opensource.org/licenses/gpl-license.php
 *
 */

var select_onclick = {
	init: function(title)
	{
		// Save settings
		this.title = title;
		// Deal with any previously installed onload handler.
		this.oldload = window.onload;
		window.onload = function() { if(select_onclick.oldload){select_onclick.oldload();select_onclick.oldload=null;};select_onclick.onload(); };
	},
	onload: function()
	{
		if( !this.is_select_able() ) return;
		var x = document.getElementsByTagName('pre');
		for( var i = 0; i < x.length; i++ )
		{
			if( x[i].id )
			{
				x[i].title = this.title;
				x[i].onclick = new Function("select_onclick.select('" + x[i].id + "');");
			}
		}
	},
	is_iemac: function()
	{
		var ua = String(navigator.userAgent).toLowerCase();
		if( document.all && ua.indexOf("mac") >= 0 )
			return true;
		return false;
	},
	is_select_able: function()
	{
		if( (document.selection && !this.is_iemac()) || (document.createRange && (document.getSelection || window.getSelection)) )
			return true;
		return false;
	},
	select: function(id)
	{
		var o = document.getElementById(id);
		if( !o ) return;
		var r, s;
		if( document.selection && !this.is_iemac() )
		{
			r = document.body.createTextRange();
			r.moveToElementText(o);
			r.select();
		}
		else if( document.createRange && (document.getSelection || window.getSelection) )
		{
			r = document.createRange();
			r.selectNodeContents(o);
			s = window.getSelection ? window.getSelection() : document.getSelection();
			s.removeAllRanges();
			s.addRange(r);
		}
	}
};