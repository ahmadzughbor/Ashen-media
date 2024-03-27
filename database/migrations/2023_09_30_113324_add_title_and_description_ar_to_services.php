<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleAndDescriptionArToServices extends Migration
{
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            // Add 'title_ar' column
            $table->string('title_ar')->nullable()->after('title');

            // Add 'description_ar' column
            $table->string('description_ar')->nullable()->after('title_ar');
        });
    }

    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            // Reverse the changes if needed
            $table->dropColumn('title_ar');
            $table->dropColumn('description_ar');
        });
    }
}
