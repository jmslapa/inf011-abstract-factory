<?php

namespace Plugins\Lang\Toolkits\Cpp\Factory;

use App\Models\Lang\Toolkits\LanguageToolkit;
use Support\Contracts\Models\CompilerContract;
use Support\Contracts\Models\HighlighterContract;
use Support\Contracts\Models\LanguageToolkitContract;
use Plugins\Lang\Toolkits\Cpp\Models\Compiler;
use Plugins\Lang\Toolkits\Cpp\Models\Highlighter;
use Support\Abstracts\Factory\AbstractLanguageToolkitFactory;

class LanguageToolkitFactory extends AbstractLanguageToolkitFactory
{
    public function makeHighlighter(): HighlighterContract
    {
        return new Highlighter;
    }

    public function makeCompiler(): CompilerContract
    {
        return new Compiler;
    }

    public function makeToolkit(): LanguageToolkitContract
    {
        return new LanguageToolkit($this->makeHighlighter(), $this->makeCompiler());
    }
}
