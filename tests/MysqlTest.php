<?php

declare(strict_types=1);

namespace Bonfim\ActiveRecord;

class MysqlTest extends \PHPUnit\Framework\TestCase
{
    protected function SetUp(): void
    {
        ActiveRecord::config('mysql:host=localhost;dbname=demo', 'root', 'batatapalha123');
    }

    public function testEmptyAll()
    {
        $this->assertCount(0, Post::all());
    }

    public function testEmptySelect()
    {
        $this->assertCount(0, Post::select(['author_name']));
        $this->assertCount(0, Post::select(['title'], 'WHERE `id` = ?', [0]));
    }

    public function testEmptyFind()
    {
        $this->assertCount(0, Post::find('WHERE `id` = ?', [0]));
    }

    public function testSave()
    {
        for ($i = 0; $i < 20; $i++) {
            $post = new Post();
            $post->title = "Post title";
            $post->author_name = "Edson Onildo";
            $this->assertEquals(1, $post->save());
        }
    }

    public function testAll()
    {
        $this->assertCount(20, Post::all());
    }

    public function testSelect()
    {
        $this->assertCount(20, Post::select(['title'], 'WHERE `title` = ?', ['Post title']));
    }

    public function testFind()
    {
        $post = Post::find('WHERE `title` = ?', ['Post title']);
        $this->assertCount(20, $post);
    }

    public function testUpdate()
    {
        $post = Post::all()[0];
        $post->title = 'Post title updated';
        $this->assertEquals(1, $post->update());
        $this->assertCount(1, Post::find('WHERE `title` = ?', ['Post title updated']));
    }

    public function testDelete()
    {
        $post = Post::find('WHERE `title` = ?', ['Post title updated']);
        $this->assertCount(1, $post);
        $this->assertEquals(1, $post[0]->delete());
    }

    public function testDeleteAll()
    {
        $this->assertEquals(19, Post::deleteAll());
    }
}
