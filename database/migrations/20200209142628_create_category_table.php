<?php
/*
 * @Author: doderick
 * @Date: 2020-02-09 14:26:28
 * @LastEditTime : 2020-02-09 17:23:16
 * @LastEditors  : doderick
 * @Description: 帖子分类建表文件
 * @FilePath: /tp5/database/migrations/20200209142628_create_category_table.php
 */

use think\migration\Migrator;
use think\migration\db\Column;

class CreateCategoryTable extends Migrator
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
        $table = $this->table('categories', ['engine'=>'innoDB', 'signed'=>false]);
        $table->addColumn('name',           'string',   ['comment'=>'分类名称'])
              ->addColumn('description',    'text',     ['comment'=>'分类描述'])
              ->addColumn('topic_count',    'integer',  ['comment'=>'分类下帖子数', 'null'=>true, 'default'=>0])
              ->addTimestamps()
              ->addIndex('name')
              ->create();
    }
}
