This mod allows different ranking themes for your forum. Users
are allowed to choose a ranking theme to their liking.

For example, you can add two ranking themes named "Good" and
"Evil" for your forum. The ranking then might look like this:

|===========================|
| Posts  | Good   | Evil    |
| Needed | Ranks  | Ranks   |
|--------+--------+---------|
|  0	   | Squire | Zombie  |
|  10	   | Knight | Warlock |
|  20	   | King   | Demon   |
|  50	   | Angel  | Devil   |
|===========================|

So if one were to choose the "good" ranking, then he will
go through the ranks Squire, Knight, King, and finally Angel,
but another user might decide to choose the "Evil" theme, he
will go through the ranks Zombie, Warlock, Demon, then Devil.

On install, there are two ranking themes already added,
"special" and "default". Ranks classified as special cannot
be chosen by the public. Special ranks theme have a
precedence over other ranking themes, which means that if
the username has an assigned rank title, then his ranking
theme will not matter. If a user has a special rank or a
private ranking theme, he will not be able to change his
ranking theme. A user will not be able to select the custom
ranking theme until he has reached the required post count
or an admin has set his account to be allowed to have it.

Here is an example table:
-The first five rows are what an admin can do to a user
*"Can change" means that the user can still select public
 ranking themes (e.g. "default")
**If a a result is "Custom" and "Can change", that means that
  the user is able to choose whether he wants a public
  ranking theme or a custom ranking theme

|=================================================|
| Special | Ranking | Allow   | Meet    | Results |
| Rank    | Theme   | Custom  | Require |         |
| Assigned|         | Ranking | -ments  |         |
|---------+---------+---------+---------+---------|
| Yes     | Any     | Any     | Any     | Special |
|         |         |         |         | *Cannot |
|         |         |         |         | change  |
|---------+---------+---------+---------+---------|
| No      | Private | Any     | Any     | Private |
|         |         |         |         | *Cannot |
|         |         |         |         | change  |
|---------+---------+---------+---------+---------|
| No      | Custom  | No      | Any     | Custom  |
|         |         |         |         | *Cannot |
|         |         |         |         | change  |
|---------+---------+---------+---------+---------|
| No      | Any     | Yes     | Any     | Custom  |
|         |         |         |         | **Can   |
|         |         |         |         | change  |
|---------+---------+---------+---------+---------|
| No      | Public  | No      | Any     | Public  |
|         |         |         |         | *Can    |
|         |         |         |         | change  |
|---------+---------+---------+---------+---------|

|---------+---------+---------+---------+---------|
| No      | Public  | Default | No      | Public  |
|         |         |         |         | *Can    |
|         |         |         |         | change  |
|---------+---------+---------+---------+---------|
| No      | Public  | Default | Yes     | Custom  |
|         |         |         |         | *Can    |
|         |         |         |         | change  |
|=================================================|








