<?php

namespace Support\Contracts\Factories;

use Support\Contracts\Models\CompilerContract;
use Support\Contracts\Models\HighlighterContract;
use Support\Contracts\Models\LanguageToolkitContract;

interface LanguageToolkitFactoryContract
{
    public function makeHighlighter(): HighlighterContract;

    public function makeCompiler(): CompilerContract;

    public function makeToolkit(): LanguageToolkitContract;
}
