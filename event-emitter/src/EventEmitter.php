<?php

namespace p810\EventEmitter;

use SplQueue;
use Generator;
use UnexpectedValueException;

class EventEmitter
{
    /**
     * @var SplQueue[]
     */
    protected $events = [];


    /**
     * Creates an event but does not add any callbacks.
     *
     * @param string $event
     * @return self
     */
    public function new(string $event): self {
        if (!$this->has($event)) {
            $this->events[$event] = new SplQueue;
        }

        return $this;
    }


    /**
     * Registers a callback to the event.
     *
     * @param string   $event
     * @param callable $callback
     * @return self
     */
    public function on(string $event, callable $callback): self {
        if (!$this->has($event)) {
            $this->events[$event] = new SplQueue;
        }

        $this->events[$event]->enqueue($callback);

        return $this;
    }


    /**
     * Calls the list of callbacks belonging to an event and yields each result.
     *
     * @throws UnexpectedValueException if the event does not exist.
     * @param string $event
     * @param mixed  $args
     * @return Generator
     */
    public function emit(string $event, ...$args): Generator {
        if (!$this->has($event)) {
            throw new UnexpectedValueException(
                $event . ' is not a registered event'
            );
        } else {
            foreach ($this->events[$event] as $callback) {
                yield $callback(...$args);
            }
        }
    }


    /**
     * Removes a callback from an event's queue.
     *
     * @param string   $event
     * @param callable $callback
     * @return self
     */
    public function remove(string $event, callable $callback): self {
        if ($this->has($event)) {
            $this->events[$event]->dequeue($callback);
        }

        return $this;
    }


    /**
     * Unregisters an event.
     *
     * @throws UnexpectedValueException if the event does not exist.
     * @param string $event
     * @return self
     */
    public function unregister(string $event): self {
        if (!$this->has($event)) {
            throw new UnexpectedValueException(
                $event . ' is not a registered event'
            );
        }

        unset($this->events[$event]);
    }


    /**
     * Returns a boolean indicating if the event is registered or not.
     *
     * @param string $event
     * @return bool
     */
    public function has(string $event): bool {
        return array_key_exists($event, $this->events);
    }
}
