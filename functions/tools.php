<?php
function debug($misc){
  return "<pre>".nl2br(print_r($misc))."</pre>";
}

function update($section, $values){
  $ID = $values["ID"];
  $update = "";
  foreach ($values as $key => $value) {
    if($key != "ID" && $key != "section" && isset($value) && $value != "" && $value != "0000-00-00"){
      $query = "UPDATE $section SET $key = '$value' WHERE ID = $ID";
      if(mysqli_query($GLOBALS["db"], $query)){
        $update .= "<div class='alert bg-primary'>".icon("success")." ".$GLOBALS["trans"][$section][$key]["title"]." ".$GLOBALS["trans"]["tools"]["update"]["setTo"]."  $value</div>";
      }else{
        $update .= "<div class='alert bg-secondary'>".icon("success")." ".$GLOBALS["trans"]["tools"]["update"]["failure"]."<br>$query</div>";
      }
    }
  }
  return $update;
}

function settings($values){
  $update = "";
  foreach ($values as $key => $value) {
    $query = "UPDATE settings SET value = '$value' WHERE setting = '$key'";
    if(mysqli_query($GLOBALS["db"], $query)){
      $update .= "<div class='alert bg-primary'>";
      $update .= icon("success")." ";
      $update .= $GLOBALS["trans"]["settings"][$key]["title"]." ";
      $update .= $GLOBALS["trans"]["tools"]["update"]["setTo"];
      $update .= "  $value</div>";
    }else{
      $update .= "<div class='alert bg-secondary'>".icon("failure")." ".$GLOBALS["trans"]["tools"]["update"]["failure"]."<br>$query</div>";
    }
  }
  return $update;
}

function add($section, $values){
  $update = "";
  foreach ($values as $key => $val) {
    if($key != "ID" && $key != "section" && isset($val) && $val != "" && $val != "0000-00-00"){
      if(empty($sqlfields)){$sqlfields = "`".$key."`";}else{$sqlfields .= ",`".$key."`";}
      if(empty($sqlvalues)){$sqlvalues = "'".$val."'";}else{$sqlvalues .= ",'".$val."'";}
    }
  }
  $query = "INSERT INTO $section ($sqlfields) VALUES ($sqlvalues)";
  if(mysqli_query($GLOBALS["db"], $query)){
    $update .= "<div class='alert bg-primary'>".icon("success")." $sqlfields $sqlvalues</div>";
  }else{
    $update .= "<div class='alert bg-secondary'>".icon("success")." ".$GLOBALS["trans"]["tools"]["add"]["failure"]."<br>$query</div>";
  }
  $ID = mysqli_fetch_array(mysqli_query($GLOBALS["db"], "SELECT ID FROM sections WHERE section = '".$section."'"))["ID"];
  $update .= "<nav class='navbar'><ul>";
  $update .= "<li><a href='?s=".$ID."&p=add'>".$GLOBALS["trans"][$section]["addMore"]["title"]."</a></li>";
  $update .= "<li><a href='?s=".$ID."&p=add'>".$GLOBALS["trans"]["gotoEntry"]."</a></li>";
  $update .= "</ul></nav>";
  return $update;
}
