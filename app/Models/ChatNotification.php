<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatNotification extends Model
{
    //use HasFactory;
    protected $fillable = [ 'user1','user2', 'last_notification'];
}
