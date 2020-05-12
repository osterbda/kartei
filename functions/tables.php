<?php
function t_overview ($section) {
  $maxPerPage = (int)$GLOBALS["SETTINGS"]["maxPerPage"];
  if(empty($_GET["start"])){$start = 0;}else{$start = $_GET["start"]*$maxPerPage;}
  $table = "<table><thead><tr>";
  $query = "SHOW FULL COLUMNS FROM ".$section." WHERE Comment = 'Overview'";
  $result = mysqli_query($GLOBALS["db"], $query);
  $i = 1; $fields = "ID";
  while($row = mysqli_fetch_array($result)){
    $table .= "<th>".$GLOBALS["trans"][$section][$row["Field"]]["title"]."</th>";
    $fields .= ",".$row["Field"];
    $i++;
  }
  $table .= "<th>".$GLOBALS["trans"]["action"]."</th>";
  $table .= "</tr></thead><tbody>";
  $query = "SELECT ".$fields.", num
            FROM ".$section." LEFT JOIN (SELECT COUNT(ID) AS num FROM ".$section.") AS m ON 1=1";
  if($section === "members"){
    $query .= " ORDER BY nameFamily ASC";
  }
  $query .= " LIMIT ".$start.", ".$maxPerPage; //ORDER BY ".$sort." ASC
  //echo $query;
  $result = mysqli_query($GLOBALS["db"], $query);
  while ($row = mysqli_fetch_array($result)) {
    $table .= "<tr>";
    $num = $row["num"];
    //echo "<pre>";print_r($row);echo"</pre>";
    for ($j=1; $j < $i; $j++) {
      $table .= "<td>".$row[$j]."</td>";
    }
    $table .= "<td><a href='?s=".$_GET["s"]."&p=".$row["ID"]."'>".icon("details")." ".$GLOBALS["trans"]["details"]."</a></td>";
    $table .= "</tr>";
  }
  $table .= "</tbody></table>";
  $table .= "<nav class='navbar'><div><ul><li>".$GLOBALS["trans"]["page"]."</li>";
  for ($i = 0; $i < ($num / $maxPerPage); $i++) {
    $table .= "<li><a href='?s=".$_GET["s"]."&start=".$i."'>".($i+1)."</a></li>";
  }
  $table .= "</ul></div><div>".$num." ".$GLOBALS["trans"]["totalResults"]." | ";
  $table .= $GLOBALS["trans"]["settings"]["maxPerPage"]["title"]." ".$maxPerPage."</div></nav>";
  //echo "<pre>";print_r($r); echo "</pre>";
  return $table;
}

function t_details_full($section, $ID){
  $details = "<form method='post' action='?s=1000&p=";
  if($ID === "add"){ $details .= "add"; }else{ $details .= "update"; }
  $details .= "'><table><thead><tr><th>";
  $details .= $GLOBALS["trans"]["key"]."</th><th>".$GLOBALS["trans"]["value"]."</th></tr></thead><tbody>";
  $details .= "<input style='display:none' name='section' value='".$section."'>";
  if($ID !== "add"){
    $query = "SELECT * FROM ".$section." WHERE ID = ".$ID;
    $result = mysqli_query($GLOBALS["db"], $query);
    $row = mysqli_fetch_array($result);
  }
  $query = "SHOW COLUMNS FROM ".$section;
  $result = mysqli_query($GLOBALS["db"], $query);
  while($column = mysqli_fetch_array($result)){
      if($column["Field"] === "ID"){
        $details .= "<input style='display:none' name='ID' value='";
        if($ID !== "add"){$details .= $row["ID"];}
        $details .= "'>";
      }else{
        $details .= "<tr><th style='text-transform: capitalize'>";

        if(!empty($GLOBALS["trans"][$section][$column["Field"]]["title"])){
          $details .= $GLOBALS["trans"][$section][$column["Field"]]["title"];
        }else{
          $details .= "LOST IN TRANSLATION: ".$column["Field"];
        }

        $details .= "</th>";
        $details .= "<td><input name='".$column["Field"]."' value='";
        if($ID !== "add"){
          $details .= $row[$column["Field"]];
        }

        if(!empty($GLOBALS["trans"][$section][$column["Field"]]["title"])){
          $details .= "' placeholder = '".$GLOBALS["trans"][$section][$column["Field"]]["description"]."'></td></tr>";
        }else{
          $details .= "' placeholder = 'LOST IN TRANSLATION'></td></tr>";
        }
      }
  }
  $details .= "<tr><td colspan='2'><input type='submit' class='bg-primary' value='Speichern'></td></tr></tbody></table></form>";
  return $details;
}

function t_mt ($ID, $t1){
  $table = "<table><thead><tr><th>".$GLOBALS["trans"]["membershipTypes"]["date"]["title"]."</th>";
  if($t1 === "members"){
    $table .= "<th>".$GLOBALS["trans"]["membershipTypes"]["membershipType"]["title"]."</th>";
    $table .= "<th>".$GLOBALS["trans"]["membershipTypes"]["description"]["title"]."</th></tr></thead>";
    $query = "SELECT t.ID, t.membershiptype, t.description, DATE_FORMAT(mt.date, '%d.%m.%Y') AS d
              FROM membershiptypes t
                RIGHT JOIN mt ON t.ID = mt.membershiptype
                RIGHT JOIN members m ON mt.member = m.ID
              WHERE m.ID = $ID
              ORDER BY date ASC";
  }else {
    $table .= "<th>".$GLOBALS["trans"]["members"]["member"]["title"]."</th></tr></thead>";
    $query = "SELECT m.ID, CONCAT(prefix,' ',nameGiven,' ',nameFamily,', ',suffix) AS member, DATE_FORMAT(mt.date, '%d.%m.%Y') AS d
              FROM membershiptypes t
                LEFT JOIN mt ON t.ID = mt.membershiptype
                LEFT JOIN members m ON mt.member = m.ID
              WHERE t.ID = $ID
              ORDER BY date ASC";
  }
  $result = mysqli_query($GLOBALS["db"], $query);
  while($row = mysqli_fetch_array($result)){
    $table .= "<tr><td>".$row["d"]."</td><td>";
    if($t1 === "members"){
      $table .= "<a href='?s=4&p=".$row["ID"]."'>".$row["membershiptype"]."</a></td><td>".$row["description"]."</td></tr>";
    }else{
      $table .= "<a href='?s=2&p=".$row["ID"]."'>".$row["member"]."</a></td></tr>";
    }
  }
  $table .= "</tbody></table>";
  return $table;
}

function t_mo ($ID, $t1){
    $table = "<table><thead><tr><th>".$GLOBALS["trans"]["offices"]["from"]["title"]."</th>";
    $table .= "<th>".$GLOBALS["trans"]["offices"]["to"]["title"]."</th>";
    if($t1 === "members"){
      $table .= "<th>".$GLOBALS["trans"]["offices"]["office"]["title"]."</th></tr></thead>";
      $query = "SELECT o.ID, DATE_FORMAT(mo.from, '%d.%m.%Y') AS `from`, DATE_FORMAT(mo.to, '%d.%m.%Y') AS `to`, o.office
                FROM offices o
                  RIGHT JOIN mo ON o.ID = mo.office
                  RIGHT JOIN members m ON mo.member = m.ID
                WHERE m.ID = ".$ID."
                ORDER BY `from` ASC";
    }else{
      $table .= "<th>".$GLOBALS["trans"]["members"]["member"]["title"]."</th></tr></thead>";
      $query = "SELECT m.ID, DATE_FORMAT(mo.from, '%d.%m.%Y') AS `from`, DATE_FORMAT(mo.to, '%d.%m.%Y') AS `to`, CONCAT(salutation, ' ', title,' ',nameGiven,' ',nameFamily, ', ', suffix) AS member
                FROM offices o
                  LEFT JOIN mo ON o.ID = mo.office
                  LEFT JOIN members m ON mo.member = m.ID
                WHERE o.ID = ".$ID."
                ORDER BY `from` ASC";
    }
    //echo $query;
  $result = mysqli_query($GLOBALS["db"], $query);
  while($row = mysqli_fetch_array($result)){
    $table .= "<tr><td>".$row["from"]."</td><td>".$row["to"]."</td><td>";
    if($t1 === "members"){
      $table .= "<a href='?s=5&p=".$row["ID"]."'>".$row["office"]."</a>";
    }else{
      $table .= "<a href='?s=2&p=".$row["ID"]."'>".$row["member"]."</a>";
    }
  }
  $table .= "</td></tr>";
  $table .= "</tbody></table>";
  return $table;
}

function t_officecolleagues($ID){
  $query = "SELECT m2.ID AS mID, CONCAT(m2.nameGiven, ' ', m2.nameFamily) AS member, mo2.`from`, mo2.`to`, mo2.office AS oID, o.office AS office
            FROM members m1 LEFT JOIN mo mo1 ON m1.ID = mo1.member
            LEFT JOIN mo mo2 ON mo1.`from` between mo2.`from` and mo2.`to` OR mo2.`from` between mo1.`from` and mo1.`to`
            LEFT JOIN members m2 ON mo2.member = m2.ID
            LEFT JOIN offices o ON mo2.office = o.ID
            WHERE m1.ID = $ID AND m2.ID <> $ID
            ORDER BY mo2.`from` ASC, mo2.office ASC";
  $table = "<table><thead><tr><th>".$GLOBALS["trans"]["offices"]["from"]["title"]."</th>";
  $table .= "<th>".$GLOBALS["trans"]["offices"]["from"]["title"]."</th>";
  $table .= "<th>".$GLOBALS["trans"]["offices"]["to"]["title"]."</th>";
  $table .= "<th>".$GLOBALS["trans"]["offices"]["office"]["title"]."</th></tr></thead><tbody>";
  $result = mysqli_query($GLOBALS["db"], $query);
  while ($row = mysqli_fetch_array($result)) {
    $table .= "<tr><td><a href='?s=2&p=".$row["mID"]."'>".$row["member"]."</a></td>";
    $table .= "<td>".$row["from"]."</td><td>".$row["to"]."</td>";
    $table .= "<td><a href='?s=5&p=".$row["oID"]."'>".$row["office"]."</a></td></tr>";
  }
  $table .= "</tbody></table>";
  return $table;
}

function t_settings(){
  $details = "<form method='post' action='?s=1000&p=settings'><table><thead><tr><th>";
  $details .= $GLOBALS["trans"]["settings"]["setting"]["title"]."</th><th>".$GLOBALS["trans"]["settings"]["description"]["title"]."</th><th>".$GLOBALS["trans"]["settings"]["value"]["title"]."</th></tr></thead><tbody>";
  $query = "SELECT setting, value, valueType, min, max FROM settings ORDER BY sort ASC";
  $result = mysqli_query($GLOBALS["db"], $query);
  while($row = mysqli_fetch_array($result)){
    $details .= "<tr>";
    $details .= "<td>".$GLOBALS["trans"]["settings"][$row["setting"]]["title"]."</td>";
    $details .= "<td>".$GLOBALS["trans"]["settings"][$row["setting"]]["description"];
    if($row["valueType"] === "number" || $row["valueType"] === "range"){
      $details .= " (".$GLOBALS["trans"]["min"]." ".$row["min"]."; ".$GLOBALS["trans"]["max"]." ".$row["max"].")";
    }
    $details .= "</td>";
    $details .= "<td><input type='".$row["valueType"]."' ";
    if($row["valueType"] === "number" || $row["valueType"] === "range"){
      $details .= "min='".$row["min"]."' max='".$row["max"]."' ";
    }
    $details .="name='".$row["setting"]."' value='".$row["value"]."'></td>";
    "</tr>";
  }
  $details .= "<tr><td colspan='3'><input type='submit' class='bg-primary' value='Speichern'></td></tr></tbody></table></form>";
  return $details;
}

function t_filter($ID){
  $table  = "<table><thead>";
  $table .= "<th>TABLE</th>";
  $table .= "<th>FIELD</th>";
  $table .= "<th>CHECK</th>";
  $table .= "<th>VALUE</th>";
  $table .= "</thead><tbody>";
  $query = "SELECT `table`, `field`, `check`, `value` FROM filter WHERE filter = ".$ID;
  $result = mysqli_query($GLOBALS["db"], $query);
  while($row = mysqli_fetch_array($result)){
    $table .= "<tr><td>".$row["table"]."</td><td>".$row["field"]."</td><td>".$row["check"]."</td><td>".$row["value"]."</td></tr>";
  }
  $table .= "</tbody></table>";
  return $table;
}

function t_filter_preview($ID){
  $table  = "<table><thead><tr><th>".$GLOBALS["trans"]["members"]["salutation"]["title"]."</th>";
  $table .= "<th>".$GLOBALS["trans"]["members"]["nameGiven"]["title"]."</th>";
  $table .= "<th>".$GLOBALS["trans"]["members"]["nameFamily"]["title"]."</th>";
  $table .= "<th>".$GLOBALS["trans"]["members"]["suffix"]["title"]."</th>";
  $table .= "<th>".$GLOBALS["trans"]["members"]["address1"]["title"]."</th>";
  $table .= "<th>".$GLOBALS["trans"]["members"]["address2"]["title"]."</th>";
  $table .= "<th>".$GLOBALS["trans"]["members"]["postcode"]["title"]."</th>";
  $table .= "<th>".$GLOBALS["trans"]["members"]["place"]["title"]."</th>";
  $table .= "</tr></thead><tbody>";
  $query = filter($ID);
  echo $query;
  $result = mysqli_query($GLOBALS["db"], $query);
  if(!$result){
    $table .= "<tr><td colspan='8'>".$query."</td></tr>";
  }else{
    while ($row = mysqli_fetch_array($result)) {
      $table .= "<tr>";
      $table .= "<td>".$row["salutation"]."</td>";
      $table .= "<td>".$row["nameGiven"]."</td>";
      $table .= "<td>".$row["nameFamily"]."</td>";
      $table .= "<td>".$row["suffix"]."</td>";
      $table .= "<td>".$row["address1"]."</td>";
      $table .= "<td>".$row["address2"]."</td>";
      $table .= "<td>".$row["postcode"]."</td>";
      $table .= "<td>".$row["place"]."</td>";
      $table .= "</tr>";
    }
  }
  $table .= "</tbody></table>";
  return $table;
}
?>