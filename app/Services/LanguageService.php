<?php

namespace App\Services;

use OutOfBoundsException;
use Support\Contracts\Models\LanguageToolkitContract;
use Support\Contracts\Services\LanguageServiceContract;
use Support\Exceptions\MissingLanguageToolkitException;

class LanguageService implements LanguageServiceContract
{
    public function getLanguageToolKit(string $fileExtension): LanguageToolkitContract
    {
        try {
            return container("{$fileExtension}ToolkitFactory")->makeToolkit();
        } catch (OutOfBoundsException $e) {
            throw new MissingLanguageToolkitException('There is no language toolkit for this source code.');
        }
    }

    public function getSupportedLanguages(): array
    {
        return container('supportedLangs');
    }

    public function highlight(object $file): object
    {
        $ext = pathinfo($file->name, PATHINFO_EXTENSION);
        $toolkit = $this->getLanguageToolKit($ext);
        return $toolkit->highlight($file->tmp_name);
    }

    public function compile(string $fileName, string $fileContent): string
    {
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $toolkit = $this->getLanguageToolkit($ext);
        $filePath = src("storage/tmp/$fileName");

        file_put_contents($filePath, $fileContent);
        $binFile = $toolkit->compile($filePath);
        push_download(src('storage/tmp/'), [$filePath, $binFile]);

        unlink($filePath);
        unlink($binFile);
    }
}
