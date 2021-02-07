/*

 ***************************************************************************
 *                               mw3.js
 *                            -------------------
 *   begin                : Saturday, Jan 19, 2005
 *   copyright            : (c) 2005 by spooky2280 - Christian Fecteau
 *   email                : webmaster@christianfecteau.com
 *
 *   $Id: mw3.js, v 1.0.0 2005/02/14 spooky2280 $
 *
 *
 ***************************************************************************

 ***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************

   mw3 (Prevent Any Layout From Being Broken) 1.0.0
   A phpBB MOD originally created by Christian Fecteau.
   Credits must be given with my full name (Christian Fecteau)
   and a link to my portfolio: http://portfolio.christianfecteau.com/
   Removal or alteration of this notice is strongly prohibited.

*/

//
// don't change anything below
//

function mw3_viewtopic()
{
	// let's make sure that there are posts in this page
	mw3_post = document.getElementsByTagName('mwthree');
	if (mw3_post && mw3_post.length && (mw3_post.length > 0))
	{
		mw3_stop_trying = 0;
		mw3_wait();
	}
}
function mw3_wait()
{
	// we need the clientWidth to be set on TDs or DIVs before running the main function
	if (mw3_stop_trying > 100)
	{
		 // 10 seconds after the page loaded
		if (mw3_debug) { alert("No clientWidth seems to be available for TDs or DIVs"); }
		return;
	}
	mw3_stop_trying++;
	mw3_cw = 0;
	mw3_div = document.getElementsByTagName("DIV");
	mw3_tds = document.getElementsByTagName("TD");
	// we'll check what the document has the more: DIVs or TDs
	if (mw3_div.length < mw3_tds.length)
	{
		for (var mw3_i = 0; mw3_i < mw3_tds.length; mw3_i++)
		{
			if (mw3_tds[mw3_i].clientWidth)
			{
				mw3_cw += mw3_tds[mw3_i].clientWidth;
			}
		}
	}
	else
	{
		for (var mw3_i = 0; mw3_i < mw3_div.length; mw3_i++)
		{
			if (mw3_div[mw3_i].clientWidth)
			{
				mw3_cw += mw3_div[mw3_i].clientWidth;
			}
		}
	}
	if (mw3_cw == 0)
	{
		window.setTimeout(mw3_wait,100);
	}
	else
	{
		mw3_cw = mw3_div = mw3_tds = null;
		mw3_go();
	}
}
function mw3_go()
{
	//
	// alright let's start...
	// get containers of posts, store them in array, and do checks for possible MOD failing
	//
	mw3_posts = [] // this array will hold the containers of the posts whether they're DIVs, TDs, etc.
	for (var mw3_i = 0; mw3_i < mw3_post.length; mw3_i++)
	{
		// crawl up to container
		var mw3_parent_block = mw3_post[mw3_i];
		while (!mw3_parent_block.clientWidth || (mw3_parent_block.clientWidth == 0))
		{
			mw3_parent_block = mw3_parent_block.parentNode;
			if (mw3_parent_block == document.body)
			{
				if (mw3_debug) { alert("We reached the top, the MOD won't work."); }
				return;
			}
			// Opera returns a clientWidth higher than 0 for inline elements
			// and style.display always returns an empty string unless specified by CSS.
			// For the moment, we'll check only for SPAN elements,
			// but they're could be other inline elements before the block container
			if (	window.opera &&
				(mw3_parent_block.nodeName == 'SPAN') &&
				(mw3_parent_block.style.display != 'block')	)
			{
				mw3_parent_block = mw3_parent_block.parentNode;
			}
		}
		// we got a container, let's make sure that there is only one post in it
		var mw3_check = mw3_parent_block.getElementsByTagName('mwthree');
		if (!mw3_check || (mw3_check && (mw3_check.length != 1)))
		{
			if (mw3_debug) { alert("There is 0 or more than 1 post in the container, the MOD won't work."); }
			return;
		}
		// this container seems valid, let's store it in array
		mw3_posts[mw3_i] = mw3_parent_block;
		// let's double check: is it the same container as the previous one?
		if (mw3_i > 0)
		{
			if (mw3_posts[mw3_i] == mw3_posts[mw3_i-1])
			{
				if (mw3_debug) { alert("Same parent twice, the MOD won't work."); }
				return;
			}
		}
	}

	//
	// Move each post into a new DIV container and the new DIV into the original container
	//
	for (var mw3_i = 0; mw3_i < mw3_posts.length; mw3_i++)
	{
		var mw3_container = document.createElement("DIV");
		// IE has a better overflow property than the W3C one
		window.showModelessDialog ? mw3_container.style.overflowX = 'auto' : mw3_container.style.overflow = 'auto';
		mw3_container.style.visibility = 'hidden';
		mw3_container.style.width = '100px';
		mw3_container.style.height = '100px';
		// move post into DIV
		while (mw3_posts[mw3_i].hasChildNodes())
		{
			mw3_container.appendChild(mw3_posts[mw3_i].firstChild);
		}
		// put DIV into container
		mw3_posts[mw3_i].appendChild(mw3_container);
	}
	// we'll wait till the clientWidth is stable.
	mw3_cw = []
	mw3_wait_reflow();
}
function mw3_wait_reflow()
{
	for (var mw3_i = 0; mw3_i < mw3_posts.length; mw3_i++)
	{
		mw3_cw[mw3_i] = mw3_posts[mw3_i].clientWidth;
	}
	window.setTimeout(mw3_check_cw,100);
}
function mw3_check_cw()
{
	for (var mw3_i = 0; mw3_i < mw3_posts.length; mw3_i++)
	{
		if (mw3_cw[mw3_i] != mw3_posts[mw3_i].clientWidth)
		{
			window.setTimeout(mw3_wait_reflow,100);
			return;
		}
	}
	mw3_resize_div();
}
function mw3_resize_div()
{
	//
	// the layout has now its natural width let's check what it is, loop through each post, and resize
	//
	for (var mw3_i = 0; mw3_i < mw3_posts.length; mw3_i++)
	{
		mw3_container = mw3_posts[mw3_i].firstChild; // mw3_container is the new DIV
		if (window.showModelessDialog) // IE needs a different processing.
		{
			mw3_container.style.margin = '0% -150% 0% 0%'; // IE needs a negative right margin
			// rise up the content of the post so the horizontal scrollbar won't hide its bottom (20px)
			mw3_container.style.padding = '0px 5px 20px 0px';
			// give to the new DIV the current (and now normal) width of the original container
			mw3_container.style.width = mw3_posts[mw3_i].clientWidth + 'px';
		}
		else if (!window.opera && !document.all) // Gecko, Safari, etc.
		{
			// rise up the content of the post so the horizontal scrollbar won't hide its bottom (3px)
			mw3_container.style.padding = '0px 0px 3px 0px';
			// give to the new DIV the current (and now normal) width of the original container
			// Gecko needs a little less than the parent width (* 0.99)
			mw3_container.style.width = (mw3_posts[mw3_i].clientWidth * 0.99) + 'px';
		}
		else // Opera only I think
		{
			mw3_container.style.padding = '0px 0px 3px 0px';
			mw3_container.style.width = mw3_posts[mw3_i].clientWidth + 'px';
		}
		mw3_container.style.height = 'auto';
	}
	mw3_rmw_go();
}
// function to resize images within posts
function mw3_rmw_go()
{
	if (!window.opera)
	{
		// let's create a dummy object for the not yet existing popup
		mw3_rmw_pop = new Object();
		mw3_rmw_pop.closed = true;
		// we need to close the popup onunload of the page for access permission (browser security)
		mw3_old_onunload = null;
		if (typeof window.onunload == "function")
		{
			mw3_old_onunload = window.onunload;
		}
		window.onunload = function()
		{
			// run the aliens onunload
			if (mw3_old_onunload)
			{
				mw3_old_onunload();
				mw3_old_onunload = null;
			}
			if (!mw3_rmw_pop.closed) { mw3_rmw_pop.close(); }
		}
	}
	mw3_rmw_pop_options = 'top=0,left=0,width=' + String(window.screen.width-80) + ',height=' + String(window.screen.height-190) + ',scrollbars=1,resizable=1';
	mw3_loop_i:
	for (var mw3_i = 0; mw3_i < mw3_posts.length; mw3_i++)
	{
		mw3_rmw_imgs = mw3_posts[mw3_i].getElementsByTagName("IMG");
		mw3_loop_j:
		for (var mw3_j = 0; mw3_j < mw3_rmw_imgs.length; mw3_j++)
		{
			mw3_rmw_img = mw3_rmw_imgs[mw3_j];
			// do we resize it? Let'see if the image is larger than the DIV width
			if (	mw3_rmw_img.width &&
				!isNaN(mw3_rmw_img.width) &&
				(mw3_posts[mw3_i].firstChild).clientWidth &&
				!isNaN((mw3_posts[mw3_i].firstChild).clientWidth) &&
				(mw3_rmw_img.width > Math.floor(((mw3_posts[mw3_i].firstChild).clientWidth * 0.9)) )	)
			{
				// yes we do resize...
				mw3_rmw_img.style.width = Math.floor(((mw3_posts[mw3_i].firstChild).clientWidth * 0.9)) + 'px';
				// if we are in the Topic Review iframe, we don't make anything 
				// popable because of iframes security restrictions
				if (window.topr) { continue mw3_loop_j; }
				// make the popup onclick
				if (!window.opera)
				{
					mw3_rmw_img.onclick = function()
					{
						if (!mw3_rmw_pop.closed) { mw3_rmw_pop.close(); }
						mw3_rmw_pop = window.open('about:blank','christianfecteaudotcom',mw3_rmw_pop_options);
						mw3_rmw_pop.resizeTo(window.screen.availWidth,window.screen.availHeight);
						mw3_rmw_pop.moveTo(0,0);
						mw3_rmw_pop.focus();
						mw3_rmw_pop.location.href = this.src;
					}
				}
				else
				{
					mw3_rmw_img.onclick = function()
					{
						mw3_rmw_pop = window.open(this.src,'christianfecteaudotcom',mw3_rmw_pop_options);
						mw3_rmw_pop.focus();
					}
				}
				document.all ? mw3_rmw_img.style.cursor = 'hand' : mw3_rmw_img.style.cursor = 'pointer';
				mw3_rmw_img.title = mw3_rmw_img.src;
			}
		}
	}
	window.setTimeout(mw3_adjust,100);
}
function mw3_adjust()
{
	// some adjustments if overflow was not required for a particular post, so reloop!
	for (var mw3_i = 0; mw3_i < mw3_posts.length; mw3_i++)
	{
		mw3_container = mw3_posts[mw3_i].firstChild; // mw3_container is the new DIV
		if (window.showModelessDialog) // IE needs a different processing
		{
			// if there is no overflow for that post, remove the padding
			if ((mw3_container.scrollWidth - mw3_container.clientWidth) == 0)
			{
				mw3_container.style.padding = '0px 0px 0px 0px';
			}
			else if (!window.topr)
			{
				mw3_container.ondblclick = function()
				{
					if (!mw3_rmw_pop.closed) { mw3_rmw_pop.close(); }
					mw3_rmw_pop = window.open('about:blank','christianfecteaudotcom',mw3_rmw_pop_options);
					mw3_rmw_pop.resizeTo(window.screen.availWidth,window.screen.availHeight);
					mw3_rmw_pop.moveTo(0,0);
					mw3_rmw_pop.focus();
					if (document.fireEvent)
					{
						mw3_rmw_pop.document.body.innerHTML = '<div style="word-break:break-all">' + eval("this.innerHTML.replace(/<img.*?>/gi,'')") + '</div>';
					}
					else
					{
						mw3_rmw_pop.document.body.innerHTML = '<div style="word-break:break-all">' + this.innerHTML + '</div>';
					}
				}
				mw3_container.style.cursor = 'crosshair';
			}
		}
		else if (!window.opera && !document.all) // Gecko, Safari, etc
		{
			// if there is no overflow for that post, set back the overflow to 'visible'
			// because Gecko sometimes puts a useless vertical scrollbar otherwise
			if ((mw3_container.scrollWidth - mw3_container.clientWidth) == 0)
			{
				mw3_container.style.overflow = 'visible';
				mw3_container.style.padding = '0px 0px 0px 0px';
			}
			else if (!window.topr)
			{
				mw3_container.ondblclick = function()
				{
					if (!mw3_rmw_pop.closed) { mw3_rmw_pop.close(); }
					mw3_rmw_pop = window.open('about:blank','christianfecteaudotcom',mw3_rmw_pop_options);
					mw3_rmw_pop.resizeTo(window.screen.availWidth,window.screen.availHeight);
					mw3_rmw_pop.moveTo(0,0);
					mw3_rmw_pop.focus();
					mw3_this = eval("this.innerHTML.replace(/<img.*?>/gi,'')");
					window.setTimeout('mw3_rmw_pop.document.body.innerHTML = mw3_this',100);
				}
				mw3_container.style.cursor = 'crosshair';
			}
		}
		else // Opera only I think
		{
			if (mw3_container.scrollWidth <= mw3_container.clientWidth)
			{
				mw3_container.style.overflow = 'visible';
				mw3_container.style.padding = '0px 0px 0px 0px';
			}
			else if (!window.topr)
			{
				mw3_container.ondblclick = function()
				{
					mw3_rmw_pop = window.open('about:blank','christianfecteaudotcom',mw3_rmw_pop_options);
					mw3_rmw_pop.focus();
					mw3_rmw_pop.document.open();
					mw3_rmw_pop.document.write(eval("this.innerHTML.replace(/<img.*?>/gi,'')"));
					mw3_rmw_pop.document.close();
				}
				mw3_container.style.cursor = 'crosshair';
			}
		}
		mw3_container.style.visibility = 'visible';
	}
}




// let's check that we can run the MOD and... go!!!
if (	document.getElementsByTagName &&
	document.createElement &&
	document.body.clientWidth &&
	(window.screen.width >= 800)	)
{
	mw3_debug = true; // output alerts on error
	mw3_old_onload = null;
	if (typeof window.onload == "function")
	{
		mw3_old_onload = window.onload;
	}
	window.onload = function()
	{
		// run the aliens onload
		if (mw3_old_onload)
		{
			mw3_old_onload();
			mw3_old_onload = null;
		}
		mw3_viewtopic();
	}
}
