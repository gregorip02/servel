# [WIP] Servel - The Workerman Laravel Adapter.

## Install

```sh
composer require gregorip02/servel
```

## Usage

```sh
php artisan servel start
php artisan servel stop
php artisan servel connections
php artisan servel restart
php artisan servel reload
php artisan servel status
```

### TODO
- [ ] Add tests
- [ ] Allow servers to run in "daemon" mode
- [ ] Add command to stop the servers
- [ ] Add command to restart the servers
- [ ] Add watch feature for restarts in development mode
- [ ] Suport for publish configuration file
- [ ] Add support for parameters, cookies, files, headers, etc.
