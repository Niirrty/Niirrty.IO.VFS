# Niirrty.IO.VFS

## Virtual file system

This small library gives you a simple virtual file system.


## Installation

inside the `composer.json`:

```json
{
    "require": {
        "php": ">=7.1",
        "niirrty/niirrty.io.vfs": "~0.3"
    }
}
```

## Usage

The usage is very simple.

```php
<?php
include \dirname( __DIR__ ) . '/vendor/autoload.php';

use \Niirrty\IO\Vfs\VfsManager;
use \Niirrty\IO\Vfs\VfsHandler;

$vfsManager = VfsManager::Create()
   ->addHandler(
      VfsHandler::Create( 'Test 1', 'foo', ':/', __DIR__ )
         ->addReplacement( 'myReplacement', 'Blub' )
   );


echo $vfsManager->parsePath( 'foo:/bar/bazz.txt' ), "\n";
echo $vfsManager->parsePath( 'foo:/${myDynamicPart}/bazz.txt', [ 'myDynamicReplacement' => 'abc/def' ] ), "\n";
echo $vfsManager->parsePath( 'foo:/Bar/Bazz/${myReplacement}.xml' );
```
