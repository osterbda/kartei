<link rel="stylesheet" href="../styles/main.css">
<style media="screen">
  tr,th,td{
    border: 1px solid #000;
  }
</style>
<?php
include "../config/dbconnect.php";
$query = "SELECT m.ID, nameFamily, nameGiven, rezdatum, burdatum, phildatum, vabandseit, m.status AS s, s.status FROM members m LEFT JOIN kartei.status s ON m.Status = s.ID ORDER BY nameFamily";
$result = mysqli_query($db, $query);
echo "<table><thead><tr><th>ID</th><th>Nname</th><th>Urfux</th><th>Urbursch</th><th>Urphilister</th><th>Va Band seit</th></tr></thead><tbody>";
while($row = mysqli_fetch_array($result)){
  echo "</tr><td>".$row["ID"]."</td><td>".$row["nameFamily"].",".$row["nameGiven"]." (".$row["status"].")"."</td>";
  if((int)$row["s"] === 1 || (int)$row["s"] === 2 || (int)$row["s"] === 5){ // Urvandalen und Urphilister
    if($row["rezdatum"] !== "0000-00-00"){
      $query2 = "INSERT INTO `mt`
                        (`member`, `membershiptype`, `date`)
                 VALUES (".$row["ID"].", 2, '".$row["rezdatum"]."')";
      if(mysqli_query($db, $query2)){
        "<td style='background: #0f0;>Fux</td>";
      }else{
        "<td style='background: #f00;>Fux</td>";
      }
    }
    if($row["burdatum"] !== "0000-00-00"){
      $query2 = "INSERT INTO `mt`
                        (`member`, `membershiptype`, `date`)
                 VALUES (".$row["ID"].", 4, '".$row["burdatum"]."')";
      if(mysqli_query($db, $query2)){
        "<td style='background: #0f0;>Fux</td>";
      }else{
        "<td style='background: #f00;>Fux</td>";
      }
    }
    if($row["phildatum"] !== "0000-00-00"){
      $query2 = "INSERT INTO `mt`
                        (`member`, `membershiptype`, `date`)
                 VALUES (".$row["ID"].", 5, '".$row["phildatum"]."')";
      if(mysqli_query($db, $query2)){
        "<td style='background: #0f0;>Fux</td>";
      }else{
        "<td style='background: #f00;>Fux</td>";
      }
    }
  }
  echo "</tr>";
}
echo "</tbody></table>";
