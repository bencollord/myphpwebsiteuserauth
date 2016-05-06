<?php

$this->addStylesheet(ASSET_PATH . 'css/bootstrap.min.css');

$this->addScriptASSET_PATH . 'js/jquery.min.js')
     ->addScriptASSET_PATH . 'js/bootstrap.min.js');

?>

<!DOCTYPE html>

<html>
  <head>
    <title><?= $this->title; ?></title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php foreach ($this->metaTags as $name => $value): ?>
      <meta name="<?= $name; ?>" value="<?= $value; ?>" />
    <?php endforeach; ?>
    
    <?php foreach ($this->stylesheets as $stylesheet): ?>
      <link href="<?= $stylesheet; ?>" rel="stylesheet" type="text/css" />
    <?php endforeach; ?>
    
  </head>
  <body>
    
    <?php if ($header): ?>
      <header>
        <?= $header; ?>
      </header>
    <?php endif; ?>

    <?php if ($content): ?>
      <main>
        <?= $content; ?>
      </main>
    <?php endif; ?>

    <?php if ($footer): ?>
      <footer>
        <?= $footer; ?>
      </footer>
    <?php endif; ?>
    
    <?php foreach ($this->scripts as $script): ?>
      <script src="<?= $script; ?>" type="text/javascript"></script>
    <?php endforeach; ?>
    
  </body>
</html>