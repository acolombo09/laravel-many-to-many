<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technology extends Model {
    use HasFactory;

    // definisco la relazione many to many con projects
    public function projects() {
        return $this->belongsToMany(Project::class);
    }
}
