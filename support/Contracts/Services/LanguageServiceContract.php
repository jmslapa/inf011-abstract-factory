<?php

namespace Support\Contracts\Services;

use Support\Contracts\Models\LanguageToolkitContract;

interface LanguageServiceContract
{
    public function getLanguageToolKit(string $language): LanguageToolkitContract;

    public function getSupportedLanguages(): array;

    public function highlight(object $file): object;

    public function compile(string $fileName, string $fileContent): string;
}
