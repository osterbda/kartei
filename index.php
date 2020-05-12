<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <!--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">!..>
    <!--CLARITY ICONS STYLE-->
    <link rel="stylesheet" href="styles/@clr/icons/clr-icons.min.css">
    <!--CLARITY ICONS DEPENDENCY: CUSTOM ELEMENTS POLYFILL-->
    <script src="styles/@webcomponents/custom-elements/custom-elements.min.js"></script>
    <!--CLARITY ICONS API & ALL ICON SETS-->
    <script src="styles/@clr/icons/clr-icons.min.js"></script>

    <?php
    session_start();
    if(!empty($_GET["session"]) && $_GET["session"] == "destroy"){
      $_SESSION = array("0" => "");
      session_destroy();
      session_start();
    }
    if(!empty($_GET["lang"])){
      $_SESSION["lang"] = $_GET["lang"];
    }
    if(empty($_SESSION["lang"])){
      $_SESSION["lang"] = "de";
    }

    $trans = json_decode(file_get_contents("translations/".$_SESSION["lang"].".json"), TRUE);
    if($icons = json_decode(file_get_contents("styles/icons.json"), TRUE)){
      ?><?php
    }else{
      ?><script>console.log("<?php echo "Fehler"; ?>");</script><?php
    }

    require("config/dbconnect.php");
    require("functions/tables.php");
    require("functions/tools.php");
    require("functions/stuff.php");

    /* GET SETTINGS FROM DB */
    $SETTINGS = array();
    $query = "SELECT setting, value FROM settings";
    $result = mysqli_query($db, $query);
    while($row = mysqli_fetch_array($result)){
      $SETTINGS[$row["setting"]] = $row["value"];
    }
    $settings = $SETTINGS;
    ?>
    <style>
    :root{
      --primary:         <?php echo $settings["primary"]; ?>; /*#4b7bec;*/
      --primary-light:   #<?php echo lighter($settings["primary"]); ?>;
      --primary-dark:    #<?php echo darker($settings["primary"]); ?>;

      --secondary:       <?php echo $settings["secondary"]; ?>; /*#4b7bec;*/
      --secondary-light: #<?php echo lighter($settings["secondary"]); ?>;
      --secondary-dark:  #<?php echo darker($settings["secondary"]); ?>;
    }
    </style>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/colors.css">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/debug.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title><?php echo $settings["appName"]; ?></title>
  </head>
  <body id="body">
    <?php
    echo "<div class='main' style=''>";
    require("static/navbar.php");
    require("static/sidebar.php");
    require("functions/pages.php");
    require("static/toolbar.php");
    require("static/footer.php");
    echo "</div>"
    ?>
  </body>
</html>
