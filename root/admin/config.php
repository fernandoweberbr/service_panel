<?php

define('BD_USER', 'root');
define('BD_PASS', 'usbw');
define('BD_NAME', 'pcp');
mysql_connect('localhost', BD_USER, BD_PASS);
mysql_select_db(BD_NAME);

?>