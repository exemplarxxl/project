<?php

class m131214_114753_alter_table_albums extends CDbMigration
{
	public function up()
	{
        $this->addColumn('{{albums}}', 'menu', 'int');
	}

	public function down()
	{
		$this->dropColumn('{{albums}}', 'menu');
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