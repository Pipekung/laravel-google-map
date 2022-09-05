<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('lat');
            $table->string('lng');
            $table->string('detail')->nullable();
            $table->timestamps();
        });

        DB::table('locations')->insert([
            ['title' => 'Pin 1', 'lat' => '18.795701', 'lng' => '98.978370'],
            ['title' => 'Pin 2', 'lat' => '18.795125', 'lng' => '98.993499'],
            ['title' => 'Pin 3', 'lat' => '18.781378', 'lng' => '98.992815'],
            ['title' => 'Pin 4', 'lat' => '18.781594', 'lng' => '98.977762'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
};
