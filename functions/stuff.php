<?php
function icon($icon){
  return icons($icon, 16);
}
function icons($icon, $size){
  if(isset($GLOBALS["icons"][$icon])){
    return "<clr-icon shape='".$GLOBALS["icons"][$icon]."' size='".$size."'></clr-icon>";
  }else{
    return "";
  }
}

function filter($ID){
  $fields ="";
  $query = "SELECT `table`, `field`, `check`, `value` FROM filter WHERE filter = ".$ID;
  $result = mysqli_query($GLOBALS["db"], $query);
  while($row = mysqli_fetch_array($result)){
    if($fields !== ""){
      $fields .= " AND ";
    }
    $fields .= $row["table"].".".$row["field"].' '.$row["check"].' '.$row["value"];
  }
  $query =
  "SELECT DISTINCT members.ID, salutation, nameGiven, nameFamily, suffix, address1, address2, postcode, place
   FROM members LEFT JOIN mt ON mt.member = members.ID
                LEFT JOIN membershipTypes ON membershipTypes.ID = mt.membershipType
                LEFT JOIN mo ON mo.member = members.ID
                LEFT JOIN offices ON offices.ID = mo.office
   WHERE $fields
   ORDER BY nameFamily ASC, nameGiven ASC
   LIMIT 0, ".$GLOBALS["settings"]["maxPerPage"];
  return $query;
}

function lighter($hex){
  $limit = 100;
  $hsl = hexToHsl(substr($hex, 1));
  return hslToHex(array($hsl[0], $hsl[1], growth(($hsl[2]*100), $limit, 1)/100));
}

function darker($hex){
  $limit = 100;
  $hsl = hexToHsl(substr($hex, 1));
  return hslToHex(array($hsl[0], $hsl[1], growth(($hsl[2]*100), $limit, -1)/100));
}

function growth($start, $limit, $generation){
  $rate = 0.01;
  return round(($start*$limit)/($start+($limit-$start)*exp((-$limit)*$rate*$generation)), 0);
}

function hexToHsl($hex) {
    $hex = array($hex[0].$hex[1], $hex[2].$hex[3], $hex[4].$hex[5]);
    $rgb = array_map(function($part) {
        return hexdec($part) / 255;
    }, $hex);

    $max = max($rgb);
    $min = min($rgb);

    $l = ($max + $min) / 2;

    if ($max == $min) {
        $h = $s = 0;
    } else {
        $diff = $max - $min;
        $s = $l > 0.5 ? $diff / (2 - $max - $min) : $diff / ($max + $min);

        switch($max) {
            case $rgb[0]:
                $h = ($rgb[1] - $rgb[2]) / $diff + ($rgb[1] < $rgb[2] ? 6 : 0);
                break;
            case $rgb[1]:
                $h = ($rgb[2] - $rgb[0]) / $diff + 2;
                break;
            case $rgb[2]:
                $h = ($rgb[0] - $rgb[1]) / $diff + 4;
                break;
        }

        $h /= 6;
    }

    return array($h, $s, $l);
}

function hslToHex($hsl)
{
    list($h, $s, $l) = $hsl;

    if ($s == 0) {
        $r = $g = $b = 1;
    } else {
        $q = $l < 0.5 ? $l * (1 + $s) : $l + $s - $l * $s;
        $p = 2 * $l - $q;

        $r = hue2rgb($p, $q, $h + 1/3);
        $g = hue2rgb($p, $q, $h);
        $b = hue2rgb($p, $q, $h - 1/3);
    }

    return rgb2hex($r) . rgb2hex($g) . rgb2hex($b);
}

function hue2rgb($p, $q, $t) {
    if ($t < 0) $t += 1;
    if ($t > 1) $t -= 1;
    if ($t < 1/6) return $p + ($q - $p) * 6 * $t;
    if ($t < 1/2) return $q;
    if ($t < 2/3) return $p + ($q - $p) * (2/3 - $t) * 6;

    return $p;
}

function rgb2hex($rgb) {
    return str_pad(dechex($rgb * 255), 2, '0', STR_PAD_LEFT);
}
