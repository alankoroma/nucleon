# Nucleon

A Simple light-weight Framework based on the Hexagonal Architecture with PHP Unit Test, PHP Unit Database Test, Mailing, Database Migration, View Templating and Authentication.

## Installation

run `cd nucleon`

Install dependencies with Composer

``
composer install
``

Configure `.env` with System settings. An Example `.env.example` has been provided.
Database driver can be either `sqlite` or `mysql`.
Update `phinx.yml` with database settings

If your database driver is `mysql` create a new MYSQL Database called `nucleon` and a test Database called `test_nucleon`

Run all migrations (check phinx.yml for more migration environments)

``
vendor/bin/phinx migrate
``

or 

``
vendor/bin/phinx migrate -e production_sqlite
``

to specify an environment
