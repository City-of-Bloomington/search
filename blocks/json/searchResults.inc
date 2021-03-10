<?php
/**
 * @copyright 2021 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 * @param ResultInterface $this->result
 */
declare (strict_types=1);
echo $this->result ? json_encode($this->result->getData()) : '{}';
