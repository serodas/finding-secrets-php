<?php

namespace Tests;

use App\Algorithm\Dice;

class DiceTest extends TestCase
{
    public function test_fight_method_returns_array_with_correct_values()
    {
        $dice = new Dice();
        $result = $dice->fight();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('player1', $result);
        $this->assertArrayHasKey('player2', $result);
        $this->assertIsInt($result['player1']);
        $this->assertIsInt($result['player2']);
        $this->assertGreaterThanOrEqual(0, $result['player1']);
        $this->assertGreaterThanOrEqual(0, $result['player2']);
        $this->assertLessThanOrEqual(3, $result['player1']);
        $this->assertLessThanOrEqual(3, $result['player2']);
    }
}
