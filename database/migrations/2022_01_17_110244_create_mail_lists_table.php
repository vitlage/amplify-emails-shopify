<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_lists', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->nullable();
            $table->string('shop_id')->nullable();
            $table->string('name')->nullable();
            $table->string('template_id')->nullable();
            $table->string('default_subject')->nullable();
            $table->string('from_email')->nullable();
            $table->string('from_name')->nullable();
     
            // $table->string('template_id')->nullable();
            // $table->string('template_id')->nullable();
            // $table->string('template_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_lists');
    }
}
