<?php
	$page = file_get_contents('index.html');
	$fortune = htmlentities(shell_exec('fortune -a linux'));
	$fortune = '<div class="sect">&sect;</div>' . "\n" .
		  '    <pre class="fortune">' . $fortune . '</pre>';
	$page = str_replace('<!--fortune-->', $fortune, $page);

	echo $page;
?>