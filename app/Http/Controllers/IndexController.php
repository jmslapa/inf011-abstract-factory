<?php

namespace App\Http\Controllers;

use App\Services\LanguageService;
use Support\Contracts\Models\LanguageToolkitContract;
use Support\Exceptions\MissingLanguageToolkitException;
use Support\Abstracts\Http\Controller;
use Support\Contracts\Services\LanguageServiceContract;

class IndexController extends Controller
{
    private LanguageServiceContract $service;

    public function __construct()
    {
        $this->service = new LanguageService;
    }

    public function index()
    {
        $this->render('home.index');
    }

    public function highlight()
    {
        $file = (object) $_FILES['file'];

        try {
            $this->view->fileName = $file->name;
            $this->view->code = file_get_contents($file->tmp_name);
            $this->view->highlighted = $this->service->highlight($file);
        } catch (MissingLanguageToolkitException $e) {
            $this->setErrorMessages($e->getMessage());
        }

        $this->render('home.index');
    }

    public function compile()
    {
        ['fileName' => $fileName, 'code' => $code] = $_POST;
        $fileContent = base64_decode($code);
        
        try {
            $this->service->compile($fileName, $fileContent);
        } catch (MissingLanguageToolkitException $e) {
            $this->setErrorMessages($e->getMessage());
        }

        $this->render('home.index');
    }

    protected function setErrorMessages(string $message, bool $showAvaliableLanguages = true): void
    {
        $available = $this->service->getSupportedLanguages();
        
        switch(count($available)) {
            case 0:
                $availableLanguages = "No language is supported.";
                break;
            case 1:
                $availableLanguages = "Only ".strtolower(array_shift($available))." is supported.";
                break;
            default:
                $firstAvailable = strtolower(array_shift($available));
                $lastAvailable = strtolower(array_pop($available));
                $availableLanguages = array_reduce($available, fn ($acc, $cur) => "$acc, ".strtolower($cur), "Available file extensions are $firstAvailable") . " and $lastAvailable.";              
        }

        $this->view->error = $message;

        if ($showAvaliableLanguages) {
            $this->view->errorComplement = $availableLanguages;
        }
    }
}
