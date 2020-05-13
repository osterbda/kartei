<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
  <a class="navbar-brand mr-auto" href="?s=0"><?php echo $settings["orgName"]." :: ".$settings["appName"]; ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <form class="form-inline my-2 my-lg-0 ml-auto mr-auto" action="?s=1003" method="post">
      <input type="search" class="form-control" name="search" value="">
    </form>
    <ul class="navbar-nav">
      <?php
      $query = "SELECT * FROM sections WHERE topnav = 1 ORDER BY sort ASC, section ASC";
      $result = mysqli_query($db, $query);
      while($row = mysqli_fetch_array($result)){
        //echo "<li><a href='?s=".$row["ID"]."'>".icon($row["section"])." ".$trans[$row["section"]][$row["section"]]["title"]."</a></li>";
        echo "<li class='nav-item'><a class='nav-link' href='?s=".$row["ID"]."'>".$GLOBALS["trans"][$row["section"]][$row["section"]]["title"]."</a></li>";
      }
      ?>
    </ul>
  </ul>
</nav>
