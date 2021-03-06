<?php
/**
 * @copyright 2021 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
use Aura\Di\ContainerBuilder;

$builder = new ContainerBuilder();
$DI = $builder->newInstance();

$DI->params ['Web\Search\Solr']['config'] = $SOLR['solr'];
$DI->set    ('Web\Search\Solr',
$DI->lazyNew('Web\Search\Solr'));
