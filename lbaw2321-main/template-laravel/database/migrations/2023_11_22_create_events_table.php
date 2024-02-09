<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->string('eventName');
        $table->dateTime('startDateTime');
        $table->dateTime('endDateTime');
        $table->dateTime('registrationEndTime');
        $table->string('local');
        $table->string('description');
        $table->integer('capacity');
        $table->boolean('isPublic')->default(true);
        $table->enum('status', ['Active', 'Suspended', 'OtherStatus'])->default('Active');
        $table->foreignId('owner_id')->constrained('users')->onUpdate('cascade');
        $table->foreignId('tag_id')->nullable()->constrained('tags')->onUpdate('cascade');
        $table->string('photo')->nullable();
        $table->timestamps();
    });
}

public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
