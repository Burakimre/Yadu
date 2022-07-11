<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlockedUsersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'blocked_users';

    /**
     * Run the migrations.
     * @table blocked_users
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('account_id');
            $table->unsignedInteger('blockedAccount_id');
            $table->timestamps();

            $table->index(["account_id"], 'fk_accounts_has_accounts_accounts1_idx');

            $table->index(["blockedAccount_id"], 'fk_accounts_has_accounts_accounts2_idx');

            $table->unique(["account_id", "blockedAccount_id"], 'account_id_blockedAccount_id_UNIQUE');


            $table->foreign('account_id', 'fk_accounts_has_accounts_accounts1_idx')
                ->references('id')->on('accounts')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('blockedAccount_id', 'fk_accounts_has_accounts_accounts2_idx')
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
