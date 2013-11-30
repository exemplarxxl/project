<?php

class m131124_181336_create_table_admins extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{users}}', array(
            'id' => 'pk',
            'role_id' => 'int',
            'name' => 'string',
            'login' => 'string',
            'password' => 'string',
            'email' => 'string',
            'phone' => 'string',
            'last_activity' => 'datetime',
            'last_visit' => 'datetime',
        ));



        $this->insert('{{users}}', array(
            'role_id' => 1,
            'name' => 'Андрей',
            'login' => 'admin',
            'password' => '82zczrnhw',
            'email' => 'anders_on2012@list.ru',
            'phone' => '79092567651',
            'last_activity' => 'datetime',
            'last_visit' => 'datetime',
        ));

        $this->insert('{{users}}', array(
            'role_id' => 1,
            'name' => 'Юрий',
            'login' => 'superuser',
            'password' => '82zczrnhw',
            'email' => 'yborschev@gmail.com',
            'phone' => '79536401515',
            'last_activity' => 'datetime',
            'last_visit' => 'datetime',
        ));


	}

	public function down()
	{
		$this->dropTable('{{users}}');
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