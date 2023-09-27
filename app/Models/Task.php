<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Task extends Model
{
    use HasFactory;
    use LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    protected $fillable = [
        'name', 'description', 'status', 'type', 'creator', 'deadline','priority'
    ];
    protected $dates = ['deadline'];


    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, TaskUser::class, 'task_id', 'id', 'id', 'user_id');
    }

    public function assigUser()
    {
        return  $this->hasOne(TaskUser::class);
    }

}
