<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('title')->nullable()->after('id');
            $table->string('type')->nullable()->after('title');
            $table->string('address')->nullable()->after('type');
            $table->string('city')->nullable()->after('address');
            $table->string('country')->nullable()->after('city');
            $table->integer('area')->nullable()->after('country');
            $table->integer('bedrooms')->nullable()->after('area');
            $table->integer('bathrooms')->nullable()->after('bedrooms');
            $table->text('description')->nullable()->after('bathrooms');
            $table->string('features')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'title', 'type', 'address', 'city', 'country',
                'area', 'bedrooms', 'bathrooms', 'description', 'features'
            ]);
        });
    }
};
