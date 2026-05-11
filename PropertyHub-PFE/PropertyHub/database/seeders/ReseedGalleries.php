<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ReseedGalleries extends Seeder
{
    public function run(): void
    {
        DB::table('galleries')->truncate();

        $file = database_path('data/galleries.csv');
        $lines = explode("\n", trim(File::get($file)));
        $header = str_getcsv(array_shift($lines));

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            $row = str_getcsv($line);
            if (count($header) === count($row)) {
                $data = array_combine($header, $row);
                DB::table('galleries')->insert([
                    'property_id' => $data['property_id'],
                    'image_urls'  => $data['image_urls'],
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }

        $this->command->info('Seeded ' . DB::table('galleries')->count() . ' gallery records.');
    }
}
