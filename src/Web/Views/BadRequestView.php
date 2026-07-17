<?php
/**
 * @copyright 2026 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Web\Views;

use Web\View;

class BadRequestView extends View
{
    public function __construct()
    {
        header('HTTP/1.1 400 Bad Request', true, 400);
        parent::__construct('default', 'html', $vars);
        $this->blocks[] = new Block('400.inc');
    }
}
