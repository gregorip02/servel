# Servel - The Workerman Laravel Adapter.



## Install

```sh
# Install the package
composer require gregorip02/servel

# Publish the configuration package
php artisan vendor:publish --tag=servel-config
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
- [x] Add command to stop the servers
- [x] Add command to restart the servers
- [ ] Add watch feature for restarts in development mode
- [x] Suport for publish configuration file
- [x] Add support for parameters, cookies, files, headers, etc.
