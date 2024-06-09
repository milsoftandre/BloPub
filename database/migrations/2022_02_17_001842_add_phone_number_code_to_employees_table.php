<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class AddPhoneNumberCodeToEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('tel')->default('');
            $table->string('code')->default('');
        });

        // Add admin
        DB::table('employees')->insert([
            [
                'name' => 'Руслан',
                'email' => 'ruslan',
                'tel' => '+79284545085',
                'password' => bcrypt('12345678'),

            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('tel')->default('');
            $table->string('code')->default('');
        });
    }
}
