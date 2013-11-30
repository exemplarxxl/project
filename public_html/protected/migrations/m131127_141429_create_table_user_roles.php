<?php

class m131127_141429_create_table_user_roles extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{user_roles}}', array(
            'id' => 'pk',
            'name' => 'string',
            'title' => 'string'
        ));

        $this->insert('{{user_roles}}', array(
            'name' => 'admin',
            'title' => 'Администратор'
        ));

        $this->insert('{{user_roles}}', array(
            'name' => 'user',
            'title' => 'Пользователь'
        ));
	}

	public function down()
	{
		$this->dropTable('{{user_roles}}');
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