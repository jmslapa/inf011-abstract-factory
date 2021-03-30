<?php

namespace App\Services;

use Support\Contracts\Models\LanguageToolkitContract;
use Support\Contracts\Services\LanguageServiceContract;
use Support\Exceptions\MissingLanguageToolkitException;

class LanguageService  implements LanguageServiceContract
{
    public function getLanguageToolKit(string $fileExtension): LanguageToolkitContract
    {
        $lang = ucfirst($fileExtension);
        $factoryClass = "\\Plugins\\Lang\\Toolkits\\$lang\\Factory\\LanguageToolkitFactory";

        if (!class_exists($factoryClass)) {
            throw new MissingLanguageToolkitException('There is no language toolkit to handle this source code.');
        }

        return $factoryClass::makeToolkit();
    }

    public function getSupportedLanguages(): array
    {
        $available = preg_grep('/^([^.])/', scandir(src('plugins/Lang/Toolkits')));
        return array_filter($available, fn($lang) => class_exists("\\Plugins\\Lang\\Toolkits\\$lang\\Factory\\LanguageToolkitFactory"));
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