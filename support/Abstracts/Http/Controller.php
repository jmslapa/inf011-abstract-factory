<?php

namespace Support\Abstracts\Http;

use Mf\Contracts\Http\ControllerContract;

abstract class Controller implements ControllerContract
{
	protected $view;

	public function __construct() {
		$this->boot();
	}

	protected function boot() : void
	{
		$this->view = new \stdClass();
	}

    public function render($view, $layout = null) : void {
		
		$this->view->page = str_replace('.', '/', $view);		

		if(is_null($layout) || !file_exists("../../../app/Views/layouts" . $layout .".phtml")) {
			require_once __DIR__."/../../../app/Views/layouts/default.phtml";
		} else {			
			require_once __DIR__."/../../../app/Views/layouts/" . $layout .".phtml";
		}
	}

	public function content() : void {
		require_once __DIR__."/../../../app/Views/".$this->view->page.".phtml";
	}

	public function script() : void {
		require_once __DIR__."/../../../app/Views/".$this->view->page.".js.phtml";
	}
}