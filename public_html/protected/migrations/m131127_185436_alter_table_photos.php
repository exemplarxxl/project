<?php

class m131127_185436_alter_table_photos extends CDbMigration
{
	public function up()
	{
        $this->addColumn('{{photos}}', 'group_id', 'int');
        $this->addColumn('{{photos}}', 'sort_group', 'int');
	}

	public function down()
	{
		$this->dropColumn('{{photos}}', 'group_id');
        $this->dropColumn('{{photos}}', 'sort_group');
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