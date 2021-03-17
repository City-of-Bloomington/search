<?php
/**
 * @copyright 2021 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 * @param ResponseInterface $this->results */ declare (strict_types=1); ?>
<section class="form-wrapper">
  <form method="get" autocomplete="off">
    <fieldset>
      <?php
            $h = $this->template->getHelper('field'); echo $h->field([ 'name' =>
      'query', 'id' => 'query', 'label' => 'Search', 'placeholder' =>
      'Search','value' => !empty($_GET['query']) ?
      parent::escape($_GET['query']) : '' ]); ?>

      <!-- note: I'm sure how buttons get automagically done? -->
      <button type="submit"><?= $this->_('search'); ?></button>
    </fieldset>
  </form>
  <?php $this->_include('searchResults.inc'); ?>
</section>