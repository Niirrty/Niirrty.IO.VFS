<?php
/**
 * @author     Ni Irrty <niirrty+code@gmail.com>
 * @copyright  ©2017, Ni Irrty
 * @package    Niirrty\IO\Vfs
 * @since      2017-11-03
 * @version    0.2.1
 */

declare( strict_types=1 );


namespace Niirrty\IO\Vfs;


/**
 * The VFS handler manager.
 *
 * @package Niirrty\IO\Vfs
 */
class VfsManager implements IVfsManager
{


   // <editor-fold desc="// – – –   P R I V A T E   F I E L D S   – – – – – – – – – – – – – – – – – – – – – – – –">

   /**
    * @var \Niirrty\IO\Vfs\IVfsHandler[]
    */
   private $_handlers;

   // </editor-fold>


   // <editor-fold desc="// – – –   P U B L I C   C O N S T R U C T O R   – – – – – – – – – – – – – – – – – – – –">

   /**
    * Initialize a new \Niirrty\IO\Vfs\Manager instance.
    *
    * @param \Niirrty\IO\Vfs\IVfsHandler|null $firstHandler Optional First assigned VFS VfsHandler
    */
   public function __construct( ?IVfsHandler $firstHandler = null )
   {

      $this->_handlers = [];

      if ( null !== $firstHandler )
      {
         $this->addHandler( $firstHandler );
      }

   }

   // </editor-fold>


   // <editor-fold desc="// – – –   P U B L I C   M E T H O D S   – – – – – – – – – – – – – – – – – – – – – – – –">

   /**
    * Add/register one or more handlers.
    *
    * @param  \Niirrty\IO\Vfs\IVfsHandler[] $handlers
    * @return IVfsManager
    */
   public function addHandlers( array $handlers ) : IVfsManager
   {

      foreach ( $handlers as $handler )
      {
         if ( ! ( $handler instanceof VfsHandler ) ) { continue; }
         $this->_handlers[ $handler->getName() ] = $handler;
      }

      return $this;

   }

   /**
    * Add/register a handler.
    *
    * @param  \Niirrty\IO\Vfs\IVfsHandler $handler
    * @return IVfsManager
    */
   public function addHandler( IVfsHandler $handler ) : IVfsManager
   {

      $this->_handlers[ $handler->getName() ] = $handler;

      return $this;

   }

   /**
    * Gets the handler with defined name.
    *
    * @param  string $handlerName
    * @return \Niirrty\IO\Vfs\IVfsHandler|null
    */
   public function getHandler( string $handlerName ) : ?IVfsHandler
   {

      return isset( $this->_handlers[ $handlerName ] )
         ? $this->_handlers[ $handlerName ]
         : null;

   }

   /**
    * Get all handlers as associative array.
    *
    * Keys are the handler names, values are the VfsHandler instances.
    *
    * @return \Niirrty\IO\Vfs\IVfsHandler[]
    */
   public function getHandlers() : array
   {

      return $this->_handlers;

   }

   /**
    * Gets if the handler is defined.
    *
    * @param  \Niirrty\IO\Vfs\IVfsHandler|string $handler VfsHandler or handler name.
    * @return bool
    */
   public function hasHandler( $handler ) : bool
   {

      if ( $handler instanceof IVfsHandler )
      {
         return isset( $this->_handlers[ $handler->getName() ] );
      }

      if ( ! \is_string( $handler ) )
      {
         return false;
      }

      return isset( $this->_handlers[ $handler ] );

   }

   /**
    * Deletes all current defined handlers.
    */
   public function clearHandlers()
   {

      $this->_handlers = [];

   }

   /**
    * Gets the names of all defined handlers
    *
    * @return array
    */
   public function getHandlerNames() : array
   {

      return \array_keys( $this->_handlers );

   }

   /**
    * If a VFS handler matches the defined protocol, the $path is parsed (it means the protocol and known replacements
    * are replaces by associated path parts.
    *
    * @param  string $path
    * @param  array  $dynamicReplacements
    * @return string Returns the parsed path
    */
   public function parsePath( string $path, array $dynamicReplacements = [] ) : string
   {

      foreach ( $this->_handlers as $handler )
      {
         if ( $handler->tryParse( $path, $dynamicReplacements ) ) { break; }
      }

      return $path;

   }

   // </editor-fold>


   // <editor-fold desc="// – – –   P U B L I C   S T A T I C   M E T H O D S   – – – – – – – – – – – – – – – – –">

   /**
    * The static constructor for fluent usage.
    *
    * @return IVfsManager
    */
   public static function Create() : IVfsManager
   {

      return new self();

   }

   // </editor-fold>


}

