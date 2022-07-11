<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerificationLinksTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'verification_links';

    /**
     * Run the migrations.
     * @table verification_links
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('account_id');
            $table->dateTime('dateOfVerification')->nullable();
            $table->timestamps();

            $table->index(["account_id"], 'fk_email_verification_account1_idx');


            $table->foreign('account_id', 'fk_email_verification_account1_idx')
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
