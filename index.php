<?php

// ╭────────────────────────────────────────────────────────────────────────────────╮
// │   TODO: Add PHPDoc to all classes                                              │
// │   TODO: Add PHPDoc to all methods                                              │
// │   TODO: Replace hard value by constant                                         │
// │   TODO: define return value for all methods                                    │
// │   TODO: add better rooting                                                     │
// ╰────────────────────────────────────────────────────────────────────────────────╯

// Register the Composer autoloader...
require __DIR__ . '/vendor/autoload.php';

use App\Controllers\UserController;

$controller = new UserController();
$controller->createUser();
