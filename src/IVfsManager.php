<?php
/**
 * @author         Ni Irrty <niirrty+code@gmail.com>
 * @copyright      © 2018-2021, Ni Irrty
 * @license        MIT
 * @since          2018-04-05
 * @version        0.4.0
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
     * @param  IVfsHandler[] $handlers
     * @return IVfsManager
     */
    public function addHandlers( array $handlers ): IVfsManager;

    /**
     * Add/register a handler.
     *
     * @param  IVfsHandler $handler
     * @return IVfsManager
     */
    public function addHandler( IVfsHandler $handler ): IVfsManager;

    /**
     * Gets the handler with defined name.
     *
     * @param  string $handlerName
     * @return IVfsHandler|null
     */
    public function getHandler( string $handlerName ) : ?IVfsHandler;

    /**
     * Get all handlers as associative array.
     *
     * Keys are the handler names, values are the VfsHandler instances.
     *
     * @return IVfsHandler[]
     */
    public function getHandlers() : array;

    /**
     * Gets if the handler is defined.
     *
     * @param string|IVfsHandler $handler VfsHandler or handler name.
     *
     * @return bool
     */
    public function hasHandler( string|IVfsHandler $handler ) : bool;

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
