<?php
if($p === "update"){
  echo "<div>".update($_POST["section"], $_POST)."</div>";
}elseif($p === "add"){
  echo "<div>".add($_POST["section"], $_POST)."</div>";
}elseif($p === "settings"){
  echo "<div>".settings($_POST)."</div>";
}else{
  $query = "SELECT ID, section FROM sections WHERE class = 1 ORDER BY sort ASC";
  $result = mysqli_query($GLOBALS["db"], $query);
  while($row = mysqli_fetch_array($result)){
    echo "<a href='?s=".$row["ID"]."&p=add'><div class='pills bg-primary-light'><h2>".icons($row["section"],42)."</h2><h2>";
    echo $GLOBALS["trans"][$row["section"]]["add"]["title"];
    echo "</h2>";
    echo "<h4>".$GLOBALS["trans"][$row["section"]]["add"]["description"]."</h4></div></a>";
  }
}
?>
