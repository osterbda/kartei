<div class="form-row">
  <?php
    $query = "SELECT ID, section FROM sections order by sort ASC";
    $result = mysqli_query($GLOBALS["db"], $query);
    while($row = mysqli_fetch_array($result)){
      echo "<div class='col-4 mb-2'><div style='height: 100%;' class='card'><div class='card-body'>";
      echo "<h2>".icons($row["section"],42)."</h2>";
      echo "<a href='?s=".$row["ID"]."'><h2>".$GLOBALS["trans"][$row["section"]][$row["section"]]["title"]."</h2></a>";
      echo "<p>".$GLOBALS["trans"][$row["section"]][$row["section"]]["description"]."</p></div></div></div>";
    }
  ?>
</div>
