<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostmarkWebhookLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('postmark-webhooks.log.table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('message_id', 100);
            $table->string('record_type', 32);
            $table->string('email')->index();
            $table->json('payload');
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('postmark-webhooks.log.table'));
    }
}
