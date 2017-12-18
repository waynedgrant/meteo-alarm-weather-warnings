<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class AwarenessTypeTest extends PHPUnit\Framework\TestCase {

    public function test_none() {
        $testee = new AwarenessType(AwarenessType::NONE);
        $this->assertSame(0, $testee->type());
        $this->assertSame("None", $testee->description());
    }

    public function test_wind() {
        $testee = new AwarenessType(AwarenessType::WIND);
        $this->assertSame(1, $testee->type());
        $this->assertSame("Wind", $testee->description());
    }

    public function test_snow_ice() {
        $testee = new AwarenessType(AwarenessType::SNOW_ICE);
        $this->assertSame(2, $testee->type());
        $this->assertSame("Snow/Ice", $testee->description());
    }

    public function test_thunderstorms() {
        $testee = new AwarenessType(AwarenessType::THUNDERSTORMS);
        $this->assertSame(3, $testee->type());
        $this->assertSame("Thunderstorms", $testee->description());
    }

    public function test_fog() {
        $testee = new AwarenessType(AwarenessType::FOG);
        $this->assertSame(4, $testee->type());
        $this->assertSame("Fog", $testee->description());
    }

    public function test_extreme_high_temperatures() {
        $testee = new AwarenessType(AwarenessType::EXTREME_HIGH_TEMPERATURES);
        $this->assertSame(5, $testee->type());
        $this->assertSame("Extreme High Temperatures", $testee->description());
    }

    public function test_extreme_low_temperatures() {
        $testee = new AwarenessType(AwarenessType::EXTREME_LOW_TEMPERATURES);
        $this->assertSame(6, $testee->type());
        $this->assertSame("Extreme Low Temperatures", $testee->description());
    }

    public function test_coastal_event() {
        $testee = new AwarenessType(AwarenessType::COASTAL_EVENT);
        $this->assertSame(7, $testee->type());
        $this->assertSame("Costal Event", $testee->description());
    }

    public function test_forest_fire() {
        $testee = new AwarenessType(AwarenessType::FOREST_FIRE);
        $this->assertSame(8, $testee->type());
        $this->assertSame("Forest Fire", $testee->description());
    }

    public function test_avalanche() {
        $testee = new AwarenessType(AwarenessType::AVALANCHE);
        $this->assertSame(9, $testee->type());
        $this->assertSame("Avalanche", $testee->description());
    }

    public function test_rain() {
        $testee = new AwarenessType(AwarenessType::RAIN);
        $this->assertSame(10, $testee->type());
        $this->assertSame("Rain", $testee->description());
    }

    public function test_unavailable() {
        $testee = new AwarenessType(AwarenessType::UNAVAILABLE);
        $this->assertSame(11, $testee->type());
        $this->assertSame("Unavailable", $testee->description());
    }

    public function test_flooding() {
        $testee = new AwarenessType(AwarenessType::FLOODING);
        $this->assertSame(12, $testee->type());
        $this->assertSame("Flooding", $testee->description());
    }

    public function test_rain_flooding() {
        $testee = new AwarenessType(AwarenessType::RAIN_FLOODING);
        $this->assertSame(13, $testee->type());
        $this->assertSame("Rain/Flooding", $testee->description());
    }

    public function test_invalid_low_type() {
        $this->expectException(InvalidArgumentException::class);
        $testee = new AwarenessType(-1);
    }

    public function test_invalid_high_type() {
        $this->expectException(InvalidArgumentException::class);
        $testee = new AwarenessType(14);
    }
}

?>
