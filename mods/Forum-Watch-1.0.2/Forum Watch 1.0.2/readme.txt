Mod Summary
============================================================================
## MOD Title: Forum Watch
## MOD Author: skinmaster < mike@fuckingbrit.com > (Michael Jervis) http://www.fuckingbrit.com
## MOD Description: Allows forum users to watch a forum for new topics.
## MOD Version: 1.0.1
============================================================================

This mod for PHPBB 2.0.x allows a user to watch an entire forum for new
topics. If you are not using subsilver, the secret words of power for your
viewforum_body.tpl are:

{S_WATCH_FORUM}

This was developed for a special need for an CRM forum at the company I work
for. We had one further requirement, that was that if you watch a forum, you
automaticaly watch new topics. I left this out of the install mod as I
personally don't think that feature is desirable for the Great Unwashed (you
(and me outside of work)). However, should you wish to add it, the mod
template contrib/Forum-Watch-Topic-1.0.2.mod contains the code.

NOTE 1: FIRST APPLY THE MAIN MOD! THIS IS A MOD TO THE MOD!!!
NOTE 2: Be careful with the FIND! The FIND has to identify a large block of
				code because the block is almost identical to the notification block
				for a topic reply for a topic watcher. However, it is vital you add
				this to the new topic notification block, not the topic notification
				block. Sorry.