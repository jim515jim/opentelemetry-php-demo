<?php

use OpenTelemetry\Contrib\Zipkin\Exporter as ZipkinExporter;
use OpenTelemetry\SDK\Common\Export\Http\PsrTransportFactory;
use OpenTelemetry\SDK\Trace\SpanProcessor\SimpleSpanProcessor;
use OpenTelemetry\SDK\Trace\TracerProvider;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Selective\BasePath\BasePathMiddleware;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

// Add Slim routing middleware
$app->addRoutingMiddleware();

// Set the base path to run the app in a subdirectory.
// This path is used in urlFor().
$app->add(new BasePathMiddleware($app));

$app->addErrorMiddleware(true, true, true);

/** routes start */
$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write('Hello, World!!!');
    return $response;
})->setName('root');

$app->get('/zipkin', function (Request $request, Response $response) {
    $transport = PsrTransportFactory::discover()->create('http://127.0.0.1:9411/api/v2/spans', 'application/json');
    $zipkinExporter = new ZipkinExporter($transport);
    $tracerProvider = new TracerProvider(
        new SimpleSpanProcessor($zipkinExporter)
    );
    $tracer = $tracerProvider->getTracer('io.opentelemetry.contrib.php');

    $root = $span = $tracer->spanBuilder('root')->startSpan();
    $scope = $span->activate();

    for ($i = 0; $i < 50; $i++) {
        // start a span, register some events
        $span = $tracer->spanBuilder('loop-' . $i)->startSpan();

        $span->setAttribute('remote_ip', '1.2.3.4')
            ->setAttribute('country', 'USA');

        $span->addEvent('found_login' . $i, [
            'id' => $i,
            'username' => 'otuser' . $i,
        ]);
        $span->addEvent('generated_session', [
            'id' => md5((string)microtime(true)),
        ]);

        $span->end();
    }
    $scope->detach();
    $root->end();

    $tracerProvider->shutdown();
    $response->getBody()->write('Starting Zipkin example');
    return $response;
});
/** routes end */

// Run app
$app->run();