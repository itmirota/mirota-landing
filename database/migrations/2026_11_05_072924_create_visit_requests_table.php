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
        Schema::create('visit_requests', function (Blueprint $table) {
            $table->id();
            $table->string('institution');
            $table->string('institution_type');           // school | university | company | other
            $table->string('contact_name');
            $table->string('email');
            $table->string('phone', 30);
            $table->unsignedSmallInteger('visitors');
            $table->date('preferred_date');
            $table->text('message')->nullable();
            $table->string('locale', 5)->default('id');
            $table->string('status')->default('new');    // new | confirmed | done | rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_requests');
    }
};
