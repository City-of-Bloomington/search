<?php
/**
 * @copyright 2021 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Web\Search;

use Solarium\Core\Query\Result\ResultInterface;
use Solarium\Component\Result\Highlighting\Highlighting;

use Web\Block;
use Web\Template;

class SearchView extends Template
{
    /**
     * @param int $currentPage   Current page number starting from 1
     */
    public function __construct(?ResultInterface $res=null,
                                int              $itemsPerPage,
                                int              $currentPage)
    {
        $format = !empty($_REQUEST['format']) ? $_REQUEST['format'] : 'html';
        parent::__construct('default', $format);

        $results = [];
        $facets  = [];

        if ($res) {
            // Add highlighting information to the search results
            foreach ($res as $r) {
                $fields                 = $r->getFields();
                $fields['highlighting'] = self::getHighlighting($res->getHighlighting(), $r->id);
                $results[]              = $fields;
            }

            // Filter out facets we do not want to display
            foreach ($res->getFacetSet() as $f => $facet) {
                foreach ($facet as $value => $count) {
                    // Only display if we have results for this value
                    if ((int)$count) { $facets[$f][$value] = $count; }
                }
            }
            $vars = [
                'itemsPerPage' => $itemsPerPage,
                'currentPage'  => $currentPage,
                'total'        => $res->getNumFound(),
                'results'      => $results
            ];
        }
        else { $vars = null; }

        if ($format == 'json') {
            $this->blocks = [ new Block('searchResults.inc', ['result' => $res]) ];
        }
        else {
            $this->blocks = [
                new Block('searchForm.inc', $vars),
                'sidebar' => [ new Block('facets.inc', ['facets' => $facets]) ],
                'panel-one' => [ new Block('facets.inc', ['facets' => $facets]) ]
            ];
        }
    }

    private static function getHighlighting(Highlighting $highlighting, string $id): string
    {
        return $highlighting->getResult($id)->getField(Solr::DEFAULT_FIELD)[0] ?: '';
    }
}
