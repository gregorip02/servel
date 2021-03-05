<?php

namespace Servel;

use Closure;
use Illuminate\Http\Request as LaravelRequest;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Workerman\Events\EventInterface;
use Workerman\Protocols\Http\Request as WorkermanRequest;
use Workerman\Worker;

class Servel
{
    /**
     * Package versión.
     */
    public const VERSION = "0.0.1";

    /**
     * Start the server.
     *
     * @return void
     */
    public function start(): void
    {
        $config = config('servel');

        collect($config['servers'])->each(function (array $server) {
            $worker = new Worker($server['name'], $server['context'] ?? []);
            $worker->count = $server['count'] ?? 4;
            $worker->onMessage = $this->onMessage();
        });

        Worker::runAll();
    }

    /**
     * Stop all workers.
     *
     * @param  array  $servers
     * @return void
     */
    public function stop(array $servers = []): void
    {
        Worker::stopAll();
    }

    /**
     * Restart all workers.
     *
     * @param  array  $servers
     * @return void
     */
    public function restart(array $servers = []): void
    {
        Worker::reloadAllWorkers();
    }

    /**
     * Get global event-loop instance.
     *
     * @return Workerman\Events\EventInterface
     */
    public function loop(): EventInterface
    {
        return Worker::getEventLoop();
    }

    /**
     * Generic message handler.
     *
     * @return Closure
     */
    protected function onMessage(): Closure
    {
        /** @var \Illuminate\Contracts\Http\Kernel $kernel */
        $kernel = app(\Illuminate\Contracts\Http\Kernel::class);

        return function ($connection, WorkermanRequest $request) use ($kernel) {
            $response = $kernel->handle(
                $this->createLaravelRequest($request)
            )->getContent();

            $connection->send($response);
        };
    }

    /**
     * Create a Laravel request from incomming Workerman request.
     *
     * @param  Workerman\Protocols\Http\Request $request
     * @return Illuminate\Http\Request
     */
    protected function createLaravelRequest(WorkermanRequest $request): LaravelRequest
    {
        // TODO: Add support for parameters, cookies, files, headers, etc.
        return LaravelRequest::createFromBase(
            SymfonyRequest::create(
                $request->uri(),
                $request->method(),
            )
        );
    }
}
