<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('customers') && !Schema::hasColumn('customers', 'credit_note_balance')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->string('credit_note_balance')->after('balance')->default('0.00');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {

        });
    }
};
