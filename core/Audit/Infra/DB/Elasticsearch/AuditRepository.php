<?php

namespace Core\Audit\Infra\DB\Elasticsearch;

use Core\Audit\Domain\AuditEntity;
use Core\Audit\Infra\DB\AuditRepositoryInterface;
use Core\Shared\Application\Exceptions\NotFoundException;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class AuditRepository extends ElasticsearchRepository implements AuditRepositoryInterface
{
    protected string $index;
    protected string $indexPattern;
    protected array $mapping;

    public function __construct(Client $client)
    {
        parent::__construct($client);

        $this->index = config('audit.index', 'authapi-audit');
        $this->mapping = require __DIR__ . '/mapping.php';
        $this->indexPattern = "{$this->index}-*";
    }

    protected function getIndex(): string
    {
        return $this->index;
    }

    protected function getIndexPattern(): string
    {
        return $this->indexPattern;
    }

    protected function getMapping(): array
    {
        return $this->mapping;
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws NotFoundException
     * @throws MissingParameterException
     */
    public function save(AuditEntity $audit): void
    {
        $this->findOrCreateTodayIndex();

        $document = AuditMapper::toDocument($audit);

        $this->client->index([
            'index' => $this->getTodayIndex(),
            'body' => $document,
        ]);
    }
}
