# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## Unreleased

## v3.2.0

### Added

- Allow `mll-lab/microplate` version 4.1

## v3.1.0

### Added

- Allow `bensampo/laravel-enum` version 6

## v3.0.1

### Fixed

- Delete unnecessary version prefix

## v3.0.0

### Added

- Add reagent distribution command

### Breaking

- Rename `PipettingActionCommand` to `UsesTipMask`
- Rename `formatToString` to `toString` in all classes
- Refactor Command interface to abstract command class

## v2.1.0

### Added

- Add comment command
- Add initialisation header to protocol

## v2.0.0

### Added

- Add predefined classes that implement `Rack`- and `LiquidClass`-interface
- Add `fileName`-method on `TecanProtocol`

### Breaking

- delete superfluous semicolon after TipMask
- `PositionLocation` returns `$rack->name`
- `BarcodeLocation` does not return `$rack->name`
- Move `Rack`- and `LiquidClass`-interface to subdirectory
- Change signature of `TransferWithAutoWash`-class

## v1.1.0

### Added

- Add classes and methods for building pipetting instructions for Tecan Freedom EVO robots in the Gemini WorkList file format (\*.gwl).

## v1.0.0

### Added

- Add class `FluidXPlate` as a container for the scanned rackId and the scanned wells associated with a Coordinate (96-well format) from `mll-lab/microplate`
- Add class `TecanScanner` to parse a raw scan result string into a `FluidXPlate`
