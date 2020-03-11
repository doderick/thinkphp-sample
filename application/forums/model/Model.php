<?php
/*
 * @Author: doderick
 * @Date: 2020-03-11 15:53:29
 * @LastEditTime: 2020-03-11 20:47:02
 * @LastEditors: doderick
 * @Description: 基类
 * @FilePath: /application/forums/model/Model.php
 */

namespace app\forums\model;

use think\Model as BaseModel;

class Model extends BaseModel
{
    /**
     * 按照发布时间倒序排列
     *
     * @param  $query
     * @return void
     */
    public function scopeRecent($query)
    {
        return $query->order('id', 'desc');
    }
}
