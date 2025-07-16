<?php

namespace Core\Audit\Application\UseCases;

use Core\Audit\Application\Dto\AuditInput;
use Core\Audit\Application\Dto\AuditOutput;
use Core\Audit\Application\Dto\UpdateAuditInput;
use Core\Audit\Domain\AuditEntity;
use Core\Audit\Domain\AuditStatusEnum;
use Core\User\Domain\UserEntity;

readonly class CreateAuditUseCase
{
    private AuditEntity $audit;

    public function execute(AuditInput $input): AuditEntity
    {
        $this->audit = AuditEntity::create([
            'user_id' => $input->user_id?->getValue() ?? null,
            'request' => $input->request,
            'route' => $input->route,
        ]);

        return $this->audit;
    }

    public function update(UpdateAuditInput $input): void
    {
        $user = UserEntity::fromArray($input->user);

        $auditStatus = $input->status_code >= 400 ? AuditStatusEnum::FAILED : AuditStatusEnum::SUCCESS;

        $this->audit->changeResponse($input->response);
        $this->audit->changeUserId($user->id);
        $this->audit->changeStatus($auditStatus);
        $this->audit->changeRouteName($input->route_name);
    }

    public function output(): AuditOutput
    {
        return new AuditOutput($this->audit->toArray());
    }
}
