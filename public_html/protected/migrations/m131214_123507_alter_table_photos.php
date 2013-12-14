<?php

class m131214_123507_alter_table_photos extends CDbMigration
{
	public function up()
	{
        $this->addColumn('{{photos}}', 'is_group', 'int');
	}

	public function down()
	{
        $this->dropColumn('{{photos}}', 'is_group');
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