<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function imagePath()
    {
        $path = env('IMAGE_PATH', '/storage/images/');
        $imageFile = $this->image ?? 'noImage.png';

        return  $path . $imageFile;
    }

    // 외래키 정의 1대n n쪽에서 정의시 단수 post->user 접근 가능
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
