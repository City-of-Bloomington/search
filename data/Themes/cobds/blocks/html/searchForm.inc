<?php
/**
 * @copyright 2021 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 * @param ResponseInterface $this->results
 */
declare (strict_types=1);
use Web\Url;
use Web\Search\Solr;
?>

<section class="results-wrapper">
  <form method="get" autocomplete="off">
    <fieldset>
        <?php
            $h = $this->template->getHelper('field');
            echo $h->field([
                'name'        => 'query',
                'id'          => 'query',
                'label'       => $this->_('search'),
                'placeholder' => $this->_('search'),
                'value'       => !empty($_GET['query']) ? parent::escape($_GET['query']) : ''
            ]);
        ?>
      <button type="submit"><?= $this->_('search'); ?></button>
    </fieldset>
  </form>
  <?php if ($this->results) { $this->_include('searchResults.inc'); } ?>
</section>
