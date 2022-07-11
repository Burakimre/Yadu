<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventPicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_pictures', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('tag_id');
            $table->timestamps();

            $table->index(["tag_id"], 'fk_event_pictures_eventTags1_idx');
            $table->foreign('tag_id', 'fk_event_eventTags2_idx')
            ->references('id')->on('event_tags')
            ->onDelete('no action')
            ->onUpdate('no action');
        });
        DB::statement("ALTER TABLE event_pictures ADD picture LONGBLOB");
    }
  
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_pictures');
    }
}
