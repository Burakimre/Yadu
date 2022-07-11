<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_settings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('account_id');

            // Follower
            $table->tinyInteger('FollowNotificationCreateEvent')->default('1');
            $table->tinyInteger('FollowNotificationJoinAndLeaveEvent')->default('1');
            // Your own
            $table->tinyInteger('NotificationEventEdited')->default('1');
            $table->tinyInteger('NotificationEventDeleted')->default('1');
            // Participant
            $table->tinyInteger('NotificationJoinAndLeaveEvent')->default('1');
            // Mail language preference
            $table->string('LanguagePreference')->default('nl');

            $table->timestamps();

            $table->foreign('account_id', 'fk_settings_accounts1_idx')
                ->references('id')->on('accounts')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_settings');
    }
}
