<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->string('text');
            $table->decimal('amount', 15, 2);
            $table->string('notes')->default('');
            $table->enum('category', [
                'Food',
                'Transport',
                'Entertainment',
                'Health',
                'Utilities',
                'Charity',
                'Gifts',
                'Shopping',
                'Salary',
                'Freelance',
                'Investments',
                'Other',
            ]);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
