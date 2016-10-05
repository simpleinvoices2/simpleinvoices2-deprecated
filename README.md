# Simple Invoices 2

## Introduction

This is a port of [Simple Invoices](http://github.com/simpleinvoices/simpleinvoices) using the Zend Framework MVC layer and module systems. This application is meant to be used for invoicing.

## Installation using Composer

The easiest way to create install Simple Invoices 2 project is to use
[Composer](https://getcomposer.org/).  If you don't have it already installed,
then please install as per the [documentation](https://getcomposer.org/doc/00-intro.md).

For quick reference, simplly run:

```bash
$ composer install
```

## Installation using Bower

Simple Invoices 2 also requires some javascript and stylesheets which may be easilly installes
using [Bower](https://bower.io/). 

If you don't have it already installed, then please install install [NPMJS](https://docs.npmjs.com/cli/install)
as it is one of the dependencies. Once NPM is installed simply run:

```bash
$ npm install -g bower
```

Note: [Git](https://git-scm.com/downloads) is also a dependency. I guess you will have that
installed, but make sure it is installed on the system path or bower will give you some errors.

## Database installation

No databae installer is present at the moment, simplly use the latest [Simple Invoices](http://github.com/simpleinvoices/simpleinvoices) database structure.
## Development mode

Rename `development.config.php.dist` to `development.config.dist`.
If this step is ommited the cache will start to work and it could be difficult to track errors.

## Logging in

The username is `demo@simpleinvoices.org` and the password is `demo`.