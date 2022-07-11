<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountHasFollowersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'account_has_followers';

    /**
     * Run the migrations.
     * @table account_has_followers
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('account_id');
            $table->unsignedInteger('follower_id');
            $table->string('verification_string');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();

            $table->index(["account_id"], 'fk_account_has_account_account2_idx');

            $table->index(["follower_id"], 'fk_account_has_account_account1_idx');

            $table->unique(["account_id", "follower_id"], 'account_id_follower_id_UNIQUE');


            $table->foreign('follower_id', 'fk_account_has_account_account1_idx')
                ->references('id')->on('accounts')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('account_id', 'fk_account_has_account_account2_idx')
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
       Schema::dropIfExists($this->tableName);
     }
}
