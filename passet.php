<?php

	/*
	* Created by Scratchoo Group
	* This tool depends on uglifyjs for minification and inotify-tools for tracking files changes
	* Dependencies are installed on the fly when they are needed.
	* Supported systems : only debian based systems (debian, ubuntu...)
	* Copyright 2018
	* Licence: MIT
	*/

	# =====================================================================================================
	# All you need to do is to set $concat and $outpu :
	# =====================================================================================================
	# Put the files you want to contact in the $contact array
	# Set $output to the name of the result file
	$concat = [

		'file1.js',
		'fold/file2.js'

	];
	$output = './test/ok.js';
	# =====================================================================================================




	# Ignore the following code, it's just some heper functions that makes the command work :)
	# -----------------------------------------------------------------------------------------------------

	if(sizeof($concat) == 0 || empty($output)){
		echo PHP_EOL;
		echo 'Please set ($concat and $output) variables in pjs.php file before continue' . PHP_EOL . PHP_EOL;
		echo 'Help :' . PHP_EOL;
		echo '======' . PHP_EOL;
		echo '$concat : is an array that contains the file(s) you want to concat and/or minify' . PHP_EOL;
		echo '$output : is the file name to output result to' . PHP_EOL;
		echo PHP_EOL;

		return false;
	}

	$minify = false;
	$watch = false;
	for($i=0 ; $i < count($argv) ; $i++){
		if(in_array($argv[$i], ['minify', 'min', '--minify', '--min', '-m'])){
			$minify = true;
		}elseif ($argv[$i] == '--watch' || $argv[$i] == '-w') {
			$watch = true;
		}
	}

	function command_exist($cmd) {
		$return = shell_exec(sprintf("which %s", escapeshellarg($cmd)));
		return !empty($return);
	}

	$uglifyjs = '';
	if($minify){
		if(!command_exist('uglifyjs')){
			echo 'we detected that uglifyjs(js minifier library) is not installed in your system! No worry we will install it for you' . PHP_EOL;
			echo 'Running command: sudo npm -g install uglify-js' . PHP_EOL;
			shell_exec("sudo npm -g install uglify-js");
		}
		if(!command_exist('uglifyjs')){ # if uglifyjs command still not exists after executing the installation command above then show a notice message
			echo "It seems that uglifyjs failed to install! Your file(s) won't be minified :(" . PHP_EOL;
		}else{
			$uglifyjs = '| uglifyjs';
		}
	}

	$any_slash = explode('/', $output);
	if (count($any_slash) > 1) {
		$folders_to_create = preg_replace('/\/[^\/]+\.js$/', '', $output); # replace file name with ''
		shell_exec("mkdir -p $folders_to_create");
	}

	# cat is linux command to concat files
	# uglifyjs will minify files
	# $output is the name of the resulting file you specified at the top
	$concat = join(' ', $concat);

	shell_exec("cat $concat $uglifyjs > $output");

	# if params watch is passed with arguments, we use inotifywait from inotify-tools library to watch files changes
	# site web : https://linux.die.net/man/1/inotifywait
	if($watch){

		# https://stackoverflow.com/questions/4060212/in-linux-how-do-i-run-a-shell-script-when-a-file-or-directory-changes
		# another lib to consider for watching changes : http://entrproject.org/
		if(!command_exist('inotifywait')){
			echo PHP_EOL;
			echo 'To watch file changes you need inotify-tools library!' . PHP_EOL;
			echo 'No worry we will install it for you...' . PHP_EOL;
			echo 'execute command : sudo apt-get install inotify-tools -y' . PHP_EOL;
			shell_exec("sudo apt-get install inotify-tools -y") . PHP_EOLs;
			echo PHP_EOL;
		}
		if(!command_exist('inotifywait')){
			echo 'Sorry we cannot watch file(s) changes because inotifywait failed to install' . PHP_EOL;
			return false;
		}

		$DIRECTORY_TO_OBSERVE = "./";
		$user_params =  join(' ', $argv);
		$script = "
		#! /bin/bash

			block_for_change() {
				inotifywait -r \
				-e modify,create \
				'$DIRECTORY_TO_OBSERVE'
			}
			build(){
				php $user_params
			}

			while block_for_change; do
				build
			done

		";
		shell_exec($script);

	}

?>
