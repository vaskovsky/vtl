# Copyright © 2017 Alexey Vaskovsky.
#
# This file is part of VTL.
#
# VTL is free software: you can redistribute it and/or modify
# it under the terms of the GNU Lesser General Public License
# as published by the Free Software Foundation, either version 3
# of the License, or (at your option) any later version.
#
# VTL is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU Lesser General Public License for more details.
#
# You should have received a copy of the GNU Lesser General Public
# License along with VTL. If not, see <http://www.gnu.org/licenses/>.
SEDX := sed
SEDX += -e 's/\.\/vendor\/components\/jquery/\0\/dist/g'
SEDX += -e 's/\.\/vendor\/[^\/]\+\//\.\/bower_components\//g'
SEDRU := sed
SEDRU += -e 's/Toggle navigation/Навигация/g'
SEDRU += -e 's/\bBrand\b/Бренд/g'
SEDRU += -e 's/\bTitle\b/Заголовок/g'
SEDRU += -e 's/\bContent\b/Содержимое/g'
SEDRU += -e 's/\bHome\b/Главное/g'
SEDRU += -e 's/\bAbout\b/О нас/g'
SEDRU += -e 's/\bContact\b/Контакты/g'

all: composer-ru.html
composer-ru.html: composer.html Makefile
	$(SEDRU) composer.html > $@

all: bower.html
bower.html: composer.html
	$(SEDX) composer.html > $@

all: bower-ru.html
bower-ru.html: composer-ru.html
	$(SEDX) composer-ru.html > $@

all: vendor/autoload.php
vendor/autoload.php: composer.json
	composer install

all: bower_components/bower.json
bower_components/bower.json: bower.json
	bower install
	cp -fT bower.json $@

clean distclean:
	rm -rf bower_components vendor composer.lock
