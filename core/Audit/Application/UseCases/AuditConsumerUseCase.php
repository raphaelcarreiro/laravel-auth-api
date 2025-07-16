<?php

namespace Core\Audit\Application\UseCases;

use Core\Audit\Application\Dto\AuditConsumerInput;
use Core\Audit\Domain\AuditEntity;
use Core\Audit\Domain\AuditId;
use Core\Audit\Infra\DB\AuditRepositoryInterface;
use Core\User\Domain\UserId;
use DateTime;
use Exception;

readonly class AuditConsumerUseCase
{
    public function __construct(
        private AuditRepositoryInterface $repository
    ) {}

    /**
     * @throws Exception
     */
    public function execute(AuditConsumerInput $input): void
    {
        var_dump($input);

        $audit = new AuditEntity(
            id: new AuditId($input->id),
            userId: new UserId($input->user_id),
            request: $input->request,
            response: $input->response,
            route: $input->route,
            routeName: $input->route_name,
            status: $input->status,
            createdAt: new DateTime($input->created_at),
            startedAt: new DateTime($input->started_at),
            finishedAt: new DateTime($input->finished_at),
            duration: $input->duration
        );

        $this->repository->save($audit);
    }
}
