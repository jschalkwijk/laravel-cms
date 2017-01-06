<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $primaryKey = "permission_id";

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
