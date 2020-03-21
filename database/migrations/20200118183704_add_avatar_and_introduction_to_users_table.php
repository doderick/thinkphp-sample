<?php
/*
 * @Author: doderick
 * @Date: 2020-01-18 18:37:04
 * @LastEditTime : 2020-01-18 22:29:34
 * @LastEditors  : doderick
 * @Description:数据库迁移文件，向users表添加avatar（头像）和introduction（简介）字段
 * @FilePath: /database/migrations/20200118183704_add_avatar_and_introduction_to_users_table.php
 */

use think\migration\Migrator;
use think\migration\db\Column;

class AddAvatarAndIntroductionToUsersTable extends Migrator
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
        // add column avatar and introduction
        $table = $this->table('users');
        $table->addColumn('avatar', 'string', ['comment'=>'用户头像路径', 'null'=>true])
                ->addColumn('introduction', 'string', ['comment'=>'用户简介', 'null'=>true])
                ->update();
    }
}
