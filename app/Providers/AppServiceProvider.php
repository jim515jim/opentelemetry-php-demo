<?php

namespace App\Providers;

use Illuminate\Log\LogManager;
use Illuminate\Support\ServiceProvider;
use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;

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
                    $record->extra['traceId'] = 'aaaaa';
        
                    return $record;
                }
            };
        
            $log->pushProcessor($processor);
        });
        
        $this->app->forgetInstance('log');
        \Log::clearResolvedInstance('log');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
