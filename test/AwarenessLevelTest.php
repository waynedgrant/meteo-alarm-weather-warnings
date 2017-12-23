<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class AwarenessLevelTest extends PHPUnit\Framework\TestCase {

    public function test_white() {
        $testee = new AwarenessLevel(AwarenessLevel::WHITE);
        $serialized = $testee->serialize();

        $this->assertSame(0, $serialized['level']);
        $this->assertSame("White", $serialized['colour']);
        $this->assertSame("Unknown", $serialized['description']);
    }

    public function test_green() {
        $testee = new AwarenessLevel(AwarenessLevel::GREEN);
        $serialized = $testee->serialize();

        $this->assertSame(1, $serialized['level']);
        $this->assertSame("Green", $serialized['colour']);
        $this->assertSame("No particular awareness of the weather is required.", $serialized['description']);
    }

    public function test_yellow() {
        $testee = new AwarenessLevel(AwarenessLevel::YELLOW);
        $serialized = $testee->serialize();

        $this->assertSame(2, $serialized['level']);
        $this->assertSame("Yellow", $serialized['colour']);
        $this->assertRegexp("/The weather is potentially dangerous./", $serialized['description']);
    }

    public function test_amber() {
        $testee = new AwarenessLevel(AwarenessLevel::AMBER);
        $serialized = $testee->serialize();

        $this->assertSame(3, $serialized['level']);
        $this->assertSame("Amber", $serialized['colour']);
        $this->assertRegexp("/The weather is dangerous./", $serialized['description']);
    }

    public function test_red() {
        $testee = new AwarenessLevel(AwarenessLevel::RED);
        $serialized = $testee->serialize();

        $this->assertSame(4, $serialized['level']);
        $this->assertSame("Red", $serialized['colour']);
        $this->assertRegexp("/The weather is very dangerous./", $serialized['description']);
    }

    public function test_invalid_low_level() {
        $this->expectException(InvalidArgumentException::class);

        $testee = new AwarenessLevel(-1);
    }

    public function test_invalid_high_level() {
        $this->expectException(InvalidArgumentException::class);

        $testee = new AwarenessLevel(666);
    }
}

?>
