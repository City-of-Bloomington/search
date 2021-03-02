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
        parent::__construct();

        if ($res) {
            $h    = $res->getHighlighting();
            $docs = [];
            foreach ($res as $r) {
                $f                 = $r->getFields();
                $f['highlighting'] = self::getHighlighting($h, $r->id);
                $docs[]            = $f;
            }
            $vars = [
                'itemsPerPage' => $itemsPerPage,
                'currentPage'  => $currentPage,
                'total'        => $res->getNumFound(),
                'results'      => $docs
            ];
        }
        else { $vars = null; }

        $this->blocks = [ new Block('searchForm.inc', $vars) ];
    }

    private static function getHighlighting(Highlighting $highlighting, string $id): string
    {
        return $highlighting->getResult($id)->getField(Solr::DEFAULT_FIELD)[0] ?: '';
    }
}
