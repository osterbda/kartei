<?php
if(!empty($_POST["search"])){
  $search = $_POST["search"];
}else{
  $search = "";
}
?>

<div class='three-columns'>
  <form method="POST" method="?s=1003">
    <input autofocus type="search" name="search" value="<?php echo $search ?>">
  </form>
</div>
<div class="three-columns">
  <?php
  if($search != ""){
    $query = "SELECT ID, nameGiven, nameFamily FROM members m WHERE m.nameGiven LIKE '%$search%' OR m.nameFamily LIKE '%$search%'";
    $result = mysqli_query($GLOBALS["db"], $query);
    while ($row = mysqli_fetch_array($result)) {
      echo "<div class='card'><a href='?s=2&p=".$row["ID"]."'>".$row["nameFamily"].", ".$row["nameGiven"]."</a></div>";
    }
  }
  ?>
</div>
