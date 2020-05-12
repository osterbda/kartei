<?php
$db = mysqli_connect("localhost", "root", "", "memreg");
$db->set_charset("utf8");
if(!$db)
{
  exit("Error in SQL Connection: ".mysqli_connect_error());
}
?>
