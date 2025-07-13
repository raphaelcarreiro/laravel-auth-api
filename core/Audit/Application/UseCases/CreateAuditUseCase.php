<?php

namespace Core\Audit\Application\UseCases;

use Core\Audit\Application\Dto\AuditInput;
use Core\Audit\Application\Dto\AuditOutput;
use Core\Audit\Domain\AuditEntity;

readonly class CreateAuditUseCase
{
    private AuditEntity $audit;

    public function execute(AuditInput $input): AuditEntity
    {
        $this->audit = AuditEntity::create([
            'id' => $input->userId?->getValue() ?? null,
            'request' => $input->request,
            'route' => $input->route,
        ]);

        return $this->audit;
    }

    public function update(string $output): void
    {
        $this->audit->changeResponse($output);
    }

    public function output(): AuditOutput
    {
        return new AuditOutput($this->audit->toArray());
    }
}
