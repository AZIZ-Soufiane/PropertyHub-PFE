<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class CsvSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedUsers();
        $this->seedCalendars();
        $this->seedPropertyStatuses();
        $this->seedCategories();
        $this->seedProperties();
        $this->seedGalleries();
    }

    private function seedPropertyStatuses()
    {
        $statuses = ['pending', 'approved', 'rejected', 'sold', 'rented'];
        foreach ($statuses as $name) {
            DB::table('property_statuses')->updateOrInsert(
                ['name' => $name],
                ['name' => $name, 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }

    private function seedCategories()
    {
        $categories = [
            ['name' => 'Villa',     'slug' => 'villa',     'is_active' => true],
            ['name' => 'Apartment', 'slug' => 'apartment', 'is_active' => true],
            ['name' => 'House',     'slug' => 'house',     'is_active' => true],
            ['name' => 'Penthouse', 'slug' => 'penthouse', 'is_active' => true],
            ['name' => 'Land',      'slug' => 'land',      'is_active' => true],
        ];
        foreach ($categories as $cat) {
            DB::table('categories')->updateOrInsert(
                ['slug' => $cat['slug']],
                $cat + ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }

    private function seedUsers()
    {
        $file = database_path('data/users.csv');
        $data = $this->parseCsv($file);
        foreach ($data as $row) {
            DB::table('users')->insert([
                'name' => $row['name'],
                'email' => $row['email'],
                'password' => $row['password'],
                'role' => $row['role'],
                'license_number' => $row['license_number'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function seedCalendars()
    {
        $file = database_path('data/calendars.csv');
        $data = $this->parseCsv($file);
        foreach ($data as $row) {
            DB::table('calendars')->insert([
                'agent_id' => $row['agent_id'],
                'available_days' => $row['available_days'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function seedProperties()
    {
        $file = database_path('data/properties.csv');
        $data = $this->parseCsv($file);
        foreach ($data as $row) {
            $statusId = DB::table('property_statuses')->where('name', $row['status'])->value('id');
            if (!$statusId) {
                $statusId = DB::table('property_statuses')->insertGetId([
                    'name' => $row['status'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            DB::table('properties')->insert([
                'title' => $row['title'],
                'type' => $row['type'],
                'price' => $row['price'],
                'location' => $row['location'],
                'address' => $row['address'] ?? null,
                'city' => $row['city'] ?? null,
                'country' => $row['country'] ?? null,
                'area' => $row['area'] ?? null,
                'bedrooms' => $row['bedrooms'] ?? null,
                'bathrooms' => $row['bathrooms'] ?? null,
                'description' => $row['description'] ?? null,
                'features' => $row['features'] ?? null,
                'status_id' => $statusId,
                'agent_id' => $row['agent_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

private function seedGalleries()
{
        $file = database_path('data/galleries.csv');
        $data = $this->parseCsv($file);
        
        foreach ($data as $row) {
            DB::table('galleries')->insert([
                'property_id' => $row['property_id'],
                'image_urls' => $row['image_urls'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function parseCsv($path)
    {
        if (!File::exists($path)) {
            return [];
        }

        $lines = explode("\n", trim(File::get($path)));
        $header = str_getcsv(array_shift($lines));
        $data = [];

        foreach ($lines as $line) {
            if (empty($line)) continue;
            $row = str_getcsv($line);
            if (count($header) === count($row)) {
                $data[] = array_combine($header, $row);
            }
        }

        return $data;
    }
}
