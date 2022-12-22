<?php

namespace Leeroy\Search\MeiliSearch;

use MeiliSearch\Client;
use MeiliSearch\Endpoints\Indexes;
use SailCMS\Collection;
use SailCMS\Types\SearchResults;
use SailCMS\Search\Adapter as SearchAdapter;

class Adapter implements SearchAdapter
{
    private Client $client;
    private Indexes $index;

    public function __construct()
    {
        $url = $_ENV['MEILI_HOST'] . ':' . $_ENV['MEILI_PORT'];
        $mk = $_ENV['MEILI_MASTER_KEY'];
        $this->client = new Client($url, $mk);
        $this->index = $this->client->index($_ENV['MEILI_INDEX']);
    }

    /**
     *
     * Store a document in the search engine
     *
     * @param array|object $document
     * @param string $dataIndex
     * @return void
     *
     */
    public function store(array|object $document, string $dataIndex = '')
    {
        if ($document instanceof  Collection) {
            $document = $document->unwrap();
        } else {
            $document = (array)$document;
        }

        if (empty($dataIndex)) {
            $dataIndex = $_ENV['MEILI_INDEX'] ?? 'data';
        }

        // Add id to make better use of the add/replace feature
        if (!empty($document['_id'])) {
            $document['id'] = (string)$document['_id'];
        }

        $this->client->index($dataIndex)->addDocuments((array)$document);
    }

    /**
     *
     * Delete a document from the database
     *
     * @param  string  $id
     * @param  string  $dataIndex
     * @return void
     *
     */
    public function remove(string $id, string $dataIndex = '')
    {
        if (empty($dataIndex)) {
            $dataIndex = $_ENV['MEILI_INDEX'] ?? 'data';
        }

        $this->client->index($dataIndex)->deleteDocument($id);
    }

    /**
     *
     * Search Meili for given keywords
     *
     * @param string $search
     * @param array $meta
     * @param string $dataIndex
     * @return SearchResults
     *
     */
    public function search(string $search, array $meta = [], string $dataIndex = ''): SearchResults
    {
        if ($dataIndex === '') {
            $dataIndex = $_ENV['MEILI_INDEX'] ?? 'data';
        }

        // Set the index in which to search
        $this->index = $this->client->index($dataIndex);
        $results = $this->index->search($search, $meta);

        return new SearchResults($results->getHits(), $results->getHitsCount());
    }

    /**
     *
     * Update filterable attributes
     *
     * Note: Execute this using the "execute" method on the SailCMS\Search class.
     *
     * @param string $index
     * @param array $fields
     * @return bool
     *
     */
    public function updateFilterable(string $index, array $fields = []): bool
    {
        $this->client->index($index)->updateFilterableAttributes($fields);
        return true;
    }

    /**
     *
     * Update sortable attributes
     *
     * Note: Execute this using the "execute" method on the SailCMS\Search class
     *
     * @param string $index
     * @param array $fields
     * @return bool
     *
     */
    public function updateSortable(string $index, array $fields = []): bool
    {
        $this->client->index($index)->updateSortableAttributes($fields);
        return true;
    }

    /**
     *
     * Return the instance of MeiliSearch for more custom requirements
     *
     * @return Client
     *
     */
    public function getRawAdapter(): Client
    {
        return $this->client;
    }

    /**
     *
     * Add given mock data for testing or development
     *
     * @param array $list
     * @return void
     *
     */
    public function addMockData(array $list): void
    {
        $this->index->addDocuments($list);
    }
}