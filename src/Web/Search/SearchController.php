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
    public function __invoke()
    {
        if (!empty($_GET['query'])) {
            $solr = $this->di->get('Web\Search\Solr');
            $res  = $solr->query($_GET['query']);
        }
        else {
            $res = null;
        }

        return new SearchView($res);
    }
}
