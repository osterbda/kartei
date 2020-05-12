<?php
  $query = "SELECT ID, section FROM sections order by sort ASC";
  $result = mysqli_query($GLOBALS["db"], $query);
  while($row = mysqli_fetch_array($result)){
    echo "<a href='?s=".$row["ID"]."'><div class='pills bg-primary-light'><h2>".icons($row["section"],42)."</h2><h2>".$GLOBALS["trans"][$row["section"]][$row["section"]]["title"]."</h2>";
    echo "<h4>".$GLOBALS["trans"][$row["section"]][$row["section"]]["description"]."</h4></div></a>";
  }
?>
