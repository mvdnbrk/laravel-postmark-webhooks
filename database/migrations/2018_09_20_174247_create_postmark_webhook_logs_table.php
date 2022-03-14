<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostmarkWebhookLogsTable extends Migration
{
    /** @var string */
    protected $table_name;

    public function __construct()
    {
        $this->table_name = config('postmark-webhooks.log.table_name', config('postmark-webhooks.log.table'));
    }

    public function up(): void
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('message_id', 100)->nullable();
            $table->string('record_type', 32);
            $table->string('email')->index();
            $table->json('payload');
            $table->dateTime('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->table_name);
    }
}
