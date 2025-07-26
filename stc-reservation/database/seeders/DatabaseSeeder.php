<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Route;
use App\Models\Bus;
use App\Models\Trip;
use App\Models\Seat;
use App\Models\Booking;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Faker\Factory as Faker;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Roles and permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $manageBookings = Permission::firstOrCreate(['name' => 'manage bookings']);
        $manageUsers = Permission::firstOrCreate(['name' => 'manage users']);
        $adminRole->givePermissionTo([$manageBookings, $manageUsers]);
        $userRole->givePermissionTo([$manageBookings]);

        // Ghanaian names and cities
        $ghanaianNames = ['Kwame Mensah', 'Akosua Boateng', 'Yaw Ofori', 'Ama Serwaa', 'Kojo Asante', 'Abena Owusu', 'Kofi Adjei', 'Afia Appiah', 'Yaw Darko', 'Esi Sarpong'];
        $ghanaianCities = ['Accra', 'Kumasi', 'Tamale', 'Takoradi', 'Cape Coast', 'Sunyani', 'Ho'];

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@stc.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('admin123'),
            ]
        );
        if (!$admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
        }

        // Create regular users
        foreach ($ghanaianNames as $i => $name) {
            $email = strtolower(str_replace(' ', '.', $name)) . '@gmail.com';
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => bcrypt('password'),
                ]
            );
            if (!$user->hasRole('user')) {
                $user->assignRole($userRole);
            }
        }

        // Create routes (Accra <-> other cities)
        $routes = [];
        foreach (['Kumasi', 'Tamale', 'Takoradi', 'Cape Coast', 'Sunyani', 'Ho'] as $city) {
            $routes[] = Route::firstOrCreate(['origin' => 'Accra', 'destination' => $city]);
            $routes[] = Route::firstOrCreate(['origin' => $city, 'destination' => 'Accra']);
        }

        // Create buses
        $buses = [];
        $busNames = ['STC Express 001', 'STC Express 002', 'STC Luxury 001', 'STC Comfort 001'];
        foreach ($busNames as $busName) {
            $bus = Bus::firstOrCreate(['name' => $busName], ['seat_count' => 40]);
            // Create seats for each bus
            if ($bus->seats()->count() === 0) {
                $seats = [];
                for ($i = 1; $i <= 40; $i++) {
                    $row = chr(65 + intval(($i - 1) / 4)); // A, B, C, ...
                    $number = (($i - 1) % 4) + 1;
                    $seats[] = [
                        'bus_id' => $bus->id,
                        'seat_number' => $row . $number,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                Seat::insert($seats);
            }
            $buses[] = $bus;
        }

        // Create trips for the next 7 days
        $trips = [];
        foreach ($routes as $route) {
            foreach ($buses as $bus) {
                for ($day = 0; $day < 7; $day++) {
                    $date = now()->addDays($day)->toDateString();
                    foreach (['08:00', '14:00', '20:00'] as $time) {
                        $trip = Trip::firstOrCreate([
                            'route_id' => $route->id,
                            'bus_id' => $bus->id,
                            'departure_date' => $date,
                            'departure_time' => $time,
                        ]);
                        $trips[] = $trip;
                    }
                }
            }
        }

        // Create bookings for users
        $users = User::role('user')->get();
        $statuses = ['booked', 'checked-in', 'cancelled', 'completed'];
        foreach ($users as $user) {
            // Each user books 3-5 random trips
            foreach ($faker->randomElements($trips, rand(3, 5)) as $trip) {
                $availableSeats = $trip->bus->seats()->whereDoesntHave('bookings', function($q) use ($trip) {
                    $q->where('trip_id', $trip->id);
                })->get();
                if ($availableSeats->count() > 0) {
                    $seat = $faker->randomElement($availableSeats);
                    
                    // Calculate expiry time (24 hours from now, or 1 hour before trip departure, whichever is earlier)
                    $expiresAt = now()->addHours(24);
                    $tripDepartureTime = Carbon::parse($trip->departure_date . ' ' . $trip->departure_time);
                    $oneHourBeforeTrip = $tripDepartureTime->copy()->subHour();
                    
                    if ($oneHourBeforeTrip->isFuture() && $oneHourBeforeTrip->lt($expiresAt)) {
                        $expiresAt = $oneHourBeforeTrip;
                    }
                    
                    // For past trips, set expiry to a past time
                    if ($tripDepartureTime->isPast()) {
                        $expiresAt = $tripDepartureTime->copy()->subHour();
                    }
                    
                    Booking::firstOrCreate([
                        'user_id' => $user->id,
                        'trip_id' => $trip->id,
                        'seat_id' => $seat->id,
                    ], [
                        'status' => $faker->randomElement($statuses),
                        'qr_code_path' => null,
                        'expires_at' => $expiresAt,
                    ]);
                }
            }
        }

        $this->command->info('Seeded with realistic Ghanaian data!');
        $this->command->info('Admin login: admin@stc.com / admin123');
    }
}
