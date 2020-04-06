<?php
	//require_once dirname(__FILE__).'/renders.php';
	$modules = array_filter(glob(dirname(__FILE__).'/*'), 'is_dir');
	foreach ($modules as $module)
	{
		$filename = $module.DIRECTORY_SEPARATOR.basename($module).'.php';
		//echo 'AAAAaaaaa'.$filename;
		if(file_exists($filename))
		{
			require_once $filename;
		}
	}