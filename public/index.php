<?php
session_start();

require_once '../vendor/autoload.php';
require_once '../src/System.php';

use System\Database\Tables\AdminTable;
AdminTable::isLogged();

// Initialization
new System();