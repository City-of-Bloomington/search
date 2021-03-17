<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="manifest" href="<?= THEME; ?>/manifest.json" />
  <?php
    $this->
  _include('partials/stylesheets.inc'); $this->addToAsset('scripts',
  BASE_URI.'/js/search-'.VERSION.'.js'); ?>

  <title>
    <?= isset($this->title) ? self::escape($this->title) : APPLICATION_NAME; ?>
  </title>
  <link rel="icon" type="image/x-icon" href="<?= THEME; ?>/images/icon.png" />
  <script type="text/javascript">
    var BASE_URL = "<?= BASE_URL; ?>",
      BASE_URI = "<?= BASE_URI; ?>";
  </script>
</head>
