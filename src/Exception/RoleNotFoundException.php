<?php

namespace App\Exception;

/**
 * Description of GroupNotFoundException
 *
 * @author xfarret
 */
class RoleNotFoundException extends \Exception {
    
    public function __construct($message, $code, $previous)
    {
        parent::__construct($message, $code, $previous);
    }
}