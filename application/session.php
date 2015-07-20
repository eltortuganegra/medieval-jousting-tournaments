<?php
session_start();

echo "SESSION START -> ".session_id();


echo "SESSION REGENERATE -> ".session_regenerate_id(true);
session_write_close()
?>