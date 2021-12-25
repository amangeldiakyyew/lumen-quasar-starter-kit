<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('country')){
            return 'table exists';
        }
        Schema::create('country', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('iso2')->nullable();
            $table->string('iso3')->nullable();
            $table->string('phone_code')->nullable();
            $table->string('currency')->nullable();
            $table->string('native')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('country');
    }
}
