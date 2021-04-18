<?php

namespace Support\Contracts\Models;

interface LanguageToolkitContract
{
    public function highlight(string $filePath): object;

    public function compile(string $filePath): string;
}
