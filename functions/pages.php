<?php
if(empty($_GET["s"])){$s = 1;}else{$s = $_GET["s"];}
if(empty($_GET["p"])){$p = 0;}else{$p = $_GET["p"];}
if(empty($_GET["start"])){$start = 0;}else{$start = $_GET["start"];}

$query = "SELECT section, class FROM sections WHERE ID =".$s;
$result = mysqli_query($db, $query);
$row = mysqli_fetch_array($result);
$section = $row["section"];
$class = boolval($row["class"]);

echo "<div class='title'><h1>";
echo icons($row["section"], 42);
echo "</h1><h1>";
echo $trans[$row["section"]][$row["section"]]["title"];
echo "</h1></div>";
echo "<div class='pages'>";

if($class){
  if($p === 0){
    echo "<div>".t_overview($section, $start)."</div>";
  }elseif($p === "add"){
    echo "<div>";
    echo "<h2>".$GLOBALS["trans"][$section]["add"]["title"]."</h2>";
    echo t_details_full($section, "add")."</div>";
  }else{
    echo "<div class='two-columns'><h2>".$GLOBALS["trans"][$section][substr($section, 0, -1)]["title"]."</h2>";
    echo t_details_full($section, $p)."</div>";
    if($section === "members"){
      echo "<div><h2>".$GLOBALS["trans"]["membershipTypes"]["membershipTypes"]["title"]."</h2>".t_mt($p, $section);
      echo "<h2>".$GLOBALS["trans"]["offices"]["offices"]["title"]."</h2>".t_mo($p, $section);
      echo "<h2>".$GLOBALS["trans"]["offices"]["colleagues"]["title"]."</h2>".t_officecolleagues($p)."</div>";
    }elseif($section === "membershipTypes"){
      echo "<div><h2>".$GLOBALS["trans"]["members"]["members"]["title"]."</h2>".t_mt($p, $section)."</div>";
    }elseif($section === "offices"){
      echo "<div><h2>".$GLOBALS["trans"]["members"]["members"]["title"]."</h2>".t_mo($p, $section)."</div>";
    }elseif ($section === "filters") {
      echo "<div><h2>".$GLOBALS["trans"]["filters"]["conditions"]["title"]."</h2>".t_filter($p)."</div>";
      echo "<div class='three-columns'><h2>".$GLOBALS["trans"]["filters"]["preview"]["title"]."</h2>".t_filter_preview($p)."</div>";
    }
  }
}else{
  include 'static/'.$section.".php";
}

/*
if($section !== "tools" && $p === "add"){
  echo "<div>".t_details_full($section,$p)."</div>";
}elseif($section === "home"){
  include 'static/home.php';
}elseif($section === "members"){
  if($p === 0){
    echo "<div>".t_overview($section, "nameFamily")."</div>";
  }else{
    echo "<div class='two-columns three-rows'>".t_details_full($section, $p)."</div>";
    echo "<div class=''>".t_mt($p)."</div>";
    echo "<div class=''>".t_mo($p)."</div>";
  }
}elseif($section === "membershipTypes"){
  if($p === 0){
    echo "<div>".t_overview($section, "sort")."</div>";
  }else{
    echo "<div class='two-columns three-rows'>".t_details_full($section, $p)."</div>";
    echo "<div class=''>".t_tm($p)."</div>";
  }
}elseif($section === "offices"){
  if($p === 0){
    echo "<div>".t_overview($section, "sort")."</div>";
  }else{
    echo "<div class=''>".t_details_full($section, $p)."</div>";
  }
}elseif($section === "tools"){
  if($p === 0){
    include "static/tools.php";
  }elseif($p === "add"){
    echo "<div>".add($_POST["section"], $_POST)."</div>";
  }elseif($p === "update"){
    echo "<div>".update($_POST["section"], $_POST)."</div>";
  }elseif($p === "settings"){
    echo "<div>".settings($_POST)."</div>";
  }
}elseif($section === "settings"){
  echo "<div>".t_settings()."</div>";
}
*/

echo "</div>";
