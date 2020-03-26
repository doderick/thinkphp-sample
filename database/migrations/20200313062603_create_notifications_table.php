<?php
/*
 * @Author: doderick
 * @Date: 2020-03-13 14:26:13
 * @LastEditTime: 2020-03-26 22:14:34
 * @LastEditors: doderick
 * @Description: 通知表迁移文件
 * @FilePath: /database/migrations/20200313062603_create_notifications_table.php
 */

use think\migration\Migrator;
use think\migration\db\Column;

class CreateNotificationsTable extends Migrator
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
        $table = $this->table('notifications', ['engine'=>'innoDB', 'id'=>false, 'primary_key'=>'id']);
        $table->addColumn('id',                 'uuid',         ['comment'=>'通知UUID'])
                ->addColumn('type',             'string',       ['comment'=>'通知类型'])
                ->addMorphs('notifiable')
                ->addColumn('data',             'text',         ['comment'=>'通知消息'])
                ->addColumn('read_time',        'timestamp',    ['comment'=>'用户阅读时间', 'null'=>true])
                ->addTimestamps()
                ->create();
    }
}
