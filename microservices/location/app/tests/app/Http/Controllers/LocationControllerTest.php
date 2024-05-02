<?php

use App\Http\Controllers\LocationController;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\TestCase;

class LocationControllerTest extends TestCase
{
    public function testDistance(): void
    {
        $realDistanceLondonAmsterdam = 358.06;
        $london = [
            'latitude' => 51.50,
            'longitude' => -0.13
        ];
        $amsterdam = [
            'latitude' => 52.37,
            'longitude' => 4.90
        ];
        $location = new LocationController();
        $calculatedDistance = $location->getDistance($london, $amsterdam);

        $this->assertTrue(method_exists(LocationController::class, 'convertDistance'));

        $this->assertEquals(
            $realDistanceLondonAmsterdam,
            $calculatedDistance
        );
    }

    public function testClosestSecrets(): void
    {
        $currentLocation = [
            'latitude' => 40.730610,
            'longitude' => -73.935242
        ];
        $location = new LocationController();
        $closestSecrets = $location->getClosestSecrets($currentLocation);
        $this->assertTrue(method_exists(LocationController::class, 'convertDistance'));
        $this->assertContainsOnly('array', $closestSecrets);
        $this->assertCount(3, $closestSecrets);

        // Checking the first element
        $currentElement = array_shift($closestSecrets);
        $this->assertEquals(['name' => 'amber'], array_intersect_key($currentElement, ['name' => 'amber']));
        // Second
        $currentElement = array_shift($closestSecrets);
        $this->assertEquals(['name' => 'ruby'], array_intersect_key($currentElement, ['name' => 'ruby']));
        // Third
        $currentElement = array_shift($closestSecrets);
        $this->assertEquals(['name' => 'diamond'], array_intersect_key($currentElement, ['name' => 'diamond']));
    }
}
