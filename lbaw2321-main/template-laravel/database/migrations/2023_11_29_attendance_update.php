<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('event_id');
            $table->enum('participation', ['Going', 'Maybe', 'Not Going']);
            $table->boolean('wishlist')->default(false);
            
            // Define the composite primary key
            $table->primary(['user_id', 'event_id']);

            // Define foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE');
            $table->foreign('event_id')->references('id')->on('events')->onUpdate('CASCADE');
        });
    }
};
