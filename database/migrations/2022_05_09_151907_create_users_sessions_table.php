<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_sessions', static function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->string('refresh_token', 255)->nullable(false);
            $table->string('ip', 255)->nullable(false);
            $table->string('user_agent', 255)->nullable(false);
            $table->enum('device', ['desktop', 'mobile', 'mobile_ios', 'mobile_android'])->nullable(false);
            $table->timestamp('expires_in')->nullable(false);

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->index('refresh_token');
            $table->index('user_id');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_sessions');
    }
}
