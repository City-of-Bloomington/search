<!DOCTYPE html>
<?php $lang = strtolower(substr(LOCALE, 0, 2)); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= $lang; ?>">
<?php $this->_include('partials/head.inc'); ?>
<body class="two-column">
    <?php $this->_include('partials/header.inc'); ?>
    <main>
        <div id="content-panel" class="panel">
        <?php
            $this->_include('errorMessages.inc');
            echo $this->includeBlocks();
        ?>
        </div>
        <?php $this->_include('partials/panel-one.inc'); ?>
    </main>
<?php $this->_include('partials/footer.inc'); ?>
</body>
</html>
<?php $this->_include('partials/garbageCollection.inc'); ?>
