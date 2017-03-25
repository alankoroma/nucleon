# Nucleon

A Simple light-weight Framework based on the Hexagonal Architecture with PHP Unit Test, PHP Unit Database Test, Mailing, Database Migration, View Templating and Authentication.

## Installation

Install dependencies with Composer

``
composer install
``

Create a new database called `nucleon` and a test database called `test_nucleon`

Configure `.env` with System settings. An Example `.env.example` has been provided.
Update `phinx.yml` with database settings

Run all migrations (check phinx.yml for more migration environments)

``
vendor/bin/phinx migrate
``

or 

``
vendor/bin/phinx migrate -e production_sqlite
``

to specify an environment
