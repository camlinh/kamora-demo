<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionCodeToBooks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
          $table->string('transaction_code')->nullable();
        });

        Schema::table('user_booking', function (Blueprint $table) {
          $table->string('transaction_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
          $table->dropColumn('transaction_code');
        });

        Schema::table('user_booking', function (Blueprint $table) {
          $table->dropColumn('transaction_code');
        });
    }
}
