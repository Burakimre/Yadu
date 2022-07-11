<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'accounts';

    /**
     * Run the migrations.
     * @table accounts
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('accountRole', 10)->default('User');
            $table->string('gender', 15)->nullable();
            $table->string('email');
            $table->string('password');
            $table->string('firstName', 255);
            $table->string('middleName', 255)->nullable();
            $table->string('lastName', 255)->nullable();
            $table->date('dateOfBirth')->nullable();
            $table->tinyInteger('doForcePasswordChange')->default('0');
            $table->tinyInteger('doForceLogout')->default('0');
            $table->tinyInteger('isDeleted')->default('0');
            $table->dateTime('email_verified_at')->nullable();
            $table->longText('bio')->nullable();
            $table->string('api_token', 60)->unique()->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->enum('followerVisibility', ['public', 'follower', 'private'])->default('private');
            $table->enum('followingVisibility', ['public', 'follower', 'private'])->default('private');
            $table->enum('infoVisibility', ['public', 'follower', 'private'])->default('private');
            $table->enum('eventsVisibility', ['public', 'follower', 'private'])->default('private');
            $table->enum('participatingVisibility', ['public', 'follower', 'private'])->default('private');

            $table->index(["accountRole"], 'fk_accounts_accountRoles1_idx');

            $table->index(["gender"], 'fk_accounts_gender1_idx');

            $table->unique(["email"], 'email_UNIQUE');


            $table->foreign('gender', 'fk_accounts_gender1_idx')
                ->references('gender')->on('genders')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('accountRole', 'fk_accounts_accountRoles1_idx')
                ->references('role')->on('account_roles')
                ->onDelete('no action')
                ->onUpdate('no action');
        });

        DB::statement("ALTER TABLE accounts ADD avatar MEDIUMBLOB");
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
