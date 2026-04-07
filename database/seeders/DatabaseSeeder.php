<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\Notification;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create an admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@fededge.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'phone' => '0700000000',
                'address' => '123 Main Street, City',
            ]
        );

        // Create road officers
        User::factory(3)
            ->roadOfficer()
            ->create();

        // Create vehicle owners with vehicles and documents
        $vehicleOwners = User::factory(10)
            ->vehicleOwner()
            ->create();

        foreach ($vehicleOwners as $owner) {
            // Create 1-3 vehicles per owner
            $vehicles = Vehicle::factory(rand(1, 3))
                ->for($owner, 'owner')
                ->create();

            foreach ($vehicles as $vehicle) {
                // Create documents for each vehicle
                // Vehicle License
                Document::factory()
                    ->approved()
                    ->for($vehicle)
                    ->create([
                        'document_type' => 'vehicle_license',
                        'expiry_date' => now()->addMonths(rand(1, 12)),
                    ]);

                // Insurance
                Document::factory()
                    ->approved()
                    ->for($vehicle)
                    ->create([
                        'document_type' => 'insurance',
                        'expiry_date' => now()->addMonths(rand(1, 12)),
                    ]);

                // Roadworthiness Certificate
                Document::factory()
                    ->approved()
                    ->for($vehicle)
                    ->create([
                        'document_type' => 'roadworthiness_certificate',
                        'expiry_date' => now()->addMonths(rand(1, 12)),
                    ]);

                // Randomly add pending or expired documents
                if (rand(0, 1)) {
                    Document::factory()
                        ->pending()
                        ->for($vehicle)
                        ->create([
                            'document_type' => 'inspection_report',
                        ]);
                }

                if (rand(0, 1)) {
                    Document::factory()
                        ->expired()
                        ->for($vehicle)
                        ->create([
                            'document_type' => 'registration_certificate',
                        ]);
                }
            }

            // Create notifications for owners
            Notification::factory(3)
                ->unread()
                ->for($owner, 'user')
                ->create();
        }

        // Create some notifications for the admin
        Notification::factory(5)
            ->for($admin, 'user')
            ->create();

        $this->command->info('Database seeded successfully!');
        $this->command->info('');
        $this->command->info('Test Accounts:');
        $this->command->info('Admin: admin@fededge.com (password)');
        $this->command->info('Other accounts are auto-generated with: password');
    }
}
