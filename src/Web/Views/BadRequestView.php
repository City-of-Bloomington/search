<?php
/**
 * @copyright 2026 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Web\Views;

use Web\Block;
use Web\Template;

class BadRequestView extends Template
{
    public function __construct(?array $vars=null)
    {
        header('HTTP/1.1 400 Bad Request', true, 400);
        parent::__construct('default', 'html', $vars);
        $this->blocks[] = new Block('400.inc');
    }
}
