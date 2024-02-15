<?php
namespace App\Database\Migration;
use System\DB;
use System\Database\Forge;

class tester {

    public function up()
    {
        if (!DB::hasTable('tester')) {
            DB::create('tester', function (Forge $table) {

                $table->id();
                // code

            });
        }
    }

    public function down()
    {
        DB::dropTableIfExists('tester');
    }

}