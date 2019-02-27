# Nelio Maps

Simple and beautiful Google Maps block for WordPress.

## Features

* Different align options are available.
* Use different Google Map styles.
* Enable/disable zoom and pan.
* Add a single marker in the map.
* Add a text box on top of the map with information about the marker.

## Installation

First, clone the project in your development environment:

```
git clone https://github.com/davilera/nelio-maps.git
```

Then build the code using the following command:

```
npm install && npm run build
```

## Build Process

Requirements:

* [Node.js](https://nodejs.org) v8.9.1 or later.
* [npm](https://www.npmjs.com/get-npm) v5.5.1 or later.
* [Composer](https://getcomposer.org/) v1.8.1 or later.

To compile and generate the build files just execute the following command on your terminal:

```
npm run start
```

This will download the Node.js and PHP dependencies under `node_modules` and `vendor` folders respectively. Once executed, the previous command will continuously watch any change in JS/CSS files and re-build them.

The plugins also provides these additional commands:

* `npm run dev` Build files and watch for changes.
* `npm run build` Build files and minify JSS and CSS.
* `npm run lint-php` Run PHP_CodeSniffer on PHP files to detect errors.
* `npm run lint-php:fix` Run phpcbf to try to fix PHP errors.
* `npm run lint-css` Run `stylelint` on SCSS files to detect errors.
* `npm run lint-css:fix` Try to fix errors on SCSS files.
* `npm run lint-js` Run `eslint` on JS files to detect errors.
* `npm run lint-js:fix` Try to fix errors on JS files.
* `npm run lint` Run linting process on PHP, SCSS and JS files.
* `npm run update:packages` Update package dependencies in Node.js.

## License

Nelio Maps is licensed under the GPL v2 or later.

> This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation.
>
> This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
>
> You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA

A copy of the license is included in the root of the plugin’s directory. The file is named `LICENSE`.

# Credits

Nelio Maps (`nelio-maps`) was created in March 2019 by [David Aguilera](http://twitter.com/davilera/) and [Antonio Villegas](http://twitter.com/avillegasn/), from [Nelio Software](https://neliosoftware.com/). The plugin is based on a former Boilerplate they created for bootstrapping plugins like this: the [WordPress Block Editor Boilerplate](https://github.com/avillegasn/wp-beb/).

## Documentation, FAQs, and More

If you’re interested in writing any documentation or creating tutorials please [let us know](https://neliosoftware.com/contact/).

