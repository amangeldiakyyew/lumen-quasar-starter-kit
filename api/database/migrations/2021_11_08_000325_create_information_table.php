<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformationTable extends Migration
{

    public $tableName = 'information';

    public function up()
    {
        if (Schema::hasTable($this->tableName)) {
            return 'table exists';
        }
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->text('slug');
            $table->text('title');
            $table->longText('content')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->integer('sort_order')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }
}
