<?php

namespace App\Exceptions;

use Exception;

class NotFoundException extends Exception { 
    const DESCRIPTION = "Not Found Exception (404)";
    
    public function __construct($details) {
        parent::__construct(self::DESCRIPTION.". ".$details);
    }
}
