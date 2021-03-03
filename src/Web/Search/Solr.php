<?php
/**
 * @copyright 2021 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Web\Search;

use Solarium\Core\Client\Adapter\Curl;
use Solarium\Client;
use Solarium\Core\Query\Result\ResultInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Solr
{
    public const DEFAULT_FIELD = 'tm_X3b_en_aggregated_field';
    public static $FACETS      = ['index_id', 'ss_type'];

    private $client;

    /**
     * @param array $config  Endpoint config for Solarium Client
     *  [
     *      'scheme'   => 'https',
     *      'host'     => 'localhost',
     *      'port'     => 443,
     *      'core'     => 'testcore',
     *      'username' => 'user',
     *      'password' => 'pass'
     *  ]
     */
    public function __construct(array $config)
    {
        $this->client = new Client(new Curl(),
                                   new EventDispatcher(),
                                   ['endpoint'=>['solr'=>$config]]);
    }

    public function getClient(): Client { return $this->client; }

    /**
     * @param string $search
     * @param int    $itemsPerPage
     * @param int    $currentPage   Current page number starting from 1
     * @param array  $filters
     */
    public function query(string $search,
                             int $itemsPerPage,
                             int $currentPage,
                          ?array $filters=null): ResultInterface
    {
        $search = self::cleanInput($search);
        $query  = $this->client->createSelect([
            'query'   => $search,
            'fields'  => 'id,site,index_id,ss_type,ss_url,ss_title,ss_summary,score',
            'start'   => $currentPage - 1, // Solr page numbers start at 0
            'rows'    => $itemsPerPage,
            'querydefaultfield' => self::DEFAULT_FIELD
        ]);
        $query->getHighlighting();

        $facets = $query->getFacetSet();
        foreach (self::$FACETS as $f) {
            $facets->createFacetField($f)->setField($f);

            if (!empty($filters[$f])) {
                $query->createFilterQuery($f)
                      ->setQuery("$f: ".self::cleanInput($filters[$f]));
            }
        }


        return $this->client->execute($query);
    }

    private static function cleanInput(string $search): string
    {
        return str_replace(['"', "'"], '', $search);
    }
}
