<link rel="stylesheet" href="../styles/main.css">
<style media="screen">
  tr,th,td{
    border: 1px solid #000;
  }
</style>
<?php
include "../config/dbconnect.php";
$query = "SELECT m.ID, nameFamily, nameGiven, rezdatum, burdatum, phildatum, vabandseit, m.status AS s, s.status
          FROM members m LEFT JOIN kartei.status s ON m.Status = s.ID
          ORDER BY nameFamily";
$result = mysqli_query($db, $query);
echo "<table><thead><tr><th>ID</th><th>Nname</th><th>Status</th></tr></thead><tbody>";
while($row = mysqli_fetch_array($result)){
  $query2 = "";
  echo "<tr><td>".$row["ID"]."</td><td>".$row["nameFamily"].",".$row["nameGiven"]." (".$row["s"]." | ".$row["status"].")"."</td><td>";
  if((int)$row["s"] === 1 || (int)$row["s"] === 2 || (int)$row["s"] === 5){ // Urvandalen und Urphilister
    if($row["rezdatum"] !== "0000-00-00"){ // URFÜXE
      $query2 = "INSERT INTO `mt`
                        (`member`, `membershiptype`, `date`, `club`)
                 VALUES (".$row["ID"].", 2, '".$row["rezdatum"]."', 1)";
      $result2 = mysqli_query($db, $query2);
      echo "<span style='background: #ffaaaa;'>Urfux ($result2)</span>";
    }
    if($row["burdatum"] !== "0000-00-00"){ // URBURSCHEN
      $query2 = "INSERT INTO `mt`
                        (`member`, `membershiptype`, `date`, `club`)
                 VALUES (".$row["ID"].", 4, '".$row["burdatum"]."', 1)";
      $result2 = mysqli_query($db, $query2);
      echo "<span style='background: #ffccaa;'>Urbursch ($result2)</span>";
    }
    if($row["phildatum"] !== "0000-00-00"){ // URPHILISTER
      $query2 = "INSERT INTO `mt`
                        (`member`, `membershiptype`, `date`, `club`)
                 VALUES (".$row["ID"].", 5, '".$row["phildatum"]."', 1)";
      $result2 = mysqli_query($db, $query2);
      echo "<span style='background: #ffeeaa;'>Urphilister ($result2)</span>";
    }
  }else{
    if((int)$row["s"] === 4){ // ZMer
      $query2 = "INSERT INTO `mt`
                        (`member`, `membershiptype`, `date`)
                 VALUES (".$row["ID"].", 9, '".$row["phildatum"]."')";
      $result2 = mysqli_query($db, $query2);
      echo "<span style='background: #ffeeaa;'>ZM ($result2)</span>";
    }
    if((int)$row["s"] === 3){ // BANDINHABER
      $query2 = "INSERT INTO `mt`
                        (`member`, `membershiptype`, `date`)
                 VALUES (".$row["ID"].", 6, '".$row["phildatum"]."')";
      $result2 = mysqli_query($db, $query2);
      echo "<span style='background: #ffeeaa;'>Bandinhaber ($result2)</span>";
    }
    if((int)$row["s"] === 6){ // BANDPHILISTER
      if($row["phildatum"] !== $row["vabandseit"]){
        $query2 = "INSERT INTO `mt`
        (`member`, `membershiptype`, `date`)
        VALUES (".$row["ID"].", 7, '".$row["vabandseit"]."')";
        $result2 = mysqli_query($db, $query2);
        echo "<span style='background: #ffeeaa;'>Bandinhaber ($result2)</span>";

        $query2 = "INSERT INTO `mt`
        (`member`, `membershiptype`, `date`)
        VALUES (".$row["ID"].", 8, '".$row["phildatum"]."')";
        $result2 = mysqli_query($db, $query2);
        echo "<span style='background: #ffeeaa;'>Bandphilister ($result2)</span>";
      }else{
        $query2 = "INSERT INTO `mt`
        (`member`, `membershiptype`, `date`)
        VALUES (".$row["ID"].", 8, '".$row["phildatum"]."')";
        $result2 = mysqli_query($db, $query2);
        echo "<span style='background: #ffeeaa;'>Bandphilister ($result2)</span>";
      }
    }
  }
  echo "</td></tr>";
}
echo "</tbody></table>";
