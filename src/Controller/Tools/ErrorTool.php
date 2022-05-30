<?php

namespace System\Tools;

/**
 * All systems errors
 * @param int $code
 */
class ErrorTool
{ 
    public static function error ($code)
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