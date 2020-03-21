<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreatePasswordResetsTable extends Migrator
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
        // create the table
        $table = $this->table('password_resets');
        $table->addColumn('email',      'string',    ['comment'=>'用户邮箱'])
                ->addColumn('token',      'string',    ['comment'=>'密码重置令牌'])
                ->addColumn('created_at', 'timestamp', ['comment'=>'密码重置令牌的创建时间'])
                ->addIndex('email')
                ->addIndex('token')
                ->create();

    }
}
