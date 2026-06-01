<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->unsignedBigInteger('status_id')->nullable()->after('location');
        });

        // Migrate existing status strings to property_statuses
        $properties = DB::table('properties')->get();
        foreach ($properties as $property) {
            if (isset($property->status) && $property->status) {
                $statusId = DB::table('property_statuses')->where('name', $property->status)->value('id');
                if (!$statusId) {
                    $statusId = DB::table('property_statuses')->insertGetId([
                        'name' => $property->status,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                DB::table('properties')->where('id', $property->id)->update(['status_id' => $statusId]);
            }
        }

        Schema::table('properties', function (Blueprint $table) {
            $table->foreign('status_id')->references('id')->on('property_statuses')->onDelete('cascade');
            if (Schema::hasColumn('properties', 'status')) {
                $table->dropColumn('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('status')->nullable()->after('location');
        });

        $properties = DB::table('properties')->get();
        foreach ($properties as $property) {
            if ($property->status_id) {
                $statusName = DB::table('property_statuses')->where('id', $property->status_id)->value('name');
                DB::table('properties')->where('id', $property->id)->update(['status' => $statusName]);
            }
        }

        Schema::table('properties', function (Blueprint $table) {
            $table->dropForeign(['status_id']);
            $table->dropColumn('status_id');
        });
    }
};
