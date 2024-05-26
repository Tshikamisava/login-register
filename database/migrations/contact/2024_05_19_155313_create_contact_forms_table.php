<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('contact_forms', function (Blueprint $table) {
            $table->id();
            $table->string('first_name',50)->nullable(false);
            $table->enum('status',['new','in-progress','resolved'])->default('new');
            $table->string('last_name',50)->nullable(false);
            $table->string('email',100)->nullable(false);
            $table->string('subject',100)->nullable(false);
            $table->text('message')->nullable(false);
            // For registered users - Link the contact request to the user's account
            // $table->foreignId('user_id')->constrained('users');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_forms');
    }
};
