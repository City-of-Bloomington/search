<?php
/**
 * @copyright 2021 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
?>
<form method="get">
    <fieldset>
    <?php
        $h = $this->template->getHelper('field');
        echo $h->field([
            'name'  => 'query',
            'id'    => 'query',
            'label' => $this->_('search'),
            'value' => !empty($_GET['query']) ? parent::escape($_GET['query']) : ''
        ]);
    ?>
    </fieldset>
</form>
