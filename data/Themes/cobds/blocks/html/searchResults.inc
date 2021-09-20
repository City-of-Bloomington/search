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

if (isset($this->total)) {
    if ($this->total > 0) {
        echo "
        <div class=\"toolbar\">
            <span>Total Results: $this->total</span>
            <span>Sort: :)</span>
        </div>
        ";

        foreach ($this->results as $d) {
            $summary = $d['highlighting'] ?? $d['ss_summary'] ?? '';
            echo "
            <a class='result' title=\"$d[ss_title]\" href=\"$d[ss_url]\">
                <article>
                    <header>
                        <h1>$d[ss_title]</h1>
                        <span>$d[ss_url]</span>
                    </header>
                    <p>$summary</p>
                </article>
            </a>
            ";
        }

        if ($this->total > $this->itemsPerPage) {
            $this->paginator = new Paginator(
                $this->total,
                $this->itemsPerPage,
                $this->currentPage
            );
            $this->_include('pageNavigation.inc');
        }
    }
    else {
        echo '<p>No results found.</p>';
    }
}
