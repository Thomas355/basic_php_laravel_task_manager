<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //each project belongs to a specific project and stores the binary value completed alongside its title 

    protected $fillable = ['title', 'completed', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
