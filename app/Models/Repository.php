<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    protected $fillable = ['name', 'description'];
    
    protected function sanitizeName($name) {
        return strtolower(str_replace(' ', '-', $name));
    }

    public function setNameAttribute($value) {
        $name = $this->sanitizeName($value);
        $this->attributes['name'] = $name;
        $this->attributes['path'] = config('git-manage.repositories_base_path') . DIRECTORY_SEPARATOR . $name;
    }
}
