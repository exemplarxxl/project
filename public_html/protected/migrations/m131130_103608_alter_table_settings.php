<?php

class m131130_103608_alter_table_settings extends CDbMigration
{
	public function up()
	{
        $this->addColumn('{{settings}}', 'default_meta_title', 'string');
        $this->addColumn('{{settings}}', 'default_meta_description', 'string');
        $this->addColumn('{{settings}}', 'default_meta_keywords', 'string');
	}

	public function down()
	{
		$this->dropColumn('{{settings}}', 'default_meta_title');
        $this->dropColumn('{{settings}}', 'default_meta_description');
        $this->dropColumn('{{settings}}', 'default_meta_keywords');
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