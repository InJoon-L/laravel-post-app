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
}
