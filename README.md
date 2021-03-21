# Servel - [Workerman](https://github.com/walkor/Workerman) adapter for Laravel.

[![Latest Stable Version](https://poser.pugx.org/gregorip02/servel/v)](//packagist.org/packages/gregorip02/servel)
[![Total Downloads](https://poser.pugx.org/gregorip02/servel/downloads)](//packagist.org/packages/gregorip02/servel)
[![License](https://poser.pugx.org/gregorip02/servel/license)](//packagist.org/packages/gregorip02/servel)

**WIP**: This package provides a tcp entry point for your Laravel application,
powered by the high-performance [Workerman](https://github.com/walkor/Workerman) server.

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

## Benchmarking

```
DO Droplet - CPU Dedicated
- 8GB Memory
- 50GB SSD
- 8 VCPUs
```

**Render the default `welcome.blade.php` view**
```sh
wrk -t4 -c50 http://0.0.0.0/

Running 10s test @ http://0.0.0.0/
  4 threads and 50 connections
  Thread Stats   Avg      Stdev     Max   +/- Stdev
    Latency    27.16ms    5.74ms 124.65ms   92.53%
    Req/Sec    443.86     49.22   520.00     86.25%
  17687 requests in 10.01s, 312.24MB read
  Socket errors: connect 0, read 17687, write 0, timeout 0
Requests/sec:   1767.28
Transfer/sec:   31.20MB
```

**A simple endpoint that responds `pong`**
```sh
wrk -t4 -c50 http://0.0.0.0/ping

Running 10s test @ http://0.0.0.0/ping
  4 threads and 50 connections
  Thread Stats   Avg      Stdev     Max   +/- Stdev
    Latency    25.62ms    5.95ms  95.00ms   89.80%
    Req/Sec    469.97     56.74   585.00     77.25%
  18724 requests in 10.01s, 18.30MB read
  Socket errors: connect 0, read 18724, write 0, timeout 0
Requests/sec:   1871.13
Transfer/sec:   1.83MB
```

**An endpoint that responds 100 users in JSON format from a SQLite database. I/O**
```sh
wrk -t4 -c50 http://0.0.0.0/users

Running 10s test @ http://0.0.0.0/users
  4 threads and 50 connections
  Thread Stats   Avg      Stdev     Max   +/- Stdev
    Latency   288.79ms   28.25ms 397.73ms   94.93%
    Req/Sec   41.16      17.08   101.00     63.38%
  1638 requests in 10.01s, 33.76MB read
  Socket errors: connect 0, read 1638, write 0, timeout 0
Requests/sec:    163.63
Transfer/sec:    3.37MB
```
### TODO
- [ ] Add tests
- [ ] Add support for run in "daemon" mode
- [ ] Add support for websockets
- [ ] Add support for restarts in development mode
- [x] Add command to restart the servers
- [x] Add command to stop the servers
- [x] Add support for publish configuration file
- [x] Add support for parameters, cookies, files, headers, etc.
