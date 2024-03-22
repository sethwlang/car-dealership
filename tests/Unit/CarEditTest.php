<?php

namespace Tests\Feature;

use Database\Factories\ManufacturerFactory;
use Database\Factories\CarFactory; 
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CarEditTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_edit_a_car()
    {

        // Create a car
        $car = CarFactory::new()->create();

        // New car data
        $newData = [
            'name' => 'New Car Name',
            'model' => 'New Model',
            'year' => 2022,
        ];

        // Send a PUT request to update the car
        $response = $this->put("/cars/{$car->id}", $newData);

        // Assert the response is successful
        $response->assertStatus(200);

        // Refresh the car model from the database
        $car->refresh();

        // Assert that the car's attributes are updated
        $this->assertEquals('New Car Name', $car->name);
        $this->assertEquals('New Model', $car->model);
        $this->assertEquals(2022, $car->year);
        
    }
}
