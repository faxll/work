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
        if (Schema::hasTable('bank_transfers') && !Schema::hasColumn('bank_transfers', 'to_type')) {
            Schema::table('bank_transfers', function (Blueprint $table) {
                $table->string('to_type')->after('from_type');
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
        Schema::table('bank_transfers', function (Blueprint $table) {

        });
    }
};
