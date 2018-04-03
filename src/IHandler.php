<?php
/**
 * @author         Ni Irrty <niirrty+code@gmail.com>
 * @copyright  (c) 2018, Ni Irrty
 * @license        MIT
 * @since          2018-04-03
 * @version        0.2.0
 */


namespace Niirrty\IO\Vfs;


use Niirrty\IValidStatus;


/**
 * The VFS Handler.
 *
 * It maps a single Folder to a virtual file system, identified by a protocol.
 *
 * @package Niirrty\IO\Vfs
 */
interface IHandler extends IValidStatus
{


   /**
    * Sets the VFS protocol name and separator.
    *
    * @param string $name
    * @param string $separator
    * @return \Niirrty\IO\Vfs\IHandler
    */
   public function setProtocol( string $name, string $separator = '://' );

   /**
    * Sets the VFS protocol name.
    *
    * @param string $name
    * @return \Niirrty\IO\Vfs\IHandler
    */
   public function setProtocolName( string $name );

   /**
    * Sets the VFS protocol separator.
    *
    * @param string $separator
    * @return \Niirrty\IO\Vfs\IHandler
    */
   public function setProtocolSeparator( string $separator = '://' );

   /**
    * Sets the VFS root folder (directory). The used protocol points to this folder.
    *
    * @param string $folder
    * @return \Niirrty\IO\Vfs\IHandler
    * @throws \Niirrty\ArgumentException If the folder not exists
    */
   public function setRootFolder( string $folder );

   /**
    * Gets the handler name
    *
    * @return string
    */
   public function getName() : string;

   /**
    * Gets the protocol (name + separator)
    *
    * @return string
    */
   public function getProtocol() : string;

   /**
    * Gets the protocol name
    *
    * @return string
    */
   public function getProtocolName() : string;

   /**
    * Gets the protocol separator
    *
    * @return string
    */
   public function getProtocolSeparator() : string;

   /**
    * Gets the VFS root folder.
    *
    * @return string
    */
   public function getRootFolder() : string;

   /**
    * Add or set a replacement.
    *
    * It replaces a part of a path with format ${replacementName}
    *
    * @param  string      $name  The name of the replacement
    * @param  string|null $value The replacement string value (or NULL to remove a replacement)
    * @return \Niirrty\IO\Vfs\IHandler
    */
   public function addReplacement( string $name, ?string $value );

   /**
    * Add or set one or more replacements.
    *
    * It replaces a part of a path with format ${replacementName}
    *
    * @param array $replacements Associative array with replacements (keys are the names)
    * @return \Niirrty\IO\Vfs\IHandler
    */
   public function addReplacements( array $replacements );

   /**
    * Checks if a replacement with defined name exists.
    *
    * @param string $name
    * @return bool
    */
   public function hasReplacement( string $name ) : bool;

   /**
    * Tries to parse a path, using a VFS protocol and replaces the protocol with a path
    *
    * @param string $pathRef
    * @param array  $dynamicReplacements
    * @return bool Return TRUE on success or false otherwise.
    */
   public function tryParse( string &$pathRef, array $dynamicReplacements = [] ) : bool;


}

