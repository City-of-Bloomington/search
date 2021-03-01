<?php
/**
 * @copyright 2021 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
/**
 * Grab a timestamp for calculating process time
 */
declare (strict_types=1);
use Web\Authentication\Auth;
use Web\Views\NotFoundView;

$startTime = microtime(true);

include '../src/Web/bootstrap.php';

$p     = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$route = $ROUTES->match($p, $_SERVER);
if ($route) {
    if (isset($route->params['controller'])) {
        $class = $route->params['controller'];
        $c     = new $c($DI); // $DI - Dependency Inject set up in bootstrap
        $view  = is_callable($c) ? $c($route->params) : new NotFoundView();
    }
}
else {
    $view = new NotFoundView();
}

echo $view->render();

// Append some useful stats to the output of HTML pages
if ($view->outputFormat === 'html') {
    # Calculate the process time
    $endTime = microtime(true);
    $processTime = $endTime - $startTime;
    echo "<!-- Process Time: $processTime -->\n";

    $size   = ['B','kB','MB','GB','TB','PB','EB','ZB','YB'];
    $bytes  = memory_get_peak_usage();
    $factor = floor( (strlen("$bytes") - 1) / 3);
    $memory = sprintf("%.2f", $bytes / pow(1024, $factor)) . @$size[$factor];
    echo "<!-- Memory: $memory -->";
}
