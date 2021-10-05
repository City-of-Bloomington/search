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
<section class="form-wrapper">
    <form method="get" autocomplete="off">
        <fieldset>
            <?php
                $h = $this->template->getHelper('field');
                echo $h->field([
                    'name'        => 'query',
                    'id'          => 'query',
                    'label'       => 'Search',
                    'placeholder' => 'Search',
                    'value'       => !empty($_GET['query']) ? parent::escape($_GET['query']) : '' 
                ]);
            ?>
            <button type="submit"><?= $this->_('search'); ?></button>
        </fieldset>
        <fieldset>
        <?php
            $currentUrl = new Url(Url::current_url(BASE_HOST));
            foreach ($_GET as $k=>$v) {
                if (in_array($k, Solr::$FACETS)) {
                    $url = clone($currentUrl);
                    unset($url->$k);
                    echo "<a href=\"$url\" class=\"badge primary delete\">$v</a>";
                }
            }
        ?>
        </fieldset>
    </form>
    <?php $this->_include('searchResults.inc'); ?>
</section>
