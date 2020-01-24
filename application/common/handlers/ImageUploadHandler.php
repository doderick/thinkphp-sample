<?php
/*
 * @Author: doderick
 * @Date: 2020-01-23 22:36:46
 * @LastEditTime : 2020-01-24 15:35:16
 * @LastEditors  : doderick
 * @Description: 图片上传工具
 * @FilePath: /tp5/application/common/handlers/ImageUploadHandler.php
 */

namespace app\common\handlers;

use think\facade\Env;
use app\common\facade\Str;

class ImageUploadHandler
{
    // 限制上传图片的后缀名
    protected $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

    /**
     * 保存图片
     *
     * @param Object $file          图片对象
     * @param String $folder        保存的文件加
     * @param String $file_prefix   图片名前缀
     * @return Array
     */
    public function save(Object $file, String $folder, String $file_prefix)
    {
        // 获取文件的后缀名，因图片从剪贴板里黏贴时后缀名为空，所以此处确保后缀一直存在
        $extension = strtolower(pathinfo($file->getInfo('name'), PATHINFO_EXTENSION)) ?: 'png';

        // 验证上传文件的是否为图片
        if (!$file->validate(['ext'=>$this->allowed_ext])) {
            return false;
        }

        // 构建存储的文件夹规则
        $folder_name = "uploads/images/{$folder}/" . date("Ym/d", time());

        // 指定文件具体存放的物理路径
        $upload_path = Env::get('root_path') . "public/{$folder_name}";

        // 指定保存的图片文件名，并保证后缀一直存在
        $filename = $file_prefix . '_' . time() . '_' . Str::random(10) . '.' . $extension;

        // 设定文件命名规则，并移动到目标存储路径
        $file->move($upload_path, $filename);

        // 返回文件的url路径
        $fileurl = config('app.app_host') . "/{$folder_name}/{$filename}";

        return [
            'image_path' => $fileurl,
        ];
    }
}
