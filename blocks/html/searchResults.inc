<?php
/**
 * @copyright 2021 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 * @param array $this->results
 */
declare (strict_types=1);
if ($this->results) {
    if ($this->results['total']) {
        foreach ($this->results['documents'] as $d) {
            $summary = $d['highlighting'] ?: ($d['ss_summary'] ?: '' );
            echo "
            <article>
                <header><h3><a href=\"$d[ss_url]\">$d[ss_title]</a></h3></header>
                <p>$summary</p>
            </article>
            ";
        }
    }
    else {
        echo '<p>No results found.</p>';
    }
}
