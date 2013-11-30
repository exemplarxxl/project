<?php

class m131124_151551_create_table_settings extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{settings}}', array(
            'id' => 'pk',
            'phone' => 'string',
            'mobile' => 'string',
            'email' => 'string',
            'address' => 'string'
        ));

        $this->insert('{{settings}}',array(
            'phone' => '8 (4942) 467-127',
            'mobile' => '8 (909) 256-76-51',
            'email' => 'greenmod@inbox.ru',
        ));

	}

	public function down()
	{
		$this->dropTable('{{settings}}');
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