<?php
/*
 * @Author: doderick
 * @Date: 2020-02-09 23:25:36
 * @LastEditTime : 2020-02-16 23:30:35
 * @LastEditors  : doderick
 * @Description: 帖子模型
 * @FilePath: /tp5/application/forums/model/Topic.php
 */

namespace app\forums\model;

use app\index\model\User;
use think\Model;

class Topic extends Model
{
    // 设置数据表名
    protected $table = 'topics';

    // 自动写入时间
    protected $autoWriteTimestamp = 'datetime';

    // 设置用户关联
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 设置分类关联
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * 切换排序逻辑
     *
     * @param object $query 模型查询器
     * @param string $order 排序方式
     * @return object 模型查询器
     */
    public function scopeWithOrder($query, $order)
    {
        // 根据不同的需求，使用不同的数据读取方式
        switch ($order) {
            case 'recent':
                $query->recent();
                break;

            default:
                $query->recentReplied();
                break;
        }

        // 预防N+1
        return $query->with('user', 'category');
    }

    /**
     * 按照帖子最新发布时间排序
     *
     * @param object $query 模型查询器
     * @return object order后的模型查询器
     */
    public function scopeRecent($query)
    {
        return $query->order('create_time', 'desc');
    }

    /**
     * 按照帖子最新的回复时间排序
     *
     * @param object $query 模型查询器
     * @return object order后的模型查询器
     */
    public function scopeRecentReplied($query)
    {
        return $query->order('update_time', 'desc');
    }
}
