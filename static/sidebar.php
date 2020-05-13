<nav id="menu" class="">
  <ul class="nav flex-column">
    <?php
    $query = "SELECT * FROM sections ORDER BY sort ASC";
    $result = mysqli_query($db, $query);
    while($row = mysqli_fetch_array($result)){
      echo "<li class='nav-item'><a class='nav-link menu-item' href='?s=".$row["ID"]."'>";
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
