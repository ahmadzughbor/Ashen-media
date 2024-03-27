<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPathToServicesTable extends Migration
{
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            // Add your new column here
            $table->string('path')->nullable()->after('description');
        });
    }

    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            // Reverse the operation in case of rollback
            $table->dropColumn('path');
        });
    }
}
