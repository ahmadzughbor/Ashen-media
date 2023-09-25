<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPathToSaysTable extends Migration
{
    public function up()
    {
        Schema::table('says', function (Blueprint $table) {
            $table->string('path')->nullable()->after('description');
        });
    }

    public function down()
    {
        Schema::table('says', function (Blueprint $table) {
            $table->dropColumn('path');
        });
    }
}
