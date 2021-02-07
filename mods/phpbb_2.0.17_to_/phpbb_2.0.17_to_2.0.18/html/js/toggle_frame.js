/**
 * Toggle Frames On and Off
 *
 * Copyright (c) 2005 phpBB Group, http://www.phpbb.com, All Rights Reserved
 *
 * This script is distributed under the terms of the GNU General Public License
 * For details, please visit: http://opensource.org/licenses/gpl-license.php
 *
 */

var toggle_frame = {
	frameset: false,
	layer: false,
	pos: [-1,-1],
	images: [],
	visible: true,
	init: function(images, imgtxt)
	{
		this.oldload = window.onload;
		this.imgtxt = imgtxt;
		this.images = [new Image(),new Image()];
		this.images[0].src = images[0];
		this.images[1].src = images[1];
		document.write('<div id="toggleframe" style="position:absolute;left:0px;top:-1000px;cursor:pointer;"><image src="'+images[0]+'" border="0" alt="" title="'+imgtxt[0]+'" onclick="toggle_frame.show(this,!toggle_frame.visible);" /></div>');
		window.onload = new Function('if(toggle_frame.oldload){toggle_frame.oldload();toggle_frame.oldload=null;};toggle_frame.onload();');
	},
	onload: function()
	{
		var doc = parent.document;
		if( doc.body && doc.body.cols )
		{
			this.layer = ( document.getElementById ? document.getElementById('toggleframe') : null );
			if( !this.layer || !this.layer.style ) return false;
			this.frameset = doc.body;
			if( typeof(this.frameset.dfltcols) != 'number' )
			{
				var cols = this.frameset.cols.split(',');
				this.frameset.dfltcols = parseInt(cols[0]);
			}
			this.move();
			return true;
		}
		return false;
	},
	move: function()
	{
		var scry, posx, sizy;
		if( typeof(window.pageYOffset) == 'number' )
		{
			scry = window.pageYOffset;
			posx = window.pageXOffset;
		}
		else if( document.documentElement && document.documentElement.scrollTop )
		{
			scry = document.documentElement.scrollTop;
			posx = document.documentElement.scrollLeft;
		}
		else if( document.body && document.body.scrollTop )
		{
			scry = document.body.scrollTop;
			posx = document.body.scrollLeft;
		}
		else
		{
			scry = posx = 0;
		}
		if( typeof(window.innerHeight) == 'number' )
		{
			sizy = window.innerHeight;
		}
		else if( document.documentElement && document.documentElement.clientHeight )
		{
			sizy = document.documentElement.clientHeight;
		}
		else if( document.body && document.body.clientHeight )
		{
			sizy = document.body.clientHeight;
		}
		else if( document.body && document.body.offsetHeight )
		{
			sizy = document.body.offsetHeight;
		}
		else
		{
			sizy = 0;
		}

		var posy = parseInt((sizy-this.images[0].height) / 2) + scry;
		if( posy < 0 ) posy = 0;

		if( posy != this.posy ) { this.posy = posy; }
		if( posx != this.posx ) { this.posx = posx; }
		this.layer.style.left = this.posx + 'px';
		this.layer.style.top  = this.posy + 'px';
		//window.status = 'div(x='+this.layer.style.left+',y='+this.layer.style.top+'), obj(x='+this.posx+',y='+this.posy+')';
		setTimeout('toggle_frame.move()',10);
	},
	show: function(img,visible)
	{
		if( !this.frameset ) return true;
		this.visible = visible;
		var cols = this.frameset.cols.split(',');
		cols[0] = ( visible ? this.frameset.dfltcols : 0 );
		var frameset_cols = '';
		for( var i = 0; i < cols.length; i++ )
		{
			frameset_cols += (i>0?',':'') + cols[i];
		}
		this.frameset.cols = frameset_cols;
		img.src = ( visible ? this.images[0].src : this.images[1].src );
		img.title = ( visible ? this.imgtxt[0] : this.imgtxt[1] );
		return false;
	}
};