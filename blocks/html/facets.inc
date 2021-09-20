<?php
/**
 * @copyright 2021 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 * @param array $this->facets
 */
declare (strict_types=1);
use Web\Url;

if ($this->facets) {
    $current_url = new Url(Url::current_url(BASE_HOST));

    foreach ($this->facets as $field=>$values) {
        $url = clone($current_url);
        if ($url->$field) { unset($url->$field); }

        echo "<nav><header>$field</header><ul>";
        foreach ($values as $value => $count) {
            $url->$field = $value;
            echo "<li><a href=\"$url\">$value: $count</a></li>";
        }
        echo "</ul></nav>";
    }
}
