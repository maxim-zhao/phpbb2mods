/**
 * DOM Page State
 *
 * This script interacts with DOM Navigation on the left frame.
 *
 * Copyright (c) 2005 phpBB Group, http://www.phpbb.com, All Rights Reserved
 *
 * This script is distributed under the terms of the GNU General Public License
 * For details, please visit: http://opensource.org/licenses/gpl-license.php
 *
 */

var dom_page_state = {
	init: function(action_id, layes_ids, mouse_class)
	{
		this.action_id = action_id;
		this.layes_ids = layes_ids;
		this.mouse_class = mouse_class;
		this.check_buttons = [null,null];
		this.dom_navigation = null;
		this.oldload = window.onload;
		window.onload = function() { if(dom_page_state.oldload){dom_page_state.oldload();dom_page_state.oldload=null;};dom_page_state.onload(); };
	},
	onload: function()
	{
		// Quit if browser not supported.
		if( !document.getElementById || !document.createTextNode ) return;
		// Quit if parent unknown.
		if( !parent.nav || !parent.nav.dom_navigation ) return;
		this.dom_navigation = parent.nav.dom_navigation;
		// Quit if buttons not found.
		this.check_buttons = [document.getElementById(this.layes_ids[1]),document.getElementById(this.layes_ids[2])];
		if( !this.check_buttons[0] || !this.check_buttons[1] ) return;
		// Quit if buttons wrapper not found.
		var buttonswrapper = document.getElementById(this.layes_ids[0]);
		if( !buttonswrapper || !buttonswrapper.style ) return;
		// Setup event handlers.
		for( var i = 0; i < this.check_buttons.length; i++ )
		{
			this.check_buttons[i].onmousedown = function(e)
			{
				if (!e) var e = window.event;
				if( ( e.button ? e.button : e.which ) != 1 ) return false;
				this.className = dom_page_state.mouse_class[0];
				return false;
			}
			this.check_buttons[i].onmouseup = function(e)
			{
				if (!e) var e = window.event;
				if( ( e.button ? e.button : e.which ) != 1 ) return false;
				dom_page_state.switch_mark();
				this.className = dom_page_state.mouse_class[1];
				return false;
			}
		}
		// Setup current state and show button.
		this.set_state();
		buttonswrapper.style.display = '';
	},
	set_state: function()
	{
		var mark = this.dom_navigation.get_mark(this.action_id);
		if( mark < 0 ) return;
		this.check_buttons[(mark==0?0:1)].style.display = 'none';
		this.check_buttons[(mark==0?1:0)].style.display = 'inline';
	},
	switch_mark: function()
	{
		this.dom_navigation.switch_mark(this.action_id);
		this.set_state();
	}
};