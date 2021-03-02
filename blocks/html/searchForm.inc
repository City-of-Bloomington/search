<?php
/**
 * @copyright 2021 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 * @param ResponseInterface $this->results
 */
declare (strict_types=1);
?>
<section>
    <header><h2>Search</h2></header>
    <form method="get">
        <fieldset>
        <?php
            $h = $this->template->getHelper('field');
            echo $h->field([
                'name'  => 'query',
                'id'    => 'query',
                'label' => 'Search',
                'value' => !empty($_GET['query']) ? parent::escape($_GET['query']) : ''
            ]);
        ?>
        </fieldset>
    </form>
    <?php
        $this->_include('searchResults.inc');
    ?>
</section>
