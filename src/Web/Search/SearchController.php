<?php
/**
 * @copyright 2021-2026 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Web\Search;

use Web\Controller;

class SearchController extends Controller
{
    public const ITEMS_PER_PAGE = 20;
    public const MAX_PAGE       = 1000;

    public function __invoke()
    {
        // Solr pages start at 0
		$page = !empty($_GET['page']) ? (int)$_GET['page'] - 1 : 0;
        if ($page > self::MAX_PAGE) { $page = 0; }

        $filters = self::filters($_GET);

        $query = empty($_GET['query']) ? '*' : preg_replace('/[^\w\x20]/', ' ', $_GET['query']);
        $rows  = ($filters || !empty($_GET['query'])) ? self::ITEMS_PER_PAGE : 0;

        $solr  = $this->di->get('Web\Search\Solr');
        $res   = $solr->query($query, $rows, $page, $filters);

        return new SearchView($res, self::ITEMS_PER_PAGE, $page);
    }

    private static function filters(array $get): array
    {
        $filters = [];
        foreach (Solr::$FACETS as $f) {
            if (!empty($_GET[$f])) {
                switch ($f) {
                    case 'its_year':
                        $filters['its_year'] = preg_replace('/[^\d]/', '', $_GET['its_year']);
                    break;

                    default:
                        $filters[$f] = preg_replace('/[^\w\x20]/', '', $_GET[$f]);
                }
            }
        }
        return $filters;
    }
}
