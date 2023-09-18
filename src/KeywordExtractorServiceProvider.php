<?php

namespace Wcg\KeywordExtractor;

use Illuminate\Support\ServiceProvider;

class KeywordExtractorServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {

        $this->publishes([
            __DIR__ . '/../config/keyword-extractor.php' => config_path('keyword-extractor.php'),
        ], 'keyword-extractor-config');
    }
}
