<?php

namespace App\Services;

class FaceRecognitionService
{
    public function verifyFace($photoPath1, $photoPath2)
    {
        // 这里不再进行Python脚本的调用，而是在前端使用JavaScript进行人脸检测和比对
        return ["error" => "Face recognition service not implemented"];
    }
}
