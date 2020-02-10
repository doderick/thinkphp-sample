<?php
/*
 * @Author: doderick
 * @Date: 2020-02-09 22:05:35
 * @LastEditTime : 2020-02-09 23:44:37
 * @LastEditors  : doderick
 * @Description: 帖子建表文件
 * @FilePath: /tp5/database/migrations/20200209220535_create_topics_table.php
 */

use think\migration\Migrator;
use think\migration\db\Column;

class CreateTopicsTable extends Migrator
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
        $table = $this->table('topics', ['engine'=>'innoDB', 'signed'=>false]);
        $table->addColumn('title',              'string',   ['comment'=>'帖子标题'])
              ->addColumn('body',               'text',     ['comment'=>'帖子内容'])
              ->addColumn('user_id',            'integer',  ['comment'=>'用户ID'])
              ->addColumn('category_id',        'integer',  ['comment'=>'分类ID'])
              ->addColumn('reply_count',        'integer',  ['comment'=>'回复数量', 'default'=>0])
              ->addColumn('view_count',         'integer',  ['comment'=>'查看总数', 'default'=>0])
              ->addColumn('last_reply_user_id', 'integer',  ['comment'=>'最后回复的用户ID', 'default'=>0])
              ->addColumn('order',              'integer',  ['comment'=>'可用来做排序使用', 'default'=>0])
              ->addColumn('excerpt',            'text',     ['comment'=>'文章摘要，SEO 优化时使用', 'null'=>true])
              ->addColumn('slug',               'string',   ['comment'=>'SEO 友好的 URI', 'null'=>true])
              ->addTimestamps()
              ->addIndex('title')
              ->addIndex('user_id')
              ->addIndex('category_id')
              ->addIndex('reply_count')
              ->addIndex('view_count')
              ->addIndex('last_reply_user_id')
              ->create();
    }
}
