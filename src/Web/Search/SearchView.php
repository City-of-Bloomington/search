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
    public function __construct(?ResultInterface $res=null)
    {
        parent::__construct();

        if ($res) {
            $highlighting = $res->getHighlighting();
            $results = [
                'total'     => $res->getNumFound(),
                'documents' => []
            ];
            foreach ($res as $r) {
                $fields = $r->getFields();
                $fields['highlighting'] = self::getHighlighting($highlighting, $r->id);
                $results['documents'][] = $fields;
            }
        }
        else {
            $results = [];
        }

        $this->blocks = [
            new Block('searchForm.inc', ['results' => $results])
        ];
    }

    private static function getHighlighting(Highlighting $highlighting, string $id): string
    {
        return $highlighting->getResult($id)->getField(Solr::DEFAULT_FIELD)[0] ?: '';
    }
}
