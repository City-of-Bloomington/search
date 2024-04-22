<?php
/**
 * @copyright 2024 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
$ROUTES = new Aura\Router\RouterContainer(BASE_URI);
$map    = $ROUTES->getMap();

$map->get('home.index', '/', Web\Search\SearchController::class);
