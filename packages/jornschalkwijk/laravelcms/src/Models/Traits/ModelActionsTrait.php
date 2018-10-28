<?php

namespace JornSchalkwijk\LaravelCMS\Models\Traits;

trait ModelActionsTrait
{
    public function hide($keys = null)
    {
        if ($keys != null && is_array($keys)) {

            $this->whereIn($this->primaryKey, $keys)->update(['approved' => 0]);
        } else {
            $this->approved = 0;
            $this->save();
        }
    }
    public function approve($keys = null)
    {
        if($keys != null && is_array($keys)){

            $this->whereIn($this->primaryKey, $keys)->update(['approved' => 1]);
        } else {
            $this->approved = 1;
            $this->save();
        }
    }

    public function trash($keys = null)
    {
        if($keys != null && is_array($keys)){

            $this->whereIn($this->primaryKey, $keys)->update(['trashed' => 1,'approved' => 0]);
        } else {
            $this->trashed = 1;
            $this->approved = 0;
            $this->save();
        }
    }

    public function restore($keys = null)
    {
        if($keys != null && is_array($keys)){

            $this->whereIn($this->primaryKey, $keys)->update(['trashed' => 0,'approved' => 1]);
        } else {
            $this->trashed = 0;
            $this->approved = 1;
            $this->save();
        }
    }

    public function removeMany(array $keys)
    {
        $this->whereIn($this->primaryKey, $keys)->delete();
    }
}
