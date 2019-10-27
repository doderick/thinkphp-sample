<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateStatuesTable extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('statuses', ['engine'=>'InnoDB', 'signed'=>false]);
        $table->addColumn('content',    'text',         ['comment'=>'微博内容'])
              ->addColumn('user_id',    'integer',      ['comment'=>'微博作者'])
              ->addTimestamps()
              ->addIndex('create_time')
              ->create();
    }
}
