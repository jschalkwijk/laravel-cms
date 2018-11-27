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

    public function __construct($bucket = "default",Request $r)
    {
        $this->r = $r;
        if ($r->session()->exists($bucket)) {
            $this->bucket = $bucket;
        } else {
            $r->session()->put($bucket);
        }

        $r->session()->save();
        // Create new session ['default']
//        if(!isset($_SESSION[$bucket])){
//            $_SESSION[$bucket] = [];
//        }

        $this->bucket = $bucket;
    }

    public function set($index,$value)
    {
        $item[$index] = $value;
//        foreach ($item as $key => $value){
//            Session::get($this->bucket)[$key] = $value;
//        }

        // Set new product to current bucket session which holds the ID as key, and as values, the ID and quantity
//        $_SESSION['default'] = ['10' => [ 'product_id' => 10, 'quantity' => 1,]];
//        $_SESSION[$this->bucket][$index] = $value;

//        $bucket = Session::get($this->bucket);
//        $bucket[$index] = $value;
//        Session::put($this->bucket,$bucket);
        Session::put($this->bucket.'.'.$index, $value);
//        $this->r->session()->push($this->bucket.'.'.$index, $value );
        print_r($this->r->session()->get('default'));
//        print_r($_SESSION);
//        die('oops');
    }

    public function get($index)
    {
        // Get a product by it's ID, if it exists.
        if(!$this->exists($index)) {
            return null;
        }

        return $_SESSION[$this->bucket][$index];
    }

    public function exists($index)
    {
        // Check if a product is in the current bucket session
        // $_SESSION['default']['10']
        return isset($_SESSION[$this->bucket][$index]);
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
            unset($_SESSION[$this->bucket][$index]);
        }
    }

    public function clear(){
        // Remove entire bucket session by it's name
        unset($_SESSION[$this->bucket]);
    }

    public function count(){
        // ount all bucket items in the session
        return count($this->all());
    }
    public static function getByName ($bucket){
        return new SessionStorage($bucket);
    }
}

?>