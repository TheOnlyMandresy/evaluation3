<?php

namespace System\Controllers;

use System\Controller;

class ApiController extends Controller
{
    function __construct($page)
    {
        array_shift($page);
        var_dump($page);
    }
}