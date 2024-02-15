<?php
/**
 * @author     Ni Irrty <niirrty+code@gmail.com>
 * @copyright  © 2017-2021, Ni Irrty
 * @package    Niirrty\IO\Vfs
 * @since      2017-11-03
 * @version    0.4.0
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


    #region // – – –   P R I V A T E   F I E L D S   – – – – – – – – – – – – – – – – – – – – – – – –

    /**
     * @var IVfsHandler[]
     */
    private array $_handlers;

    #endregion


    #region // – – –   P U B L I C   C O N S T R U C T O R   – – – – – – – – – – – – – – – – – – – –

    /**
     * Initialize a new \Niirrty\IO\Vfs\Manager instance.
     *
     * @param IVfsHandler|null $firstHandler Optional First assigned VFS VfsHandler
     */
    public function __construct( ?IVfsHandler $firstHandler = null )
    {

        $this->_handlers = [];

        if ( null !== $firstHandler )
        {
            $this->addHandler( $firstHandler );
        }

    }

    #endregion


    #region // – – –   P U B L I C   M E T H O D S   – – – – – – – – – – – – – – – – – – – – – – – –

    /**
     * Add/register one or more handlers.
     *
     * @param  IVfsHandler[] $handlers
     * @return self
     */
    public function addHandlers( array $handlers ) : self
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
     * @param  IVfsHandler $handler
     * @return self
     */
    public function addHandler( IVfsHandler $handler ) : self
    {

        $this->_handlers[ $handler->getName() ] = $handler;

        return $this;

    }

    /**
     * Gets the handler with defined name.
     *
     * @param  string $handlerName
     * @return IVfsHandler|null
     */
    public function getHandler( string $handlerName ) : ?IVfsHandler
    {

        return $this->_handlers[ $handlerName ] ?? null;

    }

    /**
     * Get all handlers as associative array.
     *
     * Keys are the handler names, values are the VfsHandler instances.
     *
     * @return IVfsHandler[]
     */
    public function getHandlers() : array
    {

        return $this->_handlers;

    }

    /**
     * Gets if the handler is defined.
     *
     * @param string|IVfsHandler $handler VfsHandler or handler name.
     *
     * @return bool
     */
    public function hasHandler( string|IVfsHandler $handler ) : bool
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
    public function clearHandlers() : void
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

    #endregion


    #region // – – –   P U B L I C   S T A T I C   M E T H O D S   – – – – – – – – – – – – – – – – –

    /**
     * The static constructor for fluent usage.
     *
     * @return IVfsManager
     */
    public static function Create() : IVfsManager
    {

        return new self();

    }

    #endregion


}

