<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable=[
'Task_name',
'Description',
'Status',
'Due_time',
'User_id',
'Result',

    ];
    protected $casts = [
'Task_name'=>'string',
'Description'=>'string',
'Status'=>'string',
'User_id'=>'integer',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Scope to filter tasks based on their status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $data
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByTask($query, $data)
    {
        if ($data === null) {
            return $query->select(['id', 'Task_name', 'Description', 'Due_time'])
                         ->where('Status', null);
        } else {
            return $query->select(['id', 'Task_name', 'Description', 'result'])
                         ->where('Status', $data);
        }


    }

}
