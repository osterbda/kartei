<div class="sidebar">
  <nav id="main" class="">
    <ul>
      <?php
      $query = "SELECT * FROM sections ORDER BY sort ASC";
      $result = mysqli_query($db, $query);
      while($row = mysqli_fetch_array($result)){
        echo "<li><a style='padding-left:".$row["level"]."rem' href='?s=".$row["ID"]."'>".icons($row["section"], 42)." ";
        if(isset($GLOBALS["trans"][$row["section"]][$row["section"]]["title"])){
          echo $GLOBALS["trans"][$row["section"]][$row["section"]]["title"];
        }else {
          echo "LOST IN TRANSLATION";
        }
        echo "</a></li>";
      }
      ?>
    </ul>
  </nav>
</div>
