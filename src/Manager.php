<?php
/**
 * @author     Ni Irrty <niirrty+code@gmail.com>
 * @copyright  ©2017, Ni Irrty
 * @package    Niirrty\IO\Vfs
 * @since      2017-11-03
 * @version    0.1.0
 */

declare( strict_types=1 );


namespace Niirrty\IO\Vfs;


class Manager
{


   // <editor-fold desc="// – – –   P R I V A T E   F I E L D S   – – – – – – – – – – – – – – – – – – – – – – – –">

   /**
    * @var \Niirrty\IO\Vfs\Handler[]
    */
   private $_handlers;

   // </editor-fold>


   // <editor-fold desc="// – – –   P U B L I C   C O N S T R U C T O R   – – – – – – – – – – – – – – – – – – – –">

   /**
    * Initialize a new \Niirrty\IO\Vfs\Manager instance.
    */
   public function __construct()
   {

      $this->_handlers = [];

   }

   // </editor-fold>


   // <editor-fold desc="// – – –   P U B L I C   M E T H O D S   – – – – – – – – – – – – – – – – – – – – – – – –">

   /**
    * Add/register one or more handlers.
    *
    * @param  \Niirrty\IO\Vfs\Handler[] $handlers
    * @return \Niirrty\IO\Vfs\Manager
    */
   public function addHandlers( array $handlers ) : Manager
   {

      foreach ( $handlers as $handler )
      {
         if ( ! ( $handler instanceof Handler ) ) { continue; }
         $this->_handlers[ $handler->getName() ] = $handler;
      }

      return $this;

   }

   /**
    * Add/register a handler.
    *
    * @param  \Niirrty\IO\Vfs\Handler $handler
    * @return \Niirrty\IO\Vfs\Manager
    */
   public function addHandler( Handler $handler ) : Manager
   {

      $this->_handlers[ $handler->getName() ] = $handler;

      return $this;

   }

   /**
    * Gets the handler with defined name.
    *
    * @param  string $handlerName
    * @return \Niirrty\IO\Vfs\Handler|null
    */
   public function getHandler( string $handlerName ) : ?Handler
   {

      return isset( $this->_handlers[ $handlerName ] )
         ? $this->_handlers[ $handlerName ]
         : null;

   }

   /**
    * Get all handlers as associative array.
    *
    * Keys are the handler names, values are the Handler instances.
    *
    * @return \Niirrty\IO\Vfs\Handler[]
    */
   public function getHandlers() : array
   {

      return $this->_handlers;

   }

   /**
    * Gets if the handler is defined.
    *
    * @param  \Niirrty\IO\Vfs\Handler|string $handler Handler or handler name.
    * @return bool
    */
   public function hasHandler( $handler ) : bool
   {

      if ( $handler instanceof Handler )
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
    * @return \Niirrty\IO\Vfs\Manager
    */
   public static function Create() : Manager
   {

      return new self();

   }

   // </editor-fold>


}

