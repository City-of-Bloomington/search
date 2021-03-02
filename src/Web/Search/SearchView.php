<?php
/**
 * @copyright 2021 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Web\Search;

use Solarium\Core\Query\Result\ResultInterface;

use Web\Block;
use Web\Template;

class SearchView extends Template
{
    public function __construct(ResultInterface $res)
    {
        parent::__construct();

        $this->blocks = [
            new Block('searchForm.inc', ['results' => $res])
        ];
    }
}
