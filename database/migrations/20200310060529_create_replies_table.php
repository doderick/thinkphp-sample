<?php
/*
 * @Author: doderick
 * @Date: 2020-03-10 14:05:27
 * @LastEditTime: 2020-03-10 21:48:56
 * @LastEditors: doderick
 * @Description: 回帖表迁移文件
 * @FilePath: /database/migrations/20200310060529_create_replies_table.php
 */

use think\migration\Migrator;
use think\migration\db\Column;

class CreateRepliesTable extends Migrator
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
        $table = $this->table('replies', ['engine'=>'innoDB', 'signed'=>false]);
        $table->addColumn('topic_id',  'integer', ['comment'=>'所属帖子ID'])
                ->addColumn('user_id', 'integer', ['comment'=>'所属用户ID'])
                ->addColumn('content', 'text',    ['comment'=>'回帖内容'])
                ->addTimestamps()
                ->addIndex('topic_id')
                ->addIndex('user_id')
                ->create();
    }
}
