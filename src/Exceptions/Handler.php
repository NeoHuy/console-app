<?php

namespace App\Console\Exceptions;

use Illuminate\Contracts\Debug\ExceptionHandler;

class Handler implements ExceptionHandler{

	public function report(Exception $e){}	

	public function render($request, Exception $e){}

	public function renderForConsole($output, Exception $e){}
}