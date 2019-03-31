<?php

namespace Bonfim\ActiveRecord\Examples\Database\Migrations;

use Bonfim\ActiveRecord\Schema;

class TweetSchema extends Schema
{
    function up()
    {
        $this->create('tweets', function ($table) {
            $table->increments();

            $table
                ->integer('user_id')
//                ->unsigned()
                ->notNull()
                ->references('users', 'id')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->string('content', 240)->notNull();
            $table->timestamps();
        });
    }

    function down()
    {
        echo 'down';
    }
}
