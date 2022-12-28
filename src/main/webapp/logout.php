<?php
session_start();
session_destroy();
 
die(header('Location: http://zeiterfassung-wbh.de'));
?>