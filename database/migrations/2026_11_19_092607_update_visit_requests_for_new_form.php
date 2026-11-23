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
        Schema::table('visit_requests', function (Blueprint $table) {
            // Kolom lama yang tidak ada lagi di formulir baru
            $table->string('institution_type')->nullable()->change();
            // Tanggal kunjungan sekarang memuat jam (sesi)
            $table->dateTime('preferred_date')->change();

            // Kolom baru
            $table->text('npwp')->nullable();          // dienkripsi lewat cast model
            $table->text('ktp_number')->nullable();    // dienkripsi lewat cast model
            $table->string('source', 30)->nullable();  // ad | website | referral | mirota_team
            $table->string('mirota_team_name', 100)->nullable();
            $table->string('province', 60)->nullable();
            $table->text('address')->nullable();
            $table->string('department', 100)->nullable();
            $table->unsignedSmallInteger('companions')->default(0);
            $table->string('ktp_photo_path')->nullable();
            $table->string('letter_path')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('visit_requests', function (Blueprint $table) {
            $table->dropColumn([
                'npwp', 'ktp_number', 'source', 'mirota_team_name', 'province',
                'address', 'department', 'companions', 'ktp_photo_path', 'letter_path',
            ]);
        });
    }
};
