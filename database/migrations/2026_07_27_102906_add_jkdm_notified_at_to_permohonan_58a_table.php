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
        Schema::table('permohonan_58a', function (Blueprint $table) {
            $table->timestamp('jkdm_notified_at')->nullable()->after('tarikh_tamat_cga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonan_58a', function (Blueprint $table) {
            $table->dropColumn('jkdm_notified_at');
        });
    }
};
