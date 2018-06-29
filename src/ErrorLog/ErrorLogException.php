<?php

namespace Yoon\Ico\Error; 

class ErrorLogException extends \Exception implements YoonException
{
    public $type;
    public $description;


    /**
     * Registeres a global exception handler for handling error log exceptions.
     *
     * @return void
     */
    public static function registerExceptionHandler() {
        $instance = get_called_class();
        @set_exception_handler(array($instance, 'exceptionHandler'));
    }

    /**
     * Handles error log exceptions.
     *
     * @param mixed $exception
     * @return void
     */
    public static function exceptionHandler($exception) {
        $repository = new ErrorLogRepository(new ErrorLogDatabase());
        if($exception instanceof ErrorLogException)
        {
            $repository->logError($exception->type, $exception->description);
        }
        else 
        {
            $repository->logError(ErrorLogType::Unexpected, $exception->getMessage());
        }
    }
      
	function __construct($type, $description) {
		$this->type = $type;
        $this->description = $description;
	}//__construct
}