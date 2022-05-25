<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('price')->nullable();
            $table->unsignedInteger('responsible_user_id');
            $table->unsignedInteger('group_id');
            $table->unsignedInteger('status_id')->nullable();
            $table->unsignedInteger('pipeline_id');
            $table->unsignedInteger('loss_reason_id');
            $table->unsignedInteger('source_id');
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->timestamp('closed_at');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('closest_task_at')->nullable();
            $table->boolean('is_deleted');
            $table->json('custom_fields_values')->nullable();
            $table->unsignedInteger('score')->nullable();
            $table->unsignedInteger('account_id');
            $table->boolean('is_price_modified_by_robot')->nullable();
            $table->json('_embedded')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads');
    }
};
