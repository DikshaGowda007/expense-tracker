<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->boolean('verified')->default(0)->comment('1 - verified, 0 - not verified');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
