<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration
{
    public $tableName='category';

    public function up()
    {
        if (Schema::hasTable($this->tableName)) {
            return 'table exists';
        }
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_id')->nullable()->unsigned();
            $table->string('slug');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price',15,2)->nullable();
            $table->string('icon')->nullable();
            $table->string('icon_class')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->integer('sort_order')->nullable();
            $table->integer('product_addable')->default(1);
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::table($this->tableName, function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on($this->tableName)->onDelete('cascade')->onUpdate('cascade');
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
