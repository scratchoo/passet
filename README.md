# passet
A php tool to concat and minify javascript files

## When to use this tool ? 

* You use php already
* You want to concat and/or minify your js files
* You don't want to install/use complex js build tools that sucks
* you want something easy and simple to use (No learning curve needed)

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
3) To concat and minify your files, open your console/terminal (don't forget to cd to your js folder) and run :

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

