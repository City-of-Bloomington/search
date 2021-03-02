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

    public function query(string $search): ResultInterface
    {
        $search = self::cleanInput($search);
        $query  = $this->client->createSelect([
            'query'   => $search,
            'fields'  => 'id,site,index_id,ss_type,ss_url,ss_title,ss_summary,score',
            'start'   => 0,
            'rows'    => 10,
            'querydefaultfield' => self::DEFAULT_FIELD
        ]);
        $query->getHighlighting();
        return $this->client->execute($query);
    }

    private static function cleanInput(string $search): string
    {
        return str_replace(['"', "'"], '', $search);
    }
}
