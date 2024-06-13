<?php

use yii\db\Migration;

/**
 * Class m240613_103648_blog
 */
class m240613_103648_blog extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
// Create user table
$this->createTable('user', [
    'ID' => $this->primaryKey(),
    'username' => $this->string()->notNull(),
    'password' => $this->string(),
    'token' => $this->string(),
    'authkey' => $this->string(),
    'email' => $this->string(),
]);

// Create post table
$this->createTable('post', [
    'ID' => $this->primaryKey(),
    'created_by' => $this->integer()->notNull(),
    'body' => $this->text(),
    'created_at' => $this->dateTime(),
    'title' => $this->string(),
    'image' => $this->string(),
]);

// Add foreign key for table `post`
$this->addForeignKey(
    'fk-post-created_by', // Name of the foreign key
    'post', // Table to add the foreign key to
    'created_by', // Column in the post table to be linked
    'user', // Target table that the foreign key references
    'ID', // Column in the user table that the foreign key references
    'CASCADE', // On delete action
    'CASCADE' // On update action
);

// Create comment table
$this->createTable('comment', [
    'ID' => $this->primaryKey(),
    'created_by' => $this->integer()->notNull(),
    'body' => $this->text(),
    'created_at' => $this->dateTime(),
    'post_id' => $this->integer()->notNull(),
]);

// Add foreign keys for table `comment`
$this->addForeignKey(
    'fk_comment-created-by',
    'comment',
    'created_by',
    'user',
    'ID',
    'CASCADE', // On delete action
    'CASCADE' // On update action
);

$this->addForeignKey(
    'fk_comment-post-id',
    'comment',
    'post_id',
    'post',
    'ID',
    'CASCADE', // On delete action
    'CASCADE' // On update action
);

// Insert initial data into user table
$this->insert('user', [
    'username' => 'Guest',
    'password' => '',
    'token' => '',
    'authkey' => '',
    'email' => ''
]);

$this->insert('user', [
    'username' => 'admin',
    'password' => 'admin',
    'token' => 'admin',
    'authkey' => 'admin',
    'email' => 'admin@gmail.com'
]);

$this->insert('post', [
    'created_by' => 2,
    'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
    'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
    'title' => 'Lorem Ipsum',
    'image' => 'uploads/wind.jpg',
]);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop foreign keys
        $this->dropForeignKey('fk_comment-post-id', 'comment');
        $this->dropForeignKey('fk_comment-created-by', 'comment');
        $this->dropForeignKey('fk-post-created_by', 'post');

        // Drop tables
        $this->dropTable('comment');
        $this->dropTable('post');
        $this->dropTable('user');
    }

    
}
