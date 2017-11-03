# Niirrty.IO.VFS

## Virtual file system

This small library gives you a simple virtual file system.

## Usage

The usage is very simple.

```php
<?php
include \dirname( __DIR__ ) . '/vendor/autoload.php';

use \Niirrty\IO\Vfs\Manager as VfsManager;
use \Niirrty\IO\Vfs\Handler as VfsHandler;

$vfsManager = VfsManager::Create()
   ->addHandler(
      VfsHandler::Create( 'Test 1' )
         ->setProtocol( 'foo', ':/' )
         ->setRootFolder( __DIR__ )
         ->addReplacement( 'myReplacement', 'Blub' )
   );


echo $vfsManager->parsePath( 'foo:/bar/bazz.txt' ), "\n";
echo $vfsManager->parsePath( 'foo:/${myDynamicPart}/bazz.txt', [ 'myDynamicReplacement' => 'abc/def' ] ), "\n";
echo $vfsManager->parsePath( 'foo:/Bar/Bazz/${myReplacement}.xml' );
```
