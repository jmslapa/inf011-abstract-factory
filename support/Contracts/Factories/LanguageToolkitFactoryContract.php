<?php

namespace Support\Contracts\Factories;

use Support\Contracts\Models\CompilerContract;
use Support\Contracts\Models\HighlighterContract;
use Support\Contracts\Models\LanguageToolkitContract;

interface LanguageToolkitFactoryContract
{
    public static function makeHighlighter() : HighlighterContract;
    
    public static function makeCompiler() : CompilerContract;

    public static function makeToolkit() : LanguageToolkitContract;
}