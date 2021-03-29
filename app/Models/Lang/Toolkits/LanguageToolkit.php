<?php

namespace App\Models\Lang\Toolkits;

use Support\Contracts\Models\CompilerContract;
use Support\Contracts\Models\HighlighterContract;
use Support\Contracts\Models\LanguageToolkitContract;

class LanguageToolkit implements LanguageToolkitContract
{
    private HighlighterContract $highlighter;
    private CompilerContract $compiler;

    public function __construct(HighlighterContract $highlighter, CompilerContract $compiler)
    {
        $this->highlighter = $highlighter;
        $this->compiler = $compiler;
    }

    public function highlight(string $filePath): object
    {
        return $this->highlighter->highlight($filePath);
    }

    public function compile(string $filePath): string
    {
        return $this->compiler->compile($filePath);
    }
}
