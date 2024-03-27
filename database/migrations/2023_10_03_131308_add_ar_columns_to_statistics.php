<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArColumnsToStatistics extends Migration
{
    public function up()
    {
        Schema::table('statistics', function (Blueprint $table) {
            $table->string('section1_ar')->nullable()->after('num4');
            $table->string('section2_ar')->nullable()->after('section1_ar');
            $table->string('section3_ar')->nullable()->after('section2_ar');
            $table->string('section4_ar')->nullable()->after('section3_ar');
        });
    }

    public function down()
    {
        Schema::table('statistics', function (Blueprint $table) {
            $table->dropColumn('section1_ar');
            $table->dropColumn('section2_ar');
            $table->dropColumn('section3_ar');
            $table->dropColumn('section4_ar');
        });
    }
}
