<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            // identifiers
            $table->bigIncrements('id')->index();
            $table->bigInteger('parent_id')->nullable()->index();
            // data
            $table->string('title');
            $table->longtext('description')->nullable();
            $table->string('type', 10)->index();
            // flags
            $table->boolean('is_complete')->default(false);
            $table->boolean('hide_when_complete')->default(true);
            // timestamps
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
