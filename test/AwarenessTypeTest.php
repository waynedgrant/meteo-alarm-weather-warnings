<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class AwarenessTypeTest extends PHPUnit\Framework\TestCase {

    public function test_none() {
        $testee = new AwarenessType(AwarenessType::NO_WARNINGS);
        $serialized = $testee->serialize();

        $this->assertSame(0, $serialized['type']);
        $this->assertSame("No Warnings", $serialized['description']);
    }

    public function test_wind() {
        $testee = new AwarenessType(AwarenessType::WIND);
        $serialized = $testee->serialize();

        $this->assertSame(1, $serialized['type']);
        $this->assertSame("Wind", $serialized['description']);
    }

    public function test_snow_ice() {
        $testee = new AwarenessType(AwarenessType::SNOW_ICE);
        $serialized = $testee->serialize();

        $this->assertSame(2, $serialized['type']);
        $this->assertSame("Snow/Ice", $serialized['description']);
    }

    public function test_thunderstorms() {
        $testee = new AwarenessType(AwarenessType::THUNDERSTORMS);
        $serialized = $testee->serialize();

        $this->assertSame(3, $serialized['type']);
        $this->assertSame("Thunderstorms", $serialized['description']);
    }

    public function test_fog() {
        $testee = new AwarenessType(AwarenessType::FOG);
        $serialized = $testee->serialize();

        $this->assertSame(4, $serialized['type']);
        $this->assertSame("Fog", $serialized['description']);
    }

    public function test_extreme_high_temperatures() {
        $testee = new AwarenessType(AwarenessType::EXTREME_HIGH_TEMPERATURES);
        $serialized = $testee->serialize();

        $this->assertSame(5, $serialized['type']);
        $this->assertSame("Extreme High Temperatures", $serialized['description']);
    }

    public function test_extreme_low_temperatures() {
        $testee = new AwarenessType(AwarenessType::EXTREME_LOW_TEMPERATURES);
        $serialized = $testee->serialize();

        $this->assertSame(6, $serialized['type']);
        $this->assertSame("Extreme Low Temperatures", $serialized['description']);
    }

    public function test_coastal_event() {
        $testee = new AwarenessType(AwarenessType::COASTAL_EVENT);
        $serialized = $testee->serialize();

        $this->assertSame(7, $serialized['type']);
        $this->assertSame("Costal Event", $serialized['description']);
    }

    public function test_forest_fire() {
        $testee = new AwarenessType(AwarenessType::FOREST_FIRE);
        $serialized = $testee->serialize();

        $this->assertSame(8, $serialized['type']);
        $this->assertSame("Forest Fire", $serialized['description']);
    }

    public function test_avalanche() {
        $testee = new AwarenessType(AwarenessType::AVALANCHE);
        $serialized = $testee->serialize();

        $this->assertSame(9, $serialized['type']);
        $this->assertSame("Avalanche", $serialized['description']);
    }

    public function test_rain() {
        $testee = new AwarenessType(AwarenessType::RAIN);
        $serialized = $testee->serialize();

        $this->assertSame(10, $serialized['type']);
        $this->assertSame("Rain", $serialized['description']);
    }

    public function test_unavailable() {
        $testee = new AwarenessType(AwarenessType::UNAVAILABLE);
        $serialized = $testee->serialize();

        $this->assertSame(11, $serialized['type']);
        $this->assertSame("Unavailable", $serialized['description']);
    }

    public function test_flooding() {
        $testee = new AwarenessType(AwarenessType::FLOODING);
        $serialized = $testee->serialize();

        $this->assertSame(12, $serialized['type']);
        $this->assertSame("Flooding", $serialized['description']);
    }

    public function test_rain_flooding() {
        $testee = new AwarenessType(AwarenessType::RAIN_FLOODING);
        $serialized = $testee->serialize();

        $this->assertSame(13, $serialized['type']);
        $this->assertSame("Rain/Flooding", $serialized['description']);
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
