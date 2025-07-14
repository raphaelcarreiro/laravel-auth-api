<?php

namespace Core\Shared\Infra\Logger\Laravel;

use Core\Session\Infra\SessionTrait;
use Illuminate\Support\Facades\Request;
use Monolog\Formatter\JsonFormatter;
use Monolog\LogRecord;

class JsonLogger extends JsonFormatter
{
    use SessionTrait;

    public function format(LogRecord $record): string
    {
        $session = $this->session()->get();

        $custom = [
            'time'        => $record->datetime->format('Y-m-d H:i:s'),
            'application' => config('app.name'),
            'host'        => Request::server('SERVER_ADDR'),
            'level'       => $record->level->getName(),
            'message'     => $record->message,
            'user_id'     => $session->user?->id->getValue() ?? null,
            'audit_id'    => Request::get('audit_id'),
        ];

        if (isset($record->context['exception'])) {
            $custom['error_stack'] = [
                'message' => $record->context['exception']->getMessage(),
                'file'    => $record->context['exception']->getFile()
            ];
        }

        if (isset($record->context['extra'])) {
            $custom = [
                ...$custom,
                ...$record->context['extra']
            ];
        }

        return $this->toJson($this->normalize($custom), true) . ($this->appendNewline ? "\n" : '');
    }
}
