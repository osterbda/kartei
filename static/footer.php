<div class="footer bg-primary shadow">
  <nav class="navbar">
    <div>
      <?php echo $settings["orgName"]." :: ".$settings["appName"]; ?>
    </div>
    <div>
      <ul>
        <li><a href='?s=2&p=add'><?php echo $trans["members"]["add"]["title"]; ?></a></li>
        <li><a href="?lang=de">Deutsch</a></li>
        <li><a href="?lang=debug">Debug</a></li>
        <li><a href="?session=destroy"><?php echo $trans["logout"]; ?></a></li>
      </ul>
    </div>
  </nav>
</div>
