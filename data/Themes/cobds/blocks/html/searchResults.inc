<?php
/**
 * @copyright 2021 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 * @param int   $this->total
 * @param int   $this->itemsPerPage
 * @param int   $this->currentPage
 * @param array $this->results
 */
declare (strict_types=1);
use Web\Paginator;
use Web\Search\Solr;
use Web\Url;

if (isset($this->total)) {
    if ($this->total > 0) {

        $currentUrl = new Url(Url::current_url(BASE_HOST));
        $totalCountFormat = number_format($this->total, 0, '.', ',');

         echo "<div class=\"results\">";

        echo "<div class=\"toolbar\">
                <span>Total Results: $totalCountFormat</span>
                <span>Filtering By: &nbsp;";

        foreach ($_GET as $k=>$v) {
            if (in_array($k, Solr::$FACETS)) {
                $url = clone($currentUrl);
                unset($url->$k);
                echo "<a href=\"$url\"
                         class=\"badge neutral dissmissable\"
                         title=\"remove filter\">{$this->_($v)}</a>";
            }
        }

        echo "</span></div>";



        $current_url = new Url(Url::current_url(BASE_HOST));
        foreach ($this->results as $d) {
            $summary = $d['highlighting'] ?? $d['ss_summary'] ?? '';
            echo "
            <article class=\"result\">
                <header>
                    <h1>$d[ss_title]</h1>

                    <div class=\"meta\">
                        <span>
                            <strong>Origin Date:</strong>&nbsp;" . date_format (new DateTime($d['ds_date']), 'm-d-Y') . "
                        </span>

                        <span>
                            <strong>Last Change:</strong>&nbsp;" . date_format (new DateTime($d['ds_changed']), 'm-d-Y') . "
                        </span>
                    </div>

                    <a href=\"$d[ss_url]\" title=\"$d[ss_title]\">$d[ss_url]</a>
                </header>
                <p>$summary</p>
            </article>
            ";
        }
        echo "
        </div>
        ";

        if ($this->total > $this->itemsPerPage) {
            $this->paginator = new Paginator(
                $this->total,
                $this->itemsPerPage,
                $this->currentPage,
                5
            );
            $this->_include('pageNavigation.inc');
        }
    }
    else {
        echo sprintf($this->_('no_results', 'messages'), 'results');
    }
}
