<div class="toolbar">
  <?php
  echo "<nav><ul>";
  $query = "SELECT ID, section FROM sections WHERE class = 1 ORDER BY sort ASC";
  $result = mysqli_query($GLOBALS["db"], $query);
  while($row = mysqli_fetch_array($result)){
    echo "<li><a href='?s=".$row["ID"]."&p=add'>".icons("add", 42).icons($row["section"], 42);
    //echo $GLOBALS["trans"][$row["section"]]["add"]["title"];
    echo "</a></li>";
  }
  echo "</ul></nav>";
  ?>
</div>
