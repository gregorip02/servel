<?php

namespace Servel;

use Closure;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request as LaravelRequest;
use Workerman\Connection\TcpConnection;
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

        /** @var \Illuminate\Contracts\Http\Kernel $kernel */
        $kernel = app(Kernel::class);

        collect($config['servers'])->each(function (array $server) use ($kernel) {
            $worker = new Worker($server['name'], $server['context'] ?? []);
            $worker->count = $server['count'] ?? 4;
            $worker->onMessage = $this->onMessage($kernel);
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
     * @return \Workerman\Events\EventInterface
     */
    public function loop(): EventInterface
    {
        return Worker::getEventLoop();
    }

    /**
     * Generic message handler.
     *
     * @param  \Illuminate\Contracts\Http\Kernel $kernel
     * @return \Closure
     */
    protected function onMessage(Kernel $kernel): Closure
    {
        return function (TcpConnection $connection, WorkermanRequest $request) use ($kernel) {
            $connection->close($kernel->handle(
                $this->createLaravelRequest($request)
            ));
        };
    }

    /**
     * Create a Laravel request from incomming Workerman request.
     *
     * @param  \Workerman\Protocols\Http\Request $request
     * @return \Illuminate\Http\Request
     */
    protected function createLaravelRequest(WorkermanRequest $request): LaravelRequest
    {
        return LaravelRequest::createFromBase(
            SymfonyRequest::create(
                $request->uri(),
                $request->method()
            )
        );
    }
}
