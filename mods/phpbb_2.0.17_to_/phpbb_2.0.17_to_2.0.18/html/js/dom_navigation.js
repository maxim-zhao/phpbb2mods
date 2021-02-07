/**
 * DOM Collapsible Navigation Lists
 *
 * Copyright (c) 2005 phpBB Group, http://www.phpbb.com, All Rights Reserved
 *
 * This script is distributed under the terms of the GNU General Public License
 * For details, please visit: http://opensource.org/licenses/gpl-license.php
 *
 */

var dom_navigation = {
	init: function(navclass, minusplus, processed, closed_cats)
	{
		// Quit if the browser doesn't support either of these methods.
		if( !document.getElementsByTagName || !document.createTextNode ) return;
		// Save settings
		this.navclass = navclass;
		this.processed = processed;
		this.minusplus = minusplus;
		this.closed_cats = closed_cats;
		// Deal with any previously installed onload handler.
		this.oldload = window.onload;
		window.onload = function() { if(dom_navigation.oldload){dom_navigation.oldload();dom_navigation.oldload=null;};dom_navigation.onload(); };
	},
	onload: function()
	{
		var xu = document.getElementsByTagName('ul');
		if( xu ) for( var i = 0; i < xu.length; i++ )
		{
			if( xu[i].className != this.navclass ) continue;
			this.hookup(xu[i],0);
			break;
		}
		for( var i = 0; i < this.closed_cats.length; i++ )
		{
			this.switch_cat(this.closed_cats[i]);
		}
	},
	hookup: function(xu,level)
	{
		for( var xi = xu.firstChild; xi; xi = xi.nextSibling )
		{
			if( xi.nodeName != 'LI' ) continue;
			var xa=null, xu=null;
			for( var au = xi.firstChild; au; au = au.nextSibling )
			{
				if( au.nodeName == 'A' )
				{
					xa = au;
				}
				else if( au.nodeName == 'UL' )
				{
					xu = au;
					break;
				}
			}
			if( !xa ) continue;
			xa.onclick = function() { dom_navigation.onclick(this); };
			xa.onfocus = function() { this.blur(); };
			if( level == 0 )
			{
				xa.is_navcat = true;
				xi.xa = xa;
				xa.className += ' ' + this.minusplus[0];
			}
			if( !xu ) continue;
			xa.xu = xu;
			this.hookup(xu,level+1);
		}
	},
	switch_cat: function(xid)
	{
		var xi = document.getElementById(xid);
		if( !xi || !xi.xa ) return;
		this.onclick(xi.xa);
	},
	onclick: function(xa)
	{
		if( xa.is_navcat )
		{
			var s = ( xa.className.indexOf(this.minusplus[0]) > 0 ? [0,1] : [1,0] );
			xa.className = xa.className.replace(new RegExp(this.minusplus[s[0]]), this.minusplus[s[1]]);
		}
		this.switch_children(xa);
		return false;
	},
	switch_children: function(xa)
	{
		var status = ( xa.is_navcat ? ( xa.className.indexOf(this.minusplus[0]) > 0 ? '' :  'none' ) : null );
		if( !xa.xu ) return;
		xa.xu.style.display = ( xa.is_navcat ? status : ( xa.xu.style.display == 'none' ? '' : 'none' ) );
	},
	get_mark: function(action_id)
	{
		var o = document.getElementById(action_id);
		if( !o ) return -1;
		for( var i = 0; i < this.processed.length; i++ )
		{
			if( this.processed[i] == o.className ) return i;
		}
		return -1;
	},
	switch_mark: function(action_id)
	{
		var o = document.getElementById(action_id);
		if( !o ) return;
		o.className = ( o.className == this.processed[0] ? this.processed[1] : this.processed[0] );
	}
};