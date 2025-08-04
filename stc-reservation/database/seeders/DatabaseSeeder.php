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
        $ghanaianNames = [
            'Kwame Mensah', 'Akosua Boateng', 'Yaw Ofori', 'Ama Serwaa', 'Kojo Asante', 
            'Abena Owusu', 'Kofi Adjei', 'Afia Appiah', 'Yaw Darko', 'Esi Sarpong',
            'Kwesi Amoah', 'Adwoa Kufuor', 'Kwabena Osei', 'Akua Danso', 'Kwame Addo',
            'Ama Kyei', 'Yaw Owusu', 'Efua Mensah', 'Kojo Ampah', 'Abenaa Osei'
        ];

        // Major Ghanaian cities with realistic routes
        $ghanaianCities = [
            'Accra', 'Kumasi', 'Tamale', 'Takoradi', 'Cape Coast', 'Sunyani', 'Ho', 'Koforidua', 'Tema'
        ];

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

        // Create realistic routes between major cities
        $routePairs = [
            // High-frequency routes (Accra connections)
            ['Accra', 'Kumasi'],
            ['Accra', 'Tamale'],
            ['Accra', 'Takoradi'],
            ['Accra', 'Cape Coast'],
            ['Accra', 'Sunyani'],
            ['Accra', 'Ho'],
            ['Accra', 'Koforidua'],
            ['Accra', 'Tema'],
            
            // Regional connections
            ['Kumasi', 'Tamale'],
            ['Kumasi', 'Sunyani'],
            ['Kumasi', 'Cape Coast'],
            ['Kumasi', 'Takoradi'],
            ['Kumasi', 'Koforidua'],
            
            ['Tamale', 'Sunyani'],
            ['Tamale', 'Ho'],
            
            ['Takoradi', 'Cape Coast'],
            ['Takoradi', 'Sunyani'],
            
            ['Cape Coast', 'Sunyani'],
            ['Cape Coast', 'Koforidua'],
            
            ['Sunyani', 'Ho'],
            ['Sunyani', 'Koforidua'],
            
            ['Ho', 'Koforidua'],
            ['Tema', 'Koforidua'],
        ];

        $routes = [];
        foreach ($routePairs as $pair) {
            $price = $this->calculateRoutePrice($pair[0], $pair[1]);
            $routes[] = Route::firstOrCreate([
                'origin' => $pair[0], 
                'destination' => $pair[1]
            ], [
                'price' => $price,
            ]);
        }

        // Create buses with different capacities
        $buses = [];
        $busConfigs = [
            ['name' => 'STC Express 001', 'seat_count' => 45],
            ['name' => 'STC Express 002', 'seat_count' => 45],
            ['name' => 'STC Luxury 001', 'seat_count' => 35],
            ['name' => 'STC Comfort 001', 'seat_count' => 40],
            ['name' => 'STC Comfort 002', 'seat_count' => 40],
            ['name' => 'STC Premium 001', 'seat_count' => 30],
        ];

        foreach ($busConfigs as $config) {
            $bus = Bus::firstOrCreate(['name' => $config['name']], ['seat_count' => $config['seat_count']]);
            
            // Create seats for each bus if they don't exist
            if ($bus->seats()->count() === 0) {
                $seats = [];
                for ($i = 1; $i <= $config['seat_count']; $i++) {
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

        // Create trips for the next 14 days with realistic scheduling
        $trips = [];
        $departureTimes = [
            '06:00', '07:00', '08:00', '09:00', '10:00', '11:00', 
            '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', 
            '18:00', '19:00', '20:00', '21:00', '22:00'
        ];

        foreach ($routes as $route) {
            // Determine frequency based on route popularity
            $isPopularRoute = in_array($route->origin, ['Accra', 'Kumasi']) || 
                             in_array($route->destination, ['Accra', 'Kumasi']);
            
            $tripsPerDay = $isPopularRoute ? rand(4, 6) : rand(2, 4);
            
            for ($day = 0; $day < 14; $day++) {
                $date = now()->addDays($day)->toDateString();
                
                // Select random departure times for this day
                $dayTimes = $faker->randomElements($departureTimes, $tripsPerDay);
                sort($dayTimes); // Sort times chronologically
                
                foreach ($dayTimes as $time) {
                    $bus = $faker->randomElement($buses);
                    
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

        // Create realistic bookings with better distribution
        $users = User::role('user')->get();
        $statuses = ['booked', 'checked-in', 'cancelled', 'completed'];
        
        foreach ($users as $user) {
            // Each user books 2-4 random trips
            $userTrips = $faker->randomElements($trips, rand(2, 4));
            
            foreach ($userTrips as $trip) {
                $availableSeats = $trip->bus->seats()->whereDoesntHave('bookings', function($q) use ($trip) {
                    $q->where('trip_id', $trip->id);
                })->get();
                
                if ($availableSeats->count() > 0) {
                    $seat = $faker->randomElement($availableSeats);
                    
                    // Calculate expiry time
                    $expiresAt = now()->addHours(24);
                    $tripDepartureTime = Carbon::parse($trip->departure_date)->setTimeFrom($trip->departure_time);
                    $oneHourBeforeTrip = $tripDepartureTime->copy()->subHour();
                    
                    if ($oneHourBeforeTrip->isFuture() && $oneHourBeforeTrip->lt($expiresAt)) {
                        $expiresAt = $oneHourBeforeTrip;
                    }
                    
                    // For past trips, set expiry to a past time
                    if ($tripDepartureTime->isPast()) {
                        $expiresAt = $tripDepartureTime->copy()->subHour();
                    }
                    
                    // Determine status based on trip date
                    $status = 'booked';
                    if ($tripDepartureTime->isPast()) {
                        $status = $faker->randomElement(['completed', 'cancelled']);
                    } elseif ($tripDepartureTime->diffInHours(now()) < 2) {
                        $status = $faker->randomElement(['booked', 'checked-in']);
                    }
                    
                    Booking::firstOrCreate([
                        'user_id' => $user->id,
                        'trip_id' => $trip->id,
                        'seat_id' => $seat->id,
                    ], [
                        'status' => $status,
                        'qr_code_path' => null,
                        'expires_at' => $expiresAt,
                    ]);
                }
            }
        }

        $this->command->info('✅ Database seeded with realistic Ghanaian data!');
        $this->command->info('📊 Created:');
        $this->command->info('   - ' . count($routes) . ' routes between major cities');
        $this->command->info('   - ' . count($buses) . ' buses with different capacities');
        $this->command->info('   - ' . count($trips) . ' trips over the next 14 days');
        $this->command->info('   - ' . count($users) . ' regular users');
        $this->command->info('🔑 Admin login: admin@stc.com / admin123');
        $this->command->info('👤 Regular user: kwame.mensah@gmail.com / password');
    }

    /**
     * Calculate route price based on distance and popularity
     */
    private function calculateRoutePrice($origin, $destination): float
    {
        // Base prices for different route types (in GHS)
        $routePrices = [
            // Accra connections (high frequency, popular routes)
            'Accra-Kumasi' => 85.00,
            'Accra-Tamale' => 120.00,
            'Accra-Takoradi' => 65.00,
            'Accra-Cape Coast' => 45.00,
            'Accra-Sunyani' => 75.00,
            'Accra-Ho' => 55.00,
            'Accra-Koforidua' => 35.00,
            'Accra-Tema' => 25.00,
            
            // Regional connections
            'Kumasi-Tamale' => 95.00,
            'Kumasi-Sunyani' => 40.00,
            'Kumasi-Cape Coast' => 70.00,
            'Kumasi-Takoradi' => 80.00,
            'Kumasi-Koforidua' => 60.00,
            
            'Tamale-Sunyani' => 85.00,
            'Tamale-Ho' => 110.00,
            
            'Takoradi-Cape Coast' => 35.00,
            'Takoradi-Sunyani' => 70.00,
            
            'Cape Coast-Sunyani' => 65.00,
            'Cape Coast-Koforidua' => 50.00,
            
            'Sunyani-Ho' => 75.00,
            'Sunyani-Koforidua' => 55.00,
            
            'Ho-Koforidua' => 45.00,
            'Tema-Koforidua' => 30.00,
        ];

        $routeKey = $origin . '-' . $destination;
        $reverseKey = $destination . '-' . $origin;

        // Return price for either direction
        if (isset($routePrices[$routeKey])) {
            return $routePrices[$routeKey];
        } elseif (isset($routePrices[$reverseKey])) {
            return $routePrices[$reverseKey];
        }

        // Default price for unknown routes
        return 50.00;
    }
}
