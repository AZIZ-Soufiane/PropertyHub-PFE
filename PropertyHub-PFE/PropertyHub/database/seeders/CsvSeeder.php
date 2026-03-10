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
        $this->seedProperties();
        $this->seedGalleries();
    }

    private function seedUsers()
    {
        $file = database_path('data/users.csv');
        $data = $this->parseCsv($file);
        foreach ($data as $row) {
            DB::table('users')->insert([
                'name' => $row['name'],
                'email' => $row['email'],
                'password' => $row['password'], // Assuming already hashed in CSV or handle here
                'role' => $row['role'],
                'license_number' => $row['license_number'] ?: null,
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
            DB::table('properties')->insert([
                'price' => $row['price'],
                'location' => $row['location'],
                'status' => $row['status'],
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
