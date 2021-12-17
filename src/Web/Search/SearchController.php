<?php
/**
 * @copyright 2021 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Web\Search;

use Web\Controller;

class SearchController extends Controller
{
    public const ITEMS_PER_PAGE = 20;

    public function __invoke()
    {
		$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

        $filters = [];
        foreach (Solr::$FACETS as $f) {
            if (!empty($_GET[$f])) { $filters[$f] = $_GET[$f]; }
        }

        $query = empty($_GET['query']) ? '*' : preg_replace('/[^a-zA-Z0-9\s]/', ' ', $_GET['query']);
        $rows  = ($filters || !empty($_GET['query'])) ? self::ITEMS_PER_PAGE : 0;

        $solr  = $this->di->get('Web\Search\Solr');
        $res   = $solr->query($query, $rows, $page, $filters);

        return new SearchView($res, self::ITEMS_PER_PAGE, $page);
    }
}
