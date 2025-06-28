<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    protected $fillable = ['title', 'filename'];
    protected $table = 'audios'; // (إذا بغيت تأكد الاسم)

}
