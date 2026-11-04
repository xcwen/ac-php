# Copyright (C) 2014-2019 jim
#
# This file is not part of GNU Emacs.
#
# License
#
# This file is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 3
# of the License, or (at your option) any later version.
#
# This file is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this file; if not, write to the Free Software
# Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
# 02110-1301, USA.

SHELL := $(shell which bash)
ROOT_DIR := $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))

EMACS ?= $(shell emacs_path="$$(command -v emacs 2>/dev/null)"; \
	if test -x "$$emacs_path"; then printf '%s' "$$emacs_path"; \
	else printf '%s' /Applications/Emacs.app/Contents/MacOS/Emacs; fi)
CASK ?= $(shell cask_path="$$(command -v cask 2>/dev/null)"; \
	if test -x "$$cask_path"; then printf '%s' "$$cask_path"; \
	else printf '%s' $(HOME)/.cask/bin/cask; fi)
CASK_EMACS ?= $(EMACS)
CASKCMD = CASK_EMACS="$(CASK_EMACS)" "$(CASK)"
PANDOC ?= pandoc

EMACSFLAGS ?=
TESTFLAGS ?=
PANDOCLAGS ?= --fail-if-warnings \
	--reference-links \
	--atx-headers

# File lists
SRCS = ac-php-core.el ac-php.el company-php.el helm-ac-php-apropros.el
OBJS = $(SRCS:.el=.elc)
TESTS = $(wildcard test/*-test.el)

.SILENT: ;               # no need for @
.ONESHELL: ;             # recipes execute in same shell
.NOTPARALLEL: ;          # wait for this target to finish
.EXPORT_ALL_VARIABLES: ; # send all vars to shell
Makefile: ; # skip prerequisite discovery

# Run make help by default
.DEFAULT_GOAL = build

# Internal variables
EMACSBATCH = "$(EMACS)" -Q --batch -L . $(EMACSFLAGS)
RUNEMACS =

# Program availability
HAVE_CASK := $(shell command -v "$(CASK)" 2>/dev/null)
ifndef HAVE_CASK
$(info "$(CASK) is not available; using direct Emacs batch commands")
RUNEMACS = $(EMACSBATCH) -l test/dev-env.el
else
RUNEMACS = $(CASKCMD) exec $(EMACSBATCH)
endif

ifndef HAVE_CASK
EMACS_VERSION := $(shell "$(EMACS)" -Q --batch \
	--eval '(princ (format "%d.%d" emacs-major-version emacs-minor-version))')
PKGDIR := $(ROOT_DIR)/.cask/$(EMACS_VERSION)/elpa
else
PKGDIR := $(shell $(CASKCMD) package-directory)
endif

ifndef VERSION
ifdef HAVE_CASK
VERSION := $(shell $(CASKCMD) version)
else
VERSION := development
endif
endif

%.elc: %.el $(PKGDIR)
	$(RUNEMACS) -f batch-byte-compile $<

init $(PKGDIR): Cask
	if test -z "$(HAVE_CASK)"; then \
		printf '%s\n' 'Cask is required to install dependencies for the selected Emacs.' >&2; \
		printf '%s\n' 'Install Cask or set CASK=/path/to/cask, then run make init.' >&2; \
		exit 1; \
	fi
	$(CASKCMD) install && touch "$(PKGDIR)"

README: README.md
	$(PANDOC) $(PANDOCLAGS) $(PANDOCLAGS) -f markdown+empty_paragraphs -t plain -o $@ $^

# Public targets

.PHONY: .title
.title:
	$(info AC PHP $(VERSION))
	$(info )

.PHONY: init

.PHONY: checkdoc
checkdoc:
	$(EMACSBATCH) --eval '(checkdoc-file "$(SRCS)")'

.PHONY: build
build: $(OBJS)

.PHONY: test
test: $(PKGDIR)
	$(RUNEMACS) -L test -l test/test-helper.el \
		$(addprefix -l ,$(TESTS)) $(TESTFLAGS) -f ert-run-tests-batch-and-exit

.PHONY: clean
clean:
ifdef HAVE_CASK
	$(CASKCMD) clean-elc
else
	$(RM) -f $(OBJS)
endif
	$(RM) -f README

.PHONY: help
help: .title
	echo 'Run `make init` first to install and update all local dependencies.'
	echo ''
	echo 'Available targets:'
	echo '  help:     Show this help and exit'
	echo '  init:     Initialise the project (has to be launched first)'
	echo '  checkdoc: Checks AC PHP code for errors in documentation'
	echo '  build:    Byte compile AC PHP package'
	echo '  test:     Run the non-interactive unit test suite'
	echo '  clean:    Remove all byte compiled Elisp files'
	echo ''
	echo 'Available programs:'
	echo '  $(CASK): $(if $(HAVE_CASK),yes,no)'
	echo ''
	echo 'You need $(CASK) to develop AC PHP.  See http://cask.readthedocs.io/ for more.'
	echo ''
