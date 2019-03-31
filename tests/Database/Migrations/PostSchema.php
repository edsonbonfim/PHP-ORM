<?php

namespace Bonfim\ActiveRecord\Tests\Database\Migrations;

use Bonfim\ActiveRecord\Schema;
use Bonfim\ActiveRecord\Table;

class PostSchema extends Schema
{
    public function up()
    {
        $this->create('posts', function (Table $table) {
            $table->increments();
            $table
                ->string('title')
                ->notNull();
            $table
                ->string('author_name')
                ->notNull();
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->drop('posts');
    }
}
