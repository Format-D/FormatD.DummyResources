
# FormatD.DummyResources

Dummy Resources for Development Environment.

This package is meant to be used in local development environments where you don't have all the resource files available that are references in your database.
If you need to work on a large database locally and cannot (or don't want to) download all the resources, this package is for you.

## What does it do?

This package extends the default FileSystemStorage with an aspect. 
If no physical resource can be loaded from disk, the dummy file matching the file extension ist provided instead.

## Compatibility

Versioning scheme:

     1.0.0 
     | | |
     | | Bugfix Releases (non breaking)
     | Neos Compatibility Releases (non breaking except framework dependencies)
     Feature Releases (breaking)

Releases und compatibility:

| Package-Version | Neos Flow Version |
|-----------------|-------------------|
| 1.0.x           | 7.x               |


## Installation

Just install the package and publish resources:

```
    ./flow resource:publish
```

By default the package will only be active in development context.


## Configuration

You can provide your own dummy files by modifying the path setting:

```
FormatD:
  DummyResources:
    enable: false
    path: '%FLOW_PATH_PACKAGES%Application/FormatD.DummyResources/Resources/Private/Dummy/'
```
