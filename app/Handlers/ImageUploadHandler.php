<?php

namespace App\Handlers;

use Image;

class ImageUploadHandler
{
    protected $allowed_ext = ['png', 'jpg', 'jpeg'];



    public function saveUserAvatar($file, $userID)
    {
        $fileName = $userID . '_' . date('Ymd', time()) . '_' . time() . '_' . str_random(10);

        $result = $this->save($file, 'avatars', $fileName);
        $savePath = $result['savePath'];
        // 裁剪图片
        $this->resize($savePath, 'width_square', 200);
        return  $result;
    }

    public function saveTopicImages($file, $userID)
    {
        $fileName = $userID . '_' . date('Ymd', time()) . '_' . time() . '_' . str_random(10);

        $result = $this->save($file, 'topicImages', $fileName);
        $savePath = $result['savePath'];
        // 裁剪图片
        $this->resize($savePath, 'width', 500);
        return  $result;
    }

    /**
     * file：文件对象
     * folder：上传文件，image下的模块文件夹
     * file_prefix：文件名前缀，防止文件名冲突，引发冲突
     */
    private function save($file, $folder, $fileName)
    {
        // 文件目录
        $folder_name = "/uploads/images/$folder/" . date('Ym', time());

        // 上传目录
        $upload_path = public_path() . '/' . $folder_name;

        $extension = strtolower($file->getClientOriginalExtension() ?: ' png');

        if (!in_array($extension, $this->allowed_ext)) {
            return false;
        }

        $fileName = $fileName . '.' . $extension;

        $file->move($upload_path, $fileName);


        return [
            'path' => $folder_name . '/' . $fileName,
            'savePath' => $upload_path . '/' . $fileName
        ];
    }

    /**
     * file_path:文件绝对路径
     * model：裁剪模式 
     * value：裁剪数值
     */
    private function resize($file_path, $model, $value)
    {
        // 先实例化，传参是文件的磁盘物理路径
        $image = Image::make($file_path);

        $width = $image->width(); //1024
        $height = $image->height(); //582

        switch ($model) {
            case 'width': //以宽为准，等比例裁剪                
                $height = $width > $value ? floor(($value * $height) / $width) : $height;
                $width = $width > $value ? $value : $width;
                break;
            case 'width_square': //以宽为准，一比一裁剪
                $width = $width > $value ? $value : $width;
                $height = $width;
                break;
            case 'height': //以高为准，等比例裁剪
                $width = $height > $value ? floor(($value * $width) / $height) : $width;
                $height = $height > $value ? $value : $height;
                break;
            case 'height_square': //以高为准，一比一裁剪
                $height = $height > $value ? $value : $height;
                $width = $height;
                break;
        }

        // 进行大小调整的操作
        $image->resize($width, $height);

        // 对图片修改后进行保存
        $image->save();
    }
}
