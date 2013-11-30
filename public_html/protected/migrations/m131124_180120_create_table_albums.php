<?php

class m131124_180120_create_table_albums extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{albums}}', array(
            'id' => 'pk',
            'root' => 'int',
            'lft' => 'int',
            'rgt' => 'int',
            'level' => 'int',
            'parent_id' => 'int',
            'is_published' => 'int',
            'title' => 'string',
            'description' => 'text',
            'translit_title' => 'string',
            'meta_title' => 'string',
            'meta_description' => 'string',
            'meta_keywords' => 'string',
            'sort' => 'int',
            'image' => 'string'
        ));
	}

	public function down()
	{
		$this->dropTable('{{albums}}');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}