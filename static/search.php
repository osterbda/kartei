<?php
if(!empty($_POST["search"])){
  $search = $_POST["search"];
}else{
  $search = "";
}
?>

<form class="form" method="POST" method="?s=1003">
  <div class="form-row m-0">
    <div class="col-10">
      <input class="form-control" autofocus type="search" name="search" value="<?php echo $search ?>">
    </div>
    <div class="col-2">
      <input class="form-control btn btn-primary" type="submit" value="<?php echo $GLOBALS["trans"]["search"]["search"]["title"] ?>">
    </div>
  </div>
</form>
<div class="card mt-2 bg-light">
  <div class="card-body">
    <div class="row m-0">
      <?php
      if($search != ""){
        $query = "SELECT ID, nameGiven, nameFamily FROM members m WHERE m.nameGiven LIKE '%$search%' OR m.nameFamily LIKE '%$search%'";
        $result = mysqli_query($GLOBALS["db"], $query);
        while ($row = mysqli_fetch_array($result)) {
          echo "<a href='?s=2&p=".$row["ID"]."'><div class='card m-1'><div class='card-body'>".$row["nameFamily"].", ".$row["nameGiven"]."</div></div></a>";
        }
      }
      ?>
    </div>
  </div>
</div>
