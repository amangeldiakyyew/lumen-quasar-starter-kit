<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingTable extends Migration
{
    public $tableName='setting';

    public function up()
    {
        if (Schema::hasTable($this->tableName)) {
            return 'table exists';
        }
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->references('id')->on('setting_group')->onDelete('cascade');
            $table->string('key')->nullable();
            $table->string('type')->nullable();
            $table->string('name')->nullable();
            $table->longText('value')->nullable();
            $table->text('hint')->nullable();
            $table->integer('sort_order')->nullable();
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
