<?php
/*
 * @Author: doderick
 * @Date: 2020-03-09 22:53:06
 * @LastEditTime: 2020-03-10 09:47:25
 * @LastEditors: doderick
 * @Description: slug 翻译队列任务
 * @FilePath: /application/forums/job/SlugTranslate.php
 */

namespace app\forums\job;

use think\queue\job;
use app\common\facade\Str;
use app\common\handlers\BaiduTranslateHandler;

class SlugTranslate
{
    public function fire(Job $job, $topic)
    {

        // 对title进行翻译，生成slug
        $topic['slug'] = Str::slug(app(BaiduTranslateHandler::class)->translate($topic['title']));

        // 如果生成的slug正好与路由冲突，则放弃此slug
        if (trim($topic['slug']) === 'edit') {
            $topic['slug'] = '';
        }

        // 保存至数据库
        \think\DB::table('topics')
            ->where('id', $topic['id'])
            ->data(['slug'=>$topic['slug']])
            ->update();

        if ($job->attempts() > 3) {
            //通过这个方法可以检查这个任务已经重试了几次了
        }


        // 任务执行完成后删除任务
        $job->delete();

        // 也可以重新发布这个任务
        // $job->release($delay); //$delay为延迟时间

    }

    public function failed($data)
    {
        // 任务失败后执行
    }
}
