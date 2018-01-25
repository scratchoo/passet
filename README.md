# passet
A php tool to concat and minify javascript files

## Why this tool ? 
We found ourselves using different js build tools everytime to just concat and minify our javascript, but those tools aren't simple and most of them take time to learn, worst sometimes you need to install tons of dependencies just to do a simple task like minifying your code! (and hopefully you don't face some deprecation notice & errors during the process...)

PHP to the rescue ! we already use php for different things including web development so we decided to write this little php tool to help concat (work also if you have a standalone file) and/or minify js + a watch functionnality to concat & minify your files in the fly...

And YEAH it's very easy to use, no learning curve needed, even a newbie can use it :)

## Quick Start

1) download the passet.php file and place it within your js folder

2) open passet.php file with your text editor, all you need to do here is to 

- Set the name of your js files in $concat array
- Set the name of the output/result file to the $output variable

Example :

```
$concat = [

		'file1.js',
    'file2.js',
		'another_folder/file3.js'

];

$output = './dist/app.js';
  
```
3) To concat and minify your files, open your console/terminal and run :

```
php passet.php --minify
```
This will create a dist folder with a your minified js in a file called app.js

### Concat files only ?

just run the same command above without --minify option

```
php passet.php
```

### Watch for changes

Every time you make a change to any file, you need to re-run the `php passet.php --minify` command, However if you prefer to do that automatically, just call the same command by adding --watch option

```
php passet.php --minify --watch
```

### Options Summury

--minify, -m : minify files

--watch, -w : watch files changes and run the command automatically

## Licence

Source code can be found on [github](https://github.com/scratchoo/passet), licenced under [MIT](http://opensource.org/licenses/mit-license.php).

