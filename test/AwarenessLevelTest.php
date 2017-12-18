<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class AwarenessLevelTest extends PHPUnit\Framework\TestCase {

    public function test_white() {
        $testee = new AwarenessLevel(AwarenessLevel::WHITE);
        $this->assertSame(0, $testee->level());
        $this->assertSame("White", $testee->colour());
        $this->assertSame("Unknown", $testee->description());
    }

    public function test_green() {
        $testee = new AwarenessLevel(AwarenessLevel::GREEN);
        $this->assertSame(1, $testee->level());
        $this->assertSame("Green", $testee->colour());
        $this->assertSame("No particular awareness of the weather is required.", $testee->description());
    }

    public function test_yellow() {
        $testee = new AwarenessLevel(AwarenessLevel::YELLOW);
        $this->assertSame(2, $testee->level());
        $this->assertSame("Yellow", $testee->colour());
        $this->assertRegexp("/The weather is potentially dangerous./", $testee->description());
    }

    public function test_amber() {
        $testee = new AwarenessLevel(AwarenessLevel::AMBER);
        $this->assertSame(3, $testee->level());
        $this->assertSame("Amber", $testee->colour());
        $this->assertRegexp("/The weather is dangerous./", $testee->description());
    }

    public function test_red() {
        $testee = new AwarenessLevel(AwarenessLevel::RED);
        $this->assertSame(4, $testee->level());
        $this->assertSame("Red", $testee->colour());
        $this->assertRegexp("/The weather is very dangerous./", $testee->description());
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
