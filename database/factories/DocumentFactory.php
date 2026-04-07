<?php

namespace Database\Factories;

use App\Models\Document;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $documentTypes = [
            'drivers_license',
            'vehicle_license',
            'insurance',
            'roadworthiness_certificate',
            'registration_certificate',
            'inspection_report',
        ];

        $issueDate = $this->faker->dateTimeBetween('-2 years');
        $expiryDate = $this->faker->dateTimeBetween($issueDate, '+3 years');

        return [
            'vehicle_id' => Vehicle::factory(),
            'document_type' => $this->faker->randomElement($documentTypes),
            'file_path' => 'documents/'.$this->faker->uuid().'.pdf',
            'original_filename' => $this->faker->word().'.pdf',
            'issue_date' => $issueDate,
            'expiry_date' => $expiryDate,
            'status' => $this->faker->randomElement(['approved', 'pending']),
            'admin_feedback' => null,
            'approved_by' => User::factory()->admin(),
            'approved_at' => now(),
        ];
    }

    /**
     * Create document in pending state.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'approved_by' => null,
            'approved_at' => null,
        ]);
    }

    /**
     * Create document in approved state.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
            'approved_by' => User::factory()->admin(),
            'approved_at' => now(),
        ]);
    }

    /**
     * Create expired document.
     */
    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'expired',
            'expiry_date' => now()->subDays(rand(1, 30)),
            'approved_by' => User::factory()->admin(),
            'approved_at' => now()->subMonths(rand(1, 12)),
        ]);
    }
}
