<?php

namespace Core\Audit\Infra\DB\Elasticsearch;

use Core\Shared\Application\Exceptions\NotFoundException;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

abstract class ElasticsearchRepository
{
    abstract protected function getIndex(): string;
    abstract protected function getIndexPattern(): string;
    abstract protected function getMapping(): array;

    public function __construct(protected Client $client)
    {
    }

    protected function getTodayIndex(): string
    {
        return $this->getIndex() . '-' . date('Y-m-d');
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws NotFoundException
     * @throws MissingParameterException
     */
    protected function checkTodayIndexExists(array $options = ['throwException' => false]): bool
    {
        $indexName = $this->getTodayIndex();

        $exists = $this->client->indices()->exists(['index' => $indexName]);

        if (!$exists && ($options['throwException'] ?? false)) {
            throw new NotFoundException('Index ' . $indexName . ' was not found.');
        }

        return true;
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws NotFoundException
     * @throws MissingParameterException
     */
    protected function findOrCreateTodayIndex(): void
    {
        if ($this->checkTodayIndexExists()) {
            return;
        }

        $this->client->indices()->create([
            'index' => $this->getTodayIndex(),
            'body' => [
                'mappings' => [
                    'properties' => $this->getMapping(),
                ],
            ],
        ]);
    }
}
