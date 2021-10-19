<!DOCTYPE html>
<?php $lang = strtolower(substr(LOCALE, 0, 2)); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= $lang; ?>">
  <?php $this->_include('partials/head.inc'); ?>
  <body>
    <?php $this->_include('partials/header.inc'); ?>
    <main>
      <?php $this->_include('errorMessages.inc'); ?>

      <div class="content">
        <?php
            $this->_include('partials/panel-one.inc'); echo
        $this->includeBlocks(); ?>
      </div>
    </main>
    <?php $this->_include('partials/footer.inc'); ?>
  </body>
</html>
<?php $this->_include('partials/garbageCollection.inc'); ?>
