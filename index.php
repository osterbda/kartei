<!doctype html>
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
    <link rel="stylesheet" href="styles/bootstrap.css">
    <!--<link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/colors.css">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/debug.css">!-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title><?php echo $settings["appName"]; ?></title>
  </head>
  <body> <!-- style="overflow-x: hidden; overflow-y: scroll; min-height: 100%;" !-->
    <?php
    require("static/navbar.php");
    echo "<div class='row'>";
    echo "<div class='col-sm-2'>";
    require("static/sidebar.php");
    echo "</div><div class='col-sm-9'>";
    require("functions/pages.php");
    echo "</div><div class='col-sm-1'>";
    require("static/toolbar.php");
    echo "</div>";
    echo "</div>";
    require("static/footer.php");
    ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>
