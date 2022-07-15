<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreFieldsInMailListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mail_lists', function (Blueprint $table) {
            $table->string('company')->nullable();
            $table->string('state')->nullable();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('city')->nullable();
            $table->string('zip')->nullable();
            $table->string('phone')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('home_page_url')->nullable();

            $table->boolean('subscribe_confirmation')->default(false);
            $table->boolean('send_welcome_email')->default(false);
            $table->boolean('unsubscribe_notification')->default(false);
            $table->boolean('is_custom')->default(false);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mail_lists', function (Blueprint $table) {
            //
        });
    }
}
