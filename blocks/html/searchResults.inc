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
        $current_url = new Url(Url::current_url(BASE_HOST));

        foreach ($this->results as $d) {
            $summary = $d['highlighting'] ?? $d['ss_summary'] ?? '';
            echo "
            <article>
                <header><h3><a href=\"$d[ss_url]\">$d[ss_title]</a></h3></header>
                <p>$summary</p>
            </article>
            ";
        }

        if ($this->total > $this->itemsPerPage) {
            $this->paginator = new Paginator(
                $this->total,
                $this->itemsPerPage,
                $this->currentPage + 1
            );
            $this->_include('pageNavigation.inc');
        }
    }
    else {
        echo sprintf($this->_('no_results', 'messages'), 'results');
    }
}
