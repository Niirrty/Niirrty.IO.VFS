<?php


$loader = include dirname( __DIR__ ) . '/vendor/autoload.php';

$loader->add( 'Niirrty\\IO\\Vfs\\Tests', __DIR__ );
$loader->register();
