# scumbagr
A forum system with complex permissions for seeing and posting in different forums.

## INFO
You have to have a file called scumbagr.php in the parent directory which defines the
constants server,username,password and database for mysql.

the permission levels are like this:
 - level 0 - filthy pleb who just walked in off the street
 - level 1 - has been around for more than five minutes
 - level 2 - elder
 - level 3 - me

## TODO
 - in order to make it that all the pages are cohesive and not a total pain to make, I can
   use php code to create the header and footer of each page. I tried this before and it
   didn't work all that well, but I think I was just being a mongo. all it will add is the
   start of the html code, the site's banner and links to some stuff if necessary.
   Since it will add the whole head section, I guess I'll need to pass in the page name.

 - make a single function to call to do sql queries and test for errors and stuff like
   that.
