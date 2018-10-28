<?php

namespace JornSchalkwijk\LaravelCMS\Models;

use JornSchalkwijk\LaravelCMS\Models\Traits\ModelActionsTrait;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use ModelActionsTrait;
    protected $primaryKey = 'contact_id';
    protected $fillable = ['title','description'];
    public $table = "contacts";

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    # Getters
    public function id()
    {
        return $this->contact_id;
    }

}
