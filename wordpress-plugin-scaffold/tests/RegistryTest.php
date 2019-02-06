<?php

use p810\WPScaffold\Registry;
use PHPUnit\Framework\TestCase;

class RegistryTest extends TestCase
{
    private static $app;

    public static function setUpBeforeClass() {
        self::$app = new Registry;
    }

    public function testFooIsRegistered() {
        self::$app->register('foo', function () {
            return new stdClass;
        });

        $this->assertTrue(self::$app->has('foo'));
    }

    public function testFooHasOneItem() {
        $this->assertEquals(1, self::$app->count('foo'));
    }

    public function testFooHasInstanceOfstdClass() {
        $this->assertInstanceOf(stdClass::class, self::$app->one('foo'));
    }

    public function testAllReturnsArray() {
        $this->assertTrue(is_array(self::$app->all('foo')));
    }

    public function testFooResolvesNewInstance() {
        $this->assertInstanceOf(stdClass::class, self::$app->resolve('foo'));
    }

    public function testFooHasTwoItems() {
        $this->assertEquals(2, self::$app->count('foo'));
    }

    public function testBarIsRegisteredAsSingleton() {
        self::$app->register('bar', function () {
            return new stdClass;
        }, true);

        $this->assertTrue(self::$app->has('bar'));
    }

    public function testBarHasOneItem() {
        $this->assertEquals(1, self::$app->count('bar'));
    }

    public function testBarDoesNotResolveNewInstance() {
        try {
            self::$app->resolve('bar');
        } catch (Exception $e) {
            $this->assertInstanceOf(Exception::class, $e);
        }

        $this->assertEquals(1, self::$app->count('bar'));
    }
}
