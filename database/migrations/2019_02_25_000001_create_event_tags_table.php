<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateEventTagsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'event_tags';
    /**
     * Run the migrations.
     * @table event_tags
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('tag', 25);
            $table->timestamps();
        });
        DB::statement("ALTER TABLE event_tags ADD imageDefault LONGBLOB");
        DB::statement("ALTER TABLE event_tags ADD imageSelected LONGBLOB");
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
