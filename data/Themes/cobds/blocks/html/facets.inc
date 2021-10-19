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
    $i = 0;

    foreach ($this->facets as $k=>$facet) {
        $url = clone($current_url);
        if ($url->$k) { unset($url->$k); }

        $openAttribute = ($i == 0) ? 'open' : '';
        $label = $this->template::$FIELDS[$k] ?? $k;

        echo "<details $openAttribute>
                <summary>$label</summary>
                <ul>";

        foreach ($facet as $value => $count) {
            $url->$k = $value;
            $label   = $this->template::$VALUES[$value] ?? ucfirst((string)$value);
            $facetCountFormat = number_format($count, 0, '.', ',');

            echo "<li>
                    <a href=\"$url\">$label
                        <span class='badge grey'>$facetCountFormat</span>
                    </a>
                  </li>";
        }

        echo "</ul></details>";
        ++$i;
    }
}
