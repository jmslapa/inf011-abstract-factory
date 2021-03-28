<?php

namespace App\Http\Controllers;

use Support\Contracts\Models\LanguageToolkitContract;
use Support\Exceptions\MissingLanguageToolkitException;
use Support\Abstracts\Http\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $this->render('home.index');
    }

    public function highlight()
    {
        $file = (object) $_FILES['file'];
        $ext = pathinfo($file->name, PATHINFO_EXTENSION);       
        
       try {
            $toolkit = $this->getLanguageToolKit($ext);

            $this->view->fileName = $file->name;        
            $this->view->code = file_get_contents($file->tmp_name);            
            $this->view->highlighted = $toolkit->highlight($file->tmp_name);

        } catch(MissingLanguageToolkitException $e) {
            $this->setErrorMessages($e->getMessage());
        }
            
        $this->render('home.index');
    }

    public function compile()
    {
        ['fileName' => $file, 'code' => $code] = $_POST;
        $ext = pathinfo($file, PATHINFO_EXTENSION);      
        
        try {
            $toolkit = $this->getLanguageToolkit($ext); 
                       
            $fileContent = base64_decode($code);
            $fileName = src("storage/tmp/$file");

            file_put_contents($fileName, $fileContent);
            $binFile = $toolkit->compile($fileName);

            push_download(src('storage/tmp/'), [$fileName, $binFile]); 

            unlink($fileName);
            unlink($binFile);
            
        } catch(MissingLanguageToolkitException $e) {
            $this->setErrorMessages($e->getMessage());
        }
            
        $this->render('home.index');
    }

    protected function setErrorMessages(string $message, bool $showAvaliableExtensions = true) : void
    {
        $available = preg_grep('/^([^.])/', scandir(src('plugins/Lang/Toolkits')));
        $lastAvailable = strtolower(array_pop($available));
        $availableExtensions = array_reduce($available, fn($acc, $cur) => "$acc .".strtolower($cur).',', 'Available file extensions are') . " .$lastAvailable.";
        
        $this->view->error = $message;
        
        if($showAvaliableExtensions) {
            $this->view->errorComplement = $availableExtensions;
        }
    }

    protected function getLanguageToolkit(string $sourceCodeExtension) : LanguageToolkitContract
    {
        $lang = ucfirst($sourceCodeExtension);
        $factoryClass = "\\Plugins\\Lang\\Toolkits\\$lang\\Factory\\LanguageToolkitFactory";

        if(!class_exists($factoryClass)) {
            throw new MissingLanguageToolkitException('There is no language toolkit to handle this source code.');
        }

        return $factoryClass::makeToolkit();
    }
}
