SHELL := /bin/bash
APPNAME := search
THEMENAME := cobds

SASS := $(shell command -v sassc 2> /dev/null)
MSGFMT := $(shell command -v msgfmt 2> /dev/null)
LANGUAGES := $(wildcard language/*/LC_MESSAGES)
CSS := $(wildcard data/Themes/*/public/css)
JAVASCRIPT := $(shell find public -name '*.js' ! -name '*-*.js')

VERSION := $(shell cat VERSION | tr -d "[:space:]")
COMMIT := $(shell git rev-parse --short HEAD)

default: clean compile package

clean:
	rm -Rf build/${APPNAME}*
	for f in $(shell find public/css   -name '*-*.css'   ); do rm $$f; done
	for f in $(shell find data/Themes  -name '*-*.css'   ); do rm $$f; done
	for f in $(shell find public/js    -name '*-*.js'    ); do rm $$f; done

compile: deps $(LANGUAGES) $(CSS)
	cd public/css && sassc -t compact -m screen.scss screen-${VERSION}.css
	for f in ${JAVASCRIPT}; do cp $$f $${f%.js}-${VERSION}.js; done

package:
	[[ -d build ]] || mkdir build
	rsync -rl --exclude-from=buildignore . build/${APPNAME}
	cd build && tar czf ${APPNAME}-${VERSION}.tar.gz ${APPNAME}

$(CSS): deps
	cd $@ && sassc -t compact -m screen.scss screen-${VERSION}.css

$(LANGUAGES): deps
	cd $@ && msgfmt -cv *.po

deps:
ifndef SASS
	$(error "sassc is not installed")
endif
ifndef MSGFMT
	$(error "gettext is not installed")
endif
