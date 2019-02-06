<?php

use PHPUnit\Framework\TestCase;
use p810\EventEmitter\EventEmitter;

class EventEmitterTest extends TestCase
{
    public function testEventAddsWithMethodNew() {
        $emitter = new EventEmitter;

        $emitter->new('foo');

        $this->assertTrue($emitter->has('foo'));

        return $emitter;
    }

    /**
     * @depends testEventAddsWithMethodNew
     */
    public function testCallbackAppendsToFoo(EventEmitter $emitter) {
        $emitter->on('foo', function (string $repeat) {
            return $repeat;
        });

        foreach ($emitter->emit('foo', 'Hello world') as $value) {
            $this->assertEquals('Hello world', $value);
        }

        return $emitter;
    }

    /**
     * @depends testCallbackAppendsToFoo
     */
    public function testEventAddsWithMethodOn(EventEmitter $emitter) {
        $emitter->on('bar', function () {
            return 'Hello universe';
        });

        $this->assertTrue($emitter->has('bar'));

        return $emitter;
    }

    /**
     * @depends testEventAddsWithMethodOn
     */
    public function testMethodEmitReturnsGenerator(EventEmitter $emitter) {
        $generator = $emitter->emit('bar');

        $this->assertInstanceOf(Generator::class, $generator);

        return $emitter;
    }

    /**
     * @depends testMethodEmitReturnsGenerator
     */
    public function testGeneratorCountsOneValue(EventEmitter $emitter) {
        $values = iterator_to_array($emitter->emit('bar'));

        $this->assertCount(1, $values);
    }
}
