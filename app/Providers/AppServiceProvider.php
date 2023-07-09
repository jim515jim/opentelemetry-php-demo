<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // log resolver
        $this->app->afterResolving('log', function (LogManager $log) {
            $processor = new class implements ProcessorInterface
            {
                public function __invoke(LogRecord $record)
                {
                    // TODO impletemet for get trace id from context
                    $record->extra['traceId'] = 'aaaa';
        
                    return $record;
                }
            };
        
            $log->pushProcessor($processor);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
