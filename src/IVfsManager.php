<?php
/**
 * @author         Ni Irrty <niirrty+code@gmail.com>
 * @copyright  (c) 2017, Ni Irrty
 * @license        MIT
 * @since          2018-04-05
 * @version        0.2.1
 */


namespace Niirrty\IO\Vfs;


/**
 * The VFS handler manager interface.
 *
 * @package Niirrty\IO\Vfs
 */
interface IVfsManager
{


   /**
    * Add/register one or more handlers.
    *
    * @param  \Niirrty\IO\Vfs\IVfsHandler[] $handlers
    * @return IVfsManager
    */
   public function addHandlers( array $handlers );

   /**
    * Add/register a handler.
    *
    * @param  \Niirrty\IO\Vfs\IVfsHandler $handler
    * @return IVfsManager
    */
   public function addHandler( IVfsHandler $handler );

   /**
    * Gets the handler with defined name.
    *
    * @param  string $handlerName
    * @return \Niirrty\IO\Vfs\IVfsHandler|null
    */
   public function getHandler( string $handlerName ) : ?IVfsHandler;

   /**
    * Get all handlers as associative array.
    *
    * Keys are the handler names, values are the VfsHandler instances.
    *
    * @return \Niirrty\IO\Vfs\IVfsHandler[]
    */
   public function getHandlers() : array;

   /**
    * Gets if the handler is defined.
    *
    * @param  \Niirrty\IO\Vfs\VfsHandler|string $handler VfsHandler or handler name.
    * @return bool
    */
   public function hasHandler( $handler ) : bool;

   /**
    * Deletes all current defined handlers.
    */
   public function clearHandlers();

   /**
    * Gets the names of all defined handlers
    *
    * @return array
    */
   public function getHandlerNames() : array;

   /**
    * If a VFS handler matches the defined protocol, the $path is parsed (it means the protocol and known replacements
    * are replaces by associated path parts.
    *
    * @param  string $path
    * @param  array  $dynamicReplacements
    * @return string Returns the parsed path
    */
   public function parsePath( string $path, array $dynamicReplacements = [] ) : string;

}