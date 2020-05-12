<div class="header bg-primary shadow">
  <nav id="main" class="navbar">
    <div>
      <ul>
        <li><a href="?s=0"><?php echo $settings["orgName"]." :: ".$settings["appName"]; ?></a></li>
      </ul>
    </div>
    <div>
      <ul>
        <?php
        $query = "SELECT * FROM sections WHERE topnav = 1 ORDER BY sort ASC, section ASC";
        $result = mysqli_query($db, $query);
        while($row = mysqli_fetch_array($result)){
          //echo "<li><a href='?s=".$row["ID"]."'>".icon($row["section"])." ".$trans[$row["section"]][$row["section"]]["title"]."</a></li>";
          echo "<li><a href='?s=".$row["ID"]."'>".icons($row["section"], 42)."</a></li>";
        }
        ?>
      </ul>
    </div>
  </nav>
</div>
