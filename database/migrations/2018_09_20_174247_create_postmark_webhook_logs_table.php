<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostmarkWebhookLogsTable extends Migration
{
    /**
     * The table name.
     *
     * @var string
     */
    protected $table_name;

    /**
     * Create a new migration instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->table_name = config('postmark-webhooks.log.table_name', config('postmark-webhooks.log.table'));
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->bigIncrements('id');
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
        Schema::dropIfExists($this->table_name);
    }
}
