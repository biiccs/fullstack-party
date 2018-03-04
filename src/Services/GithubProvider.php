<?php

namespace App\Services;

use Github\Client;
use Github\ResultPager;
use GuzzleHttp\Psr7\Uri;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class GithubProvider
 * @package App\Services
 */
class GithubProvider
{
    const STATE = 'state';

    const STATE_OPEN = 'open';
    const STATE_CLOSED = 'closed';

    const PAGE = 'page';
    const PER_PAGE = 'per_page';
    const DEFAULT_PAGE_SIZE = 30;

    const CREATOR = 'creator';
    const LABELS = 'labels';

    /**
     * @var Client
     */
    private $client;

    /**
     * @var ResultPager
     */
    private $pager;

    /**
     * GithubProvider constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->pager = new ResultPager($this->client);
    }


    /**
     * @param array $filter
     * @return array
     */
    public function getIssues(array $filter = [])
    {
        return $this->fetchIssues($filter);
    }

    /**
     * @param $id
     * @return array
     */
    public function getIssue($id)
    {
        return $this->client->issues()->show(
            'symfony',
            'symfony',
            $id
        );
    }

    /**
     * @param $id
     * @return array
     */
    public function getIssueComments($id)
    {
        return $this->client->issues()->comments()->all(
            'symfony',
            'symfony',
            $id
        );
    }

    /**
     * @param Request $request
     * @return array
     */
    public static function getIssuesFilter(Request $request)
    {
        $optionsResolver = new OptionsResolver();
        $optionsResolver
            ->setDefaults([
                self::STATE => self::STATE_OPEN,
                self::PAGE => 1,
                self::CREATOR => null,
                self::LABELS => null,
                self::PER_PAGE => null,
            ])
            ->setAllowedValues(self::STATE, [null, self::STATE_OPEN, self::STATE_CLOSED]);

        $parameters = $optionsResolver->resolve($request->query->all());
        $parameters = array_filter($parameters);

        return $parameters;
    }

    /**
     * @param array $filter
     * @param int $lastPage
     * @return int
     */
    protected function fetchLastPageCount(array $filter, int $lastPage)
    {
        $filter['page'] = $lastPage;
        $lastIssues = $this->fetchIssues($filter);
        $count = count($lastIssues);

        if ($lastPage > 1) {
            $count += ($lastPage - 1) * ($filter[self::PER_PAGE] ?? self::DEFAULT_PAGE_SIZE);
        }

        return (int)$count;
    }

    /**
     * @param $filter
     * @param int $lastPage
     * @param bool $countOpposite
     * @return array
     */
    public function totalCount($filter, int $lastPage, $countOpposite = true)
    {
        $count = $this->fetchLastPageCount($filter, $lastPage);

        $counter = [
            $filter[self::STATE] => $count,
        ];

        if ($countOpposite) {
            if (empty($filter[self::STATE]) || $filter[self::STATE] == self::STATE_OPEN) {
                $opposite = self::STATE_CLOSED;
            } else {
                $opposite = self::STATE_OPEN;
            }
            $filter[self::PAGE] = 1;
            $filter[self::STATE] = $opposite;

            $this->fetchIssues($filter);
            $pagination = $this->parsePagination($filter);

            $counter[$opposite] = $this->fetchLastPageCount($filter, $pagination['total']);
        }

        return $counter;
    }

    /**
     * @param array $filter
     * @return array
     */
    public function parsePagination(array $filter)
    {
        $pagination = $this->pager->getPagination();

        if ($pagination) {
            foreach ($pagination as $key => $val) {
                $uri = new Uri($val);
                $uri = URI::withoutQueryValue($uri, 'client_id');
                $uri = URI::withoutQueryValue($uri, 'client_secret');

                parse_str($uri->getQuery(), $query);

                $pagination[$key] = $query;
            }
        }

        return [
            'current' => $filter['page'] ?? 1,
            'total' => (int)($pagination['last']['page'] ?? $filter['page'] ?? 1),
            'pages' => $pagination
        ];
    }

    /**
     * @param array $filter
     * @return array|mixed
     */
    protected function fetchIssues(array $filter)
    {
        return $this->pager->fetch(
            $this->client->api('issues'),
            'all',
            [
                'symfony',
                'symfony',
                $filter
            ]
        );
    }
}