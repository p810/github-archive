<?php

namespace p810\Notification;

abstract class Observer
{
    /**
     * A list of objects which observe the child class for events.
     *
     * @param array
     * @access protected
     */
    protected $observers = array();


    /**
     * A boolean which will stop the yielding of results during propagation.
     *
     * @param boolean
     * @access protected
     */
    protected $halt = false;


    /**
     * Subscribes an object to the observer.
     *
     * @param Callable $subscriber A Callable value.
     * @return void
     */
    public function register($subscriber) {
        $this->observers[] = $subscriber;
    }


    /**
     * Broadcasts a notification to subscribers.
     *
     * This method acts as a generator. Results may be collected by iterating over them, or calling PHP's `iterator_to_array()` function.
     *
     * The first argument passed to a subscriber will always be an instance of the Observer class. Warnings are suppressed on method calls
     * so that subscribers are not forced to adhere to a specific argument list.
     *
     * @param mixed $data Data to notify subscribers of (optional).
     * @return void
     */
    public function notify($data = null) {
        foreach ($this->observers as $subscriber) {
            if ($this->halt) {
                $this->reset();

                break;
            }

            $arguments = array($this);

            if (!is_null($data)) {
                $arguments = array_merge($arguments, $data);
            }

            $response = @call_user_func_array($subscriber, $arguments);

            yield $response;
        }
    }


    /**
     * Stops the propagation of an event.
     *
     * @return void
     */
    public function stop() {
        $this->halt = true;
    }


    /**
     * This method is called after propagation of an event is stopped.
     *
     * @return void
     */
    public function reset() {
        $this->halt = false;
    }
}