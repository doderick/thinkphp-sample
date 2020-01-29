<?php
/*
 * @Author: doderick
 * @Date: 2020-01-29 14:56:20
 * @LastEditTime : 2020-01-29 18:08:33
 * @LastEditors  : doderick
 * @Description: 上传验证器
 * @FilePath: /tp5/application/index/validate/UploaderValidator.php
 */

namespace app\index\validate;

use think\File;
use think\Validate;

class UploaderValidator extends Validate
{

    /**
     * 上传图片文件验证
     *
     * @param Object $file 上传图片文件
     * @param Array $rule  验证规则
     * @return Boolean
     */
    public function image($file, $rule)
    {
        if (!($file instanceof File)) {
            return false;
        }

        if ($rule) {
            list($width, $height, $type) = getimagesize($file->getRealPath());

            if (isset($rule['mimes'])) {
                $impageTypes = explode(',', strtolower($rule['mimes']));

                if (!in_array(image_type_to_extension($type, false), $impageTypes)) {
                    $this->error = '必须是 jpeg, bmp, png, gif 格式的图片';
                    return false;
                }
            }

            list($w, $h) = explode(',', $rule['dimensions']);

            if ($width < $w || $height < $h) {
                $this->error = "图片的清晰度不够，宽需要 {$w}px 以上，高需要 {$h}px 以上";
                return false;
            }

            return true;
        }

        return in_array($this->getImageType($file->getRealPath()), [1, 2, 3, 6]);
    }
}
