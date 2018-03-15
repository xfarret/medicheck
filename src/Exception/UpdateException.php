<?php

namespace App\Exception;

/**
 * Description of UpdateException
 *
 * @author xfarret
 */
class UpdateException extends \Exception {
    
    public function __construct($message, $code, $previous)
    {
        parent::__construct($message, $code, $previous);
    }
}