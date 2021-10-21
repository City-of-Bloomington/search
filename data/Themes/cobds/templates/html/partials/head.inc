<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="manifest" href="<?= THEME; ?>/manifest.json" />
  <link rel="shortcut icon" href="<?= THEME; ?>/images/favicon/favicon.ico" />
  <?php
    $this->include('partials/stylesheets.inc');
    $this->addToAsset('scripts', BASE_URI.'/js/search-'.VERSION.'.js'); ?>

  <title>
    <?= isset($this->title) ? self::escape($this->title) : APPLICATION_NAME; ?>
    | City of Bloomington, Indiana
  </title>
  
  <script type="text/javascript">
    var BASE_URL = "<?= BASE_URL; ?>",
        BASE_URI = "<?= BASE_URI; ?>";
  </script>
</head>
