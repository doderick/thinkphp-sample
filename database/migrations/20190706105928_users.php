<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Users extends Migrator
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
        $table = $this->table('users', ['engine'=>'InnoDB', 'signed'=>false]);
        $table->addColumn('name',              'string',    ['comment'=>'用户名'])
              ->addColumn('email',             'string',    ['comment'=>'用户邮箱'])
              ->addColumn('email_verified_at', 'timestamp', ['null'=>true, 'comment'=>'用户邮箱验证时间'])
              ->addColumn('password',          'string',    ['limit'=>60, 'comment'=>'用户登录密码'])
              ->addColumn('rememberToken',     'string',    ['comment'=>'记住我'])
              ->addTimestamps()
              ->addIndex(['email'], ['unique'=>true])
              ->create();
    }
}
