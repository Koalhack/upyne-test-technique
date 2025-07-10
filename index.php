<?php

// ╭────────────────────────────────────────────────────────────────────────────────╮
// │   TODO: Replace hard value by constant                                         │
// │   TODO: Define return value for all methods                                    │
// │   TODO: Add better rooting                                                     │
// │   TODO: Add PHPDoc for certain variable                                        │
// │   TODO: Add interfaces for better respect of Dependency inversion principle    │
// ╰────────────────────────────────────────────────────────────────────────────────╯

// Register the Composer autoloader...
require __DIR__ . '/vendor/autoload.php';

use App\Controllers\UserController;

$controller = new UserController();
$controller->createUser();
