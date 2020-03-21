<?php

use think\migration\Migrator;
use think\migration\db\Column;

class AddActivationToUsersTable extends Migrator
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
    public function up()
    {
        // add column activation_token, is_activated
        $table = $this->table('users');
        $table->addColumn('activation_token', 'string', ['null'=>true, 'comment'=>'激活令牌'])
                ->addColumn('is_activated', 'boolean', ['default'=>false, 'comment'=>'用户激活标识'])
                ->update();
    }

    public function down()
    {
        // remove column activation_token, is_activated
        $table = $this->table('users');
        $table->removeColumn('activation_token')
                ->removeColumn('is_activated')
                ->save();
    }
}
