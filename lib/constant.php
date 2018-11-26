<?php
define('PUBLICS',__FILE__);
define('DS',DIRECTORY_SEPARATOR);
define('ROOT',dirname(dirname(PUBLICS)).DS);
define('CORE',ROOT.'core'.DS);
define('APP',ROOT.'app'.DS);
define('URL',dirname($_SERVER['SCRIPT_NAME']).DS.$_SERVER['HTTP_HOST'].'/');


