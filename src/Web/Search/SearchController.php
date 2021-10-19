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

        if (!empty($_GET['query'])) {
            $filters = [];
            foreach (Solr::$FACETS as $f) {
                if (!empty($_GET[$f])) { $filters[$f] = $_GET[$f]; }
            }

            $solr = $this->di->get('Web\Search\Solr');
            $res  = $solr->query($_GET['query'],
                                 self::ITEMS_PER_PAGE,
                                 $page,
                                 $filters);
        }
        else {
            $res = null;
        }

        return new SearchView($res, self::ITEMS_PER_PAGE, $page);
    }
}
