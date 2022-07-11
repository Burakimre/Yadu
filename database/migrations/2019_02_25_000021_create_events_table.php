<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'events';
  
    /**
     * Run the migrations.
     * @table events
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('tag_id');
            $table->unsignedInteger('location_id');
            $table->unsignedInteger('owner_id')->nullable();
            $table->unsignedInteger('event_picture_id');
            $table->string('eventName', 45);
            $table->dateTime('startDate');
            $table->unsignedInteger('numberOfPeople');
            $table->text('description');
            $table->tinyInteger('isHighlighted')->default('0');
            $table->tinyInteger('isDeleted')->default('0');
            $table->timestamps();

            $table->index(["location_id"], 'fk_activity_Location1_idx');

            $table->index(["tag_id"], 'fk_event_eventTags1_idx');

            $table->index(["owner_id"], 'fk_activity_accounts1_idx');

            $table->index(["event_picture_id"], 'fk_event_event_pictures_idx');

            $table->foreign('location_id', 'fk_activity_Location1_idx')
                ->references('id')->on('locations')
                ->onDelete('no action')
                ->onUpdate('no action');
          
            $table->foreign('owner_id', 'fk_activity_accounts1_idx')
                ->references('id')->on('accounts')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('tag_id', 'fk_event_eventTags1_idx')
                ->references('id')->on('event_tags')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('event_picture_id', 'fk_event_pictures1_idx')
                ->references('id')->on('event_pictures')
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
        Schema::dropIfExists($this->tableName);
    }
}
