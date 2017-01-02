# Playground: Event Sourcing

This is a little playground where I experiment with EventSourcing. The code should be pretty easy to understand. The whole `program` lives in the `index.php` file.
The code is tested, and documentation can be generated from the tests. I appreciate issues and pull-requests, if anything is unclear or you have questions feel free to ask.

## Installation

Do you trust me? (`TL;DR` Oneliner)

```
git clone https://github.com/RobinMalfait/playground-event-sourcing.git && cd playground-event-sourcing && composer install && mkdir database && php index.php && vendor/bin/phpunit
```

### Steps 1 by 1

```
git clone https://github.com/RobinMalfait/playground-event-sourcing.git
cd playground-event-sourcing
composer install
mkdir database
php index.php
vendor/bin/phpunit
```

## Run program

```
php index.php
```

## Test program

```
vendor/bin/phpunit
```

### Docs

When you run `vendor/bin/phpunit`, a docs folder will be generated. This has `md` and `txt` versions of your tests.
You can find some generated [docs here](https://github.com/RobinMalfait/playground-event-sourcing/tree/master/docs).