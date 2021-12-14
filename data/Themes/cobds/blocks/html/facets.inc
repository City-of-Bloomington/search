<?php
/**
 * @copyright 2021 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 * @param array $this->facets
 */
declare (strict_types=1);
use Web\Url;

if ($this->facets) {
    $current_url   = new Url(Url::current_url(BASE_HOST));
    
    foreach ($this->facets as $k=>$facet) {
        $open  = '';
        $label = _($k);
        $url   = clone($current_url);
        if ($url->$k) { unset($url->$k); }

        switch ($k) {
            case 'index_id':  ksort($facet); $open='open'; break;
            case 'its_year': krsort($facet);               break;
            default:
        }
        
        echo "
        <details $open>
            <summary>$label</summary>
            <ul>
        ";
                
        foreach ($facet as $value => $count) {
            $url->$k = $value;
            $format  = number_format($count, 0, '.', ',');

            echo "
                <li>
                    <a href=\"$url\" title=\"{$this->_($value)}\">
                        <span>{$this->_($value)}</span>
                        <span class='badge grey'>$format</span>
                    </a>
                </li>
            ";
        }

        echo "
            </ul>
        </details>
        ";
    }
}
