# Niirrty.IO.VFS Changelog

## Version 0.6.0 (2023-02-14)

* Change return types of some methods from `IVfsHandler` and `IVfsManager` to `self` 

## Version 0.2.1 (2018-04-05)

* Add interface `IVfsManager`
* Rename interface `IHandler` to `IVfsHandler`
* Rename class `Handler` to `VfsHandler`
* Rename class `Manager` to `VfsManager`


## Version 0.2.0 (2018-04-03)

Add unit tests with 100% code coverage.


## Version 0.1.1 (2018-03-17)

Add this `changelog.md` file.

Add 2nd optional parameter `array $options = []` to `\Niirrty\IO\VFS\Handler` constructor.
It adds the missed full init with a single constructor call.

Add Optional parameter `?Handler $firstHandler = null` to `\Niirrty\IO\VFS\Manager` constructor.

Add some Comments


## Version 0.1.0 (2017-11-04)

This is the first release :-)