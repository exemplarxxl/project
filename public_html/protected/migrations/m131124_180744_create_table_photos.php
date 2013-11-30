<?php

class m131124_180744_create_table_photos extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{photos}}', array(
            'id' => 'pk',
            'album_id' => 'int',
            'is_published' => 'int',
            'sort' => 'int',
            'image' => 'string',
            'title' => 'string',
            'parent_id' => 'int'
        ));
	}

	public function down()
	{
        $this->dropTable('{{photos}}');
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