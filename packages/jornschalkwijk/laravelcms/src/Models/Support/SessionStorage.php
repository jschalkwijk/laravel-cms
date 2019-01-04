<?php
// implements abstract class StorageInterface
namespace JornSchalkwijk\LaravelCMS\Models\Support;

use Illuminate\Support\Facades\Session;
use JornSchalkwijk\LaravelCMS\Models\Support\StorageInterface as Store;
use Countable;
use Illuminate\Http\Request;
class SessionStorage implements Store, Countable
{
    protected $bucket;
    protected $r;

    public function __construct(Request $r,$bucket = "default")
    {
        $this->r = $r;
        if ($r->session()->exists($bucket)) {
            $this->r->bucket = $bucket;
        } else {
            $this->r->session()->put($bucket);
        }
// this creates problems when using a class that need this class. it will save the session so old data is maintained.
//        $this->r->session()->save();

        $this->bucket = $bucket;
    }

    public function set($index,$value)
    {
        $item[$index] = $value;

        // Set new product to current bucket session which holds the ID as key, and as values, the ID and quantity
//        $_SESSION['default'] = ['10' => [ 'product_id' => 10, 'quantity' => 1,]];
//        $_SESSION[$this->bucket][$index] = $value;

        $this->r->session()->put($this->bucket.'.'.$index, $value);

//        $this->r->session()->save();
    }

    public function get($index)
    {
        // Get a product by it's ID, if it exists.
        if(!$this->exists($index)) {
            return null;
        }

        return $this->r->session()->get($this->bucket)[$index];
    }

    public function exists($index)
    {
        // Check if a product is in the current bucket session
        // $_SESSION['default']['10']
        return $this->r->session()->exists($this->bucket.'.'.$index);
    }

    public function all()
    {
        // returns all the products in the bucket session as array
        return $this->r->session()->get($this->bucket);
    }

    public function unsetIndex($index)
    {
        // Remove a product from the session by it's ID, if it exist
        if($this->exists($index)){
            $this->r->session()->pull($this->bucket.'.'.$index);
//            $this->r->session()->save();
        }
    }

    public function clear(){
        // Remove entire bucket session by it's name
        $this->r->session()->forget($this->bucket);
//        $this->r->session()->save();
    }

    public function count(){
        // count all bucket items in the session
        if(empty($this->all())) {
            return 0;
        }
        return count($this->all());
    }
    public static function getByName ($bucket){
        return new SessionStorage($bucket);
    }
}

?>