<link rel="stylesheet" href="../styles/main.css">
<style media="screen">
  tr,th,td{
    border: 1px solid #000;
  }
</style>
<?php
include "../config/dbconnect.php";
$query = "SELECT ID, Semester, SemesterBis FROM mo";
$result = mysqli_query($db, $query);
echo "<table><thead><tr><th>ID</th><th>Alt Von</th><th>Neu Von</th><th>Alt Bis</th><th>Neu Bis</th></thead><tbody>";
$vonneu = "";
$bisneu = "";
while ($row = mysqli_fetch_array($result)) {
  //CHECK VON
  if(substr($row["Semester"], 0, 2) === "SS"){
    $vonneu = substr($row["Semester"], -4)."-04-01";
  }elseif(substr($row["Semester"], 0, 2) == "WS"){
    if(substr($row["Semester"],-3,1) === "/" && strlen($row["Semester"]) === 10){ //WS 2000/01
      $vonneu = substr($row["Semester"], -7, 4)."-10-01";
    }elseif(substr($row["Semester"],-3,1) === "/" && strlen($row["Semester"]) === 8){ //WS 00/01
      $vonneu = "20".substr($row["Semester"], -5, 2)."-10-01";
    }elseif(strlen($row["Semester"]) === 7){ //WS 2000
      $vonneu = substr($row["Semester"], -4, 4)."-10-01";
    }else{
      $vonneu = "LOL";
    }
  }elseif(strlen($row["Semester"]) === 4 || strlen($row["Semester"]) === 5){ //2000
    $vonneu = substr($row["Semester"], -4,4)."-00-00";
  }elseif(empty($row["Semester"]) || $row["Semester"] === "" || $row["Semester"] === " "){
    $vonneu = "";
  }else{
    $vonneu = "! ! ! E R R O R ! ! ! (((".strlen($row["Semester"]).")))";
  }

  //CHECK BIS
  if(empty($row["SemesterBis"]) || $row["SemesterBis"] === "" || $row["SemesterBis"] === " "){
    $SemesterBis = $row["Semester"];
  }else{
    $SemesterBis = $row["SemesterBis"];
  }
  if(substr($SemesterBis, 0, 2) === "SS"){
    $bisneu = substr($SemesterBis, -4)."-09-30";
  }elseif(substr($SemesterBis, 0, 2) == "WS"){
    if(substr($SemesterBis,-3,1) === "/" && strlen($SemesterBis) === 10){ //WS 2000/01
      $bisneu = (substr($SemesterBis, -7, 4)+1)."-03-31";
    }elseif(substr($SemesterBis,-3,1) === "/" && strlen($SemesterBis) === 8){ //WS 00/01
      $bisneu = "20".(substr($SemesterBis, -5, 2)+1)."-03-31";
    }elseif(strlen($SemesterBis) === 7){ //WS 2000
      $bisneu = (substr($SemesterBis, -4, 4)+1)."-03-31";
    }else{
      $bisneu = "LOL";
    }
  }elseif(strlen($SemesterBis) === 4 || strlen($SemesterBis) === 5){ //2000
    $bisneu = substr($SemesterBis, -4,4)."-00-00";
  }elseif(empty($SemesterBis) || $SemesterBis === "" || $SemesterBis === " "){
    $bisneu = "";
  }else{
    $bisneu = "! ! ! LOL ! ! ! (((".strlen($SemesterBis).")))";
  }
  echo "<tr><td>".$row["ID"]."</td><td>".$row["Semester"]."</td>";
  echo "<td>$vonneu</td>";
  echo "<td>".$row["SemesterBis"]."</td>";
  echo "<td>$bisneu</td>";
  $query = "UPDATE mo SET `from` = '$vonneu', `to` = '$bisneu' WHERE ID = ".$row["ID"];
  if(mysqli_query($db, $query)){
    echo "<td style='background: #0f0;'></td>";
  }else{
    echo "<td style='background: #f00;'>$query;</td>";
  }
  $vonneu = "";
  $bisneu = "";
}
