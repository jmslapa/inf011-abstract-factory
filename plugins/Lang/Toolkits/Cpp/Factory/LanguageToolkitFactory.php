<?php

namespace Plugins\Lang\Toolkits\Cpp\Factory;

use App\Models\Lang\Toolkits\LanguageToolkit;
use Support\Contracts\Factories\LanguageToolkitFactoryContract;
use Support\Contracts\Models\CompilerContract;
use Support\Contracts\Models\HighlighterContract;
use Support\Contracts\Models\LanguageToolkitContract;
use Plugins\Lang\Toolkits\Cpp\Models\Compiler;
use Plugins\Lang\Toolkits\Cpp\Models\Highlighter;

class LanguageToolkitFactory implements LanguageToolkitFactoryContract
{
    public static function makeHighlighter(): HighlighterContract
    {
        return new Highlighter;
    }

    public static function makeCompiler(): CompilerContract
    {
        return new Compiler;
    }

    public static function makeToolkit(): LanguageToolkitContract
    {
        return new LanguageToolkit(self::makeHighlighter(), self::makeCompiler());
    }
}