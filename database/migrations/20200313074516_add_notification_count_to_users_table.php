<?php
/*
 * @Author: doderick
 * @Date: 2020-03-13 15:45:48
 * @LastEditTime: 2020-03-16 11:00:40
 * @LastEditors: doderick
 * @Description: 通知表迁移文件
 * @FilePath: /database/migrations/20200313074516_add_notification_count_to_users_table.php
 */

use think\migration\Migrator;
use think\migration\db\Column;

class AddNotificationCountToUsersTable extends Migrator
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
        $table = $this->table('users');
        $table->addColumn('notification_count', 'integer', ['comment'=>'用户通知数量','signed'=>false,'default'=>0])
                ->update();
    }
}
