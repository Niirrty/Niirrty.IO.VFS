<?php
/**
 * @author         Ni Irrty <niirrty+code@gmail.com>
 * @copyright  (c) 2017, Ni Irrty
 * @license        MIT
 * @since          2018-04-03
 * @version        0.1.0
 */


namespace Niirrty\IO\Vfs\Tests;


use Niirrty\IO\Vfs\VfsHandler;
use Niirrty\IO\Vfs\IVfsManager;
use Niirrty\IO\Vfs\VfsManager;
use PHPUnit\Framework\TestCase;


class VfsManagerTest extends TestCase
{


    /**
     * @type IVfsManager
     */
    private $manager;

    public function setUp() : void
    {

        $this->manager = new VfsManager( VfsHandler::Create( 'MyVFS', 'my', '://', __DIR__ ) );

        parent::setUp();

    }

    public function testInit()
    {

        $this->assertInstanceOf( VfsHandler::class, $this->manager->getHandler( 'MyVFS' ) );

    }

    public function testAddHandlers()
    {

        $this->manager->addHandlers(
            [ new VfsHandler( 'TempVFS', 'tmp', '://', \dirname( __DIR__ ) ) ]
        );

        $this->assertInstanceOf( VfsHandler::class, $this->manager->getHandler( 'TempVFS' ) );

    }

    public function testAddHandler()
    {

        $this->manager->addHandler( new VfsHandler( 'xyz', 'xyz', '://', \dirname( \dirname( __DIR__ ) ) ) );

        $this->assertInstanceOf( VfsHandler::class, $this->manager->getHandler( 'xyz' ) );

    }

    public function testGetHandler()
    {

        $this->assertSame( null, $this->manager->getHandler( 'xyz' ) );

    }

    public function testGetHandlers()
    {

        $this->assertSame( 1, \count( $this->manager->getHandlers() ) );

    }

    public function testHasHandler()
    {

        $this->assertFalse( $this->manager->hasHandler( 'xyz' ) );
        $this->assertTrue( $this->manager->hasHandler( VfsHandler::Create( 'MyVFS', 'my', '://', __DIR__ ) ) );
        $this->assertFalse( $this->manager->hasHandler( 123 ) );

    }

    public function testClearHandlers()
    {

        $this->manager->clearHandlers();
        $this->assertSame( 0, \count( $this->manager->getHandlers() ) );

    }

    public function testGetHandlerNames()
    {

        $this->assertSame( [ 'MyVFS' ], $this->manager->getHandlerNames() );

    }

    public function testParsePath()
    {

        $this->assertSame( __DIR__ .  DIRECTORY_SEPARATOR . 'foo', $this->manager->parsePath( 'my://foo' ) );
        $this->assertSame( 'xyz://foo', $this->manager->parsePath( 'xyz://foo' ) );

    }

    public function testCreate()
    {

        $this->assertInstanceOf( VfsManager::class, VfsManager::Create() );

    }


}
