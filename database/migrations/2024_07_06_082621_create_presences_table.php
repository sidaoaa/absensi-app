<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresencesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
    Schema::create('presences', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
        $table->string('in_image'); // Store path or identifier of the in image
        $table->string('in_time'); // Store the timestamp or time of entry
        $table->string('in_info'); // Additional information about the entry
        $table->string('in_location')->nullable();
        $table->string('out_image')->nullable(); // Store path or identifier of the out image (nullable)
        $table->string('out_time')->nullable(); // Store the timestamp or time of exit (nullable)
        $table->string('out_info')->nullable(); // Additional information about the exit (nullable)
        $table->string('out_location')->nullable();
        // $table->string('in_location')->nullable();// Tambahkan kolom in_location
        // $table->string('out_location')->nullable(); // Tambahkan kolom out_location
        $table->timestamps(); // Automatically manage creation and update timestamps
    });
}


    /**
     * Reverse the migrations.
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('presences');
    }
};
