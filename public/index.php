<?php
/**
 * @copyright 2021-2024 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
/**
 * Grab a timestamp for calculating process time
 */
declare (strict_types=1);

use GuzzleHttp\Psr7\ServerRequest;
use Web\Authentication\Auth;
use Web\Views\NotFoundView;

$startTime = microtime(true);

include '../src/Web/bootstrap.php';

$matcher = $ROUTES->getMatcher();
$route   = $matcher->match(GuzzleHttp\Psr7\ServerRequest::fromGlobals());

if ($route) {
    $controller = $route->handler;
    $c = new $controller($DI);
    if (is_callable($c)) {
        $view = $c($route->attributes);
    }
    else {
        $view = new \Web\Views\NotFoundView();
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
