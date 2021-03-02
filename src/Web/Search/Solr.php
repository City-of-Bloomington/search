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

    public function query(): ResultInterface
    {
        $query = $this->client->createQuery(Client::QUERY_SELECT);
        return   $this->client->execute($query);
    }
}
