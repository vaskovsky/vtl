# Vaskovsky Template Library (VTL)

## System Requirements

* Git 2.1+
* Bower 1.7+
* Composer 1.4+
* GNU Make 4.0+

## Installation

1. To install all libraries and templates use Composer:

		composer require vaskovsky/vtl

2. To get front end libraries only (js, css) use Bower:

		bower install vtl

## Contents

* `css`:	CSS libraries.

* `js`:		JavaScript libraries.

* `php`:	PHP libraries.
	[See API documentation](http://vaskovsky.net/vtl/annotated.html).

* `html`:	HTML templates.
	Each template has `Makefile`. To build template run `make`.

* `example`:	Project templates.
	Each template has `Makefile`. To build template run `make`.

## License LGPL-3.0+

Copyright © 2017 Alexey Vaskovsky.

This library is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 3.0 of the License, or (at your option) any later version.

This library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public
License along with this library. If not, see
<http://vaskovsky.net/vtl/md_LICENSE.html>
