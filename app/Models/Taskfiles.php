<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taskfiles extends Model
{
    use HasFactory;
    protected $table = 'task_files';

    protected $fillable = [
        'name','task_id'
    ];



}
