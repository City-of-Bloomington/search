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
        $label = _($k);

        echo "<details $openAttribute>
                <summary>$label</summary>
                <ul>";
                
        switch ($k) {
            case 'index_id':  ksort($facet); break;
            case 'its_year': krsort($facet); break;
            default:
        }
                
        foreach ($facet as $value => $count) {
            $url->$k = $value;
            $facetCountFormat = number_format($count, 0, '.', ',');

            echo "<li>
                    <a href=\"$url\">{$this->_($value)}
                        <span class='badge grey'>$facetCountFormat</span>
                    </a>
                  </li>";
        }

        echo "</ul></details>";
        ++$i;
    }
}
