<?php
/**
 * @author     Ni Irrty <niirrty+code@gmail.com>
 * @copyright  © 2017-2020, Ni Irrty
 * @package    Niirrty\IO\Vfs
 * @since      2017-11-03
 * @version    0.3.0
 */


declare( strict_types = 1 );


namespace Niirrty\IO\Vfs;


use \Niirrty\ArgumentException;
use function \Niirrty\strStartsWith;
use function \Niirrty\substring;


/**
 * The VFS VfsHandler.
 *
 * It maps a single Folder to a virtual file system, identified by a protocol.
 *
 * @package Niirrty\IO\Vfs
 */
class VfsHandler implements IVfsHandler
{


    // <editor-fold desc="// – – –   P R I V A T E   F I E L D S   – – – – – – – – – – – – – – – – – – – – – – – –">

    /** @type string The protocol name */
    private $_name;

    /** @type string The root folder mapped by the protocol. */
    private $_rootFolder        = '';

    /** @type string The protocol name. */
    private $_protocolName      = '';

    /** @type string The protocol separator. */
    private $_protocolSeparator = '';

    /** @type array Optional replacements. */
    private $_replacements      = [];

    // </editor-fold>


    // <editor-fold desc="// – – –   P U B L I C   C O N S T R U C T O R   – – – – – – – – – – – – – – – – – – – –">

    /**
     * Initialize a new \Niirrty\IO\Vfs\VfsHandler instance.
     *
     * @param string $name The VfsHandler name (only required for identification).
     * @param string $protocolName The VFS protocol name.
     * @param string $protocolSeparator The VFS protocol separator.
     * @param string $rootFolder The VFS root folder (directory). The used protocol points to this folder.
     * @param string[] $replacements The optional replacements. Replaces a part of a path with format ${replacementName}
     * @throws ArgumentException
     */
    public function __construct(
        string $name, string $protocolName, string $protocolSeparator, string $rootFolder, array $replacements = [] )
    {

        $this->_name = $name;

        if ( ! empty( $protocolName ) && ! empty( $protocolSeparator ) )
        {
            $this->setProtocol( $protocolName, $protocolSeparator );
        }

        if ( ! empty( $rootFolder ) )
        {
            $this->setRootFolder( $rootFolder );
        }

        if ( 0 < \count( $replacements ) )
        {
            $this->addReplacements( $replacements );
        }

    }

    // </editor-fold>


    // <editor-fold desc="// – – –   P U B L I C   M E T H O D S   – – – – – – – – – – – – – – – – – – – – – – – –">

    /**
     * Sets the VFS protocol name and separator.
     *
     * @param string $name
     * @param string $separator
     * @return VfsHandler
     */
    public function setProtocol( string $name, string $separator = '://' ) : VfsHandler
    {

        $this->_protocolName = $name ?? '';
        $this->_protocolSeparator = $separator ?? '';

        return $this;

    }

    /**
     * Sets the VFS protocol name.
     *
     * @param string $name
     * @return VfsHandler
     */
    public function setProtocolName( string $name ) : VfsHandler
    {

        $this->_protocolName = $name ?? '';

        return $this;

    }

    /**
     * Sets the VFS protocol separator.
     *
     * @param string $separator
     * @return VfsHandler
     */
    public function setProtocolSeparator( string $separator = '://' ) : VfsHandler
    {

        $this->_protocolSeparator = $separator ?? '';

        return $this;

    }

    /**
     * Sets the VFS root folder (directory). The used protocol points to this folder.
     *
     * @param string $folder
     * @return VfsHandler
     * @throws ArgumentException If the folder not exists
     */
    public function setRootFolder( string $folder ) : VfsHandler
    {

        if ( ! @\is_dir( $folder ) )
        {
            throw new ArgumentException(
                'folder',
                $folder,
                'The defined VFS root directory not exists!'
            );
        }

        $this->_rootFolder = \rtrim( $folder, '/\\' );

        return $this;

    }

    /**
     * Gets the handler name
     *
     * @return string
     */
    public function getName() : string
    {

        return $this->_name;

    }

    /**
     * Gets the protocol (name + separator)
     *
     * @return string
     */
    public function getProtocol() : string
    {

        return $this->_protocolName . $this->_protocolSeparator;

    }

    /**
     * Gets the protocol name
     *
     * @return string
     */
    public function getProtocolName() : string
    {

        return $this->_protocolName;

    }

    /**
     * Gets the protocol separator
     *
     * @return string
     */
    public function getProtocolSeparator() : string
    {

        return $this->_protocolSeparator;

    }

    /**
     * Gets the VFS root folder.
     *
     * @return string
     */
    public function getRootFolder() : string
    {

        return $this->_rootFolder;

    }

    /**
     * Gets if a valid, usable protocol is defined.
     *
     * @return bool
     */
    public function isValid() : bool
    {

        return '' !== $this->getProtocol();

    }

    /**
     * Add or set a replacement.
     *
     * It replaces a part of a path with format ${replacementName}
     *
     * @param  string      $name  The name of the replacement
     * @param  string|null $value The replacement string value (or NULL to remove a replacement)
     * @return VfsHandler
     */
    public function addReplacement( string $name, ?string $value ) : VfsHandler
    {

        if ( null === $value )
        {

            unset( $this->_replacements[ $name ] );

            return $this;

        }

        $this->_replacements[ $name ] = $value;

        return $this;

    }

    /**
     * Add or set one or more replacements.
     *
     * It replaces a part of a path with format ${replacementName}
     *
     * @param array $replacements Associative array with replacements (keys are the names)
     * @return VfsHandler
     */
    public function addReplacements( array $replacements ) : VfsHandler
    {

        foreach ( $replacements as $name => $value )
        {

            if ( null === $value )
            {
                unset( $this->_replacements[ $name ] );
                continue;
            }

            $this->_replacements[ $name ] = $value;

        }

        return $this;

    }

    /**
     * Checks if a replacement with defined name exists.
     *
     * @param string $name
     * @return bool
     */
    public function hasReplacement( string $name ) : bool
    {

        return isset( $this->_replacements[ $name ] );

    }

    /**
     * Tries to parse a path, using a VFS protocol and replaces the protocol with a path
     *
     * @param string $pathRef
     * @param array  $dynamicReplacements
     * @return bool Return TRUE on success or false otherwise.
     */
    public function tryParse( string &$pathRef, array $dynamicReplacements = [] ) : bool
    {

        $protocol = $this->getProtocol();

        if ( '' === $protocol || ! strStartsWith( $pathRef, $protocol ) )
        {
            return false;
        }

        if ( \count( $dynamicReplacements ) > 0 )
        {
            $this->addReplacements( $dynamicReplacements );
        }

        /** @noinspection PhpComposerExtensionStubsInspection */
        $pathRef = $this->_rootFolder . DIRECTORY_SEPARATOR . substring( $pathRef, \mb_strlen( $protocol ) );

        $pathRef = \preg_replace_callback(
            '~\\${([A-Za-z0-9_.-]+)}~',
            function ( $matches )
            {

                if ( ! isset( $this->_replacements[ $matches[ 1 ] ] ) )
                {
                    return $matches[ 0 ];
                }

                return $this->_replacements[ $matches[ 1 ] ];
            },
            $pathRef
        );

        return true;

    }

    // </editor-fold>


    // <editor-fold desc="// – – –   P U B L I C   S T A T I C   M E T H O D S   – – – – – – – – – – – – – – – – –">

    /**
     * @param string $name
     * @param string $protocolName
     * @param string $protocolSeparator
     * @param string $rootFolder
     * @param array $replacements
     * @return VfsHandler
     * @throws ArgumentException
     */
    public static function Create(
        string $name, string $protocolName, string $protocolSeparator, string $rootFolder, array $replacements = [] )
        : VfsHandler
    {

        return new self( $name, $protocolName, $protocolSeparator, $rootFolder, $replacements );

    }

    // </editor-fold>


}

