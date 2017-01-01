# Playground: Event Sourcing

## Installation

Do you trust me? (TL;DR Oneliner)

```
git clone https://github.com/RobinMalfait/playground-event-sourcing.git && cd playground-event-sourcing && composer install && mkdir database && touch database/{.events,accounts.db.json} && php index.php && vendor/bin/phpunit
```

# Steps 1 by 1

```
git clone https://github.com/RobinMalfait/playground-event-sourcing.git
cd playground-event-sourcing
composer install
mkdir database
touch database/{.events,accounts.db.json}
php index.php
vendor/bin/phpunit
```

## Run it

Just open your terminal and run `php index.php`

If you want to work with queues, install beanstalkd and run `php run.php` in another tab.