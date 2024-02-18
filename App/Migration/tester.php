<?php
namespace App\Database\Migration;
use System\Database\Paper;
use System\Database\Forge;

class tester {

    public function up()
    {
        if (!Paper::hasTable('tester')) {
            Paper::create('tester', function (Forge $table) {

                $table->id();
                // code

            });
        }
    }

    public function down()
    {
        Paper::dropTableIfExists('tester');
    }

}