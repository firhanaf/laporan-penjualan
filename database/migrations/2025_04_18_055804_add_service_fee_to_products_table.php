<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceFeeToProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->float('service_fee')->default(0)->after('production_service');
        });

        // Isi kolom service_fee dengan penjumlahan dari tiga kolom lainnya
        DB::statement('
            UPDATE products 
            SET service_fee = design_service + packaging_service + production_service
        ');
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('service_fee');
        });
    }
};