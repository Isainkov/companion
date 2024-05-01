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
        Schema::table('users', function (Blueprint $table) {
            $table->string('image_url')->nullable()->after('email');
            $table->float('rating')->default(0.0)->after('image_url');
            $table->smallInteger('amount_of_reviews')->default(0)->after('rating');
            $table->string('country')->nullable()->after('amount_of_reviews');
            $table->string('city')->nullable()->after('country');
            $table->string('phone')->nullable()->after('city');
            $table->string('socials')->nullable()->after('phone');
            $table->string('name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('image_url');
            $table->dropColumn('rating');
            $table->dropColumn('amount_of_reviews');
            $table->dropColumn('country');
            $table->dropColumn('city');
            $table->dropColumn('phone');
            $table->dropColumn('socials');
            $table->string('name')->change();
        });
    }
};
