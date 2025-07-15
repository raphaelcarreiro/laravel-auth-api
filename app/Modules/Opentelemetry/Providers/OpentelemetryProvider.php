<?php

namespace App\Modules\Opentelemetry\Providers;

use App\Modules\Opentelemetry\Listeners\OpentelemetryQueryListener;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use OpenTelemetry\API\Trace\TracerProviderInterface;
use OpenTelemetry\Contrib\Otlp\OtlpHttpTransportFactory;
use OpenTelemetry\Contrib\Otlp\SpanExporter;
use OpenTelemetry\SDK\Common\Attribute\Attributes;
use OpenTelemetry\SDK\Resource\ResourceInfo;
use OpenTelemetry\SDK\Resource\ResourceInfoFactory;
use OpenTelemetry\SDK\Trace\SpanProcessor\SimpleSpanProcessor;
use OpenTelemetry\SDK\Trace\TracerProvider;
use OpenTelemetry\SemConv\ResourceAttributes;

class OpentelemetryProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(TracerProviderInterface::class, function () {
            $endpoint = config('opentelemetry.tempo_url');

            $transport = (new OtlpHttpTransportFactory())->create($endpoint, 'application/json');

            $exporter = new SpanExporter($transport);

            $resource = ResourceInfoFactory::defaultResource()->merge(ResourceInfo::create(Attributes::create([
                ResourceAttributes::SERVICE_NAMESPACE => 'application',
                ResourceAttributes::SERVICE_NAME => config('app.name'),
                ResourceAttributes::SERVICE_INSTANCE_ID => '1',
                ResourceAttributes::SERVICE_VERSION => '0.1',
                'deployment.environment' => 'development',
            ])));

            return new TracerProvider(new SimpleSpanProcessor($exporter), resource: $resource);
        });
    }

    public function boot(): void
    {
        Event::listen(
            QueryExecuted::class,
            OpentelemetryQueryListener::class
        );
    }
}
