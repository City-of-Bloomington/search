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

    foreach ($this->facets as $k=>$facet) {
        $url = clone($current_url);
        if ($url->$k) { unset($url->$k); }

        echo "<nav><header>";
            if ($k == 'index_id') { echo "Collection"; }
            else if ($k == 'ss_type') { echo "Type"; }
        echo "</header><ul>";

        foreach ($facet as $value => $count) {
            $url->$k = $value;
            echo "<li>
                  <a href=\"$url\">$value
                  <span class='badge primary'>$count</span>
                  </a>
                  </li>";
        }
        echo "</ul></nav>";
    }
}