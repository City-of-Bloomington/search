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
    public const  DEFAULT_FIELD = 'tm_X3b_en_aggregated_field';
    public static $FACETS       = ['index_id', 'ss_type', 'ss_board', 'its_year'];
    public static $FIELDS = [
        'id', 'site', 'index_id', 'score',
        'ss_type', 'ss_board', 'ss_url', 'ss_title', 'ss_summary',
        'its_year', 'ds_date', 'ds_changed'
    ];

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
        $curl         = new Curl();
        $curl->setTimeout(10);
        $this->client = new Client($curl,
                                   new EventDispatcher(),
                                   ['endpoint'=>['solr'=>$config]]);
    }

    public function getClient(): Client { return $this->client; }

    public function query(string $search,
                             int $itemsPerPage,
                             int $currentPage, // Page number starting at 1
                          ?array $filters=null): ResultInterface
    {
        $query  = $this->client->createSelect();
        $dismax = $query->getEDisMax();

        $query->getHighlighting();

        $query->setQuery (self::cleanInput($search));
        $query->setFields(implode(',', self::$FIELDS));
        $query->setStart ($currentPage - 1); // Solr pagination starts at 0
        $query->setRows  ($itemsPerPage);

        $dismax->setQueryFields ('ss_title^2 ss_summary^2 tm_X3b_en_aggregated_field');
        $dismax->setPhraseFields('ss_title^4 ss_summary^3 tm_X3b_en_aggregated_field^2');
        $dismax->setPhraseSlop(3);
        // This filters out old documents from search results
        // It declares a curve from 1 to zero where it hits zero at $M.
        // So, documents older than $m will not show up in search results at all.
        // $a and $b control the shape of the curve.
        // Units are all in milliseconds
        $numYears = 1;
        $m = 3.16E-11 * $numYears;
        $a = 1; $b = 1;
        $dismax->setBoostFunctionsMult("recip(ms(NOW,ds_changed),$m,$a,$b)");
//         $dismax->setBoostFunctionsMult("if(eq(ss_type,'news'),0.1,1) recip(ms(NOW,ds_changed),1,1000,1000)");

        $facets = $query->getFacetSet();
        $facets->setMinCount(1);
        foreach (self::$FACETS as $f) {
            $facets->createFacetField($f)->setField($f);

            if (!empty($filters[$f])) {
                $query->createFilterQuery($f)
                      ->setQuery(sprintf('%s:"%s"', $f, self::cleanInput($filters[$f])));
            }
        }

        $req = $this->client->createRequest($query);
        error_log($req->getUri());
        return $this->client->execute($query);
    }

    private static function cleanInput(string $search): string
    {
        return str_replace(['"', "'"], '', $search);
    }
}
