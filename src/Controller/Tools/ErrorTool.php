<?php

namespace System\Tools;

/**
 * All systems errors
 * @param int $code
 */
class ErrorTool
{ 
    function __construct ($code)
    {
        switch ($code)
        {
            case 404:
                return header('Location: /404');
            case 405:
                return header('Location: /405');
        }
    }
}