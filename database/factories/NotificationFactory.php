<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['info', 'warning', 'success', 'error'];
        $relatedTypes = ['vehicle', 'document', 'user'];

        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(),
            'message' => $this->faker->paragraph(),
            'type' => $this->faker->randomElement($types),
            'related_type' => $this->faker->randomElement($relatedTypes),
            'related_id' => $this->faker->numberBetween(1, 100),
            'read_at' => null,
        ];
    }

    /**
     * Create read notification.
     */
    public function read(): static
    {
        return $this->state(fn (array $attributes) => [
            'read_at' => now()->subDays(rand(0, 30)),
        ]);
    }

    /**
     * Create unread notification.
     */
    public function unread(): static
    {
        return $this->state(fn (array $attributes) => [
            'read_at' => null,
        ]);
    }
}
