<?php
namespace JornSchalkwijk\LaravelCMS\Exeptions\Cart;
use Exception;

class QuantityExceededException extends Exception
{
    protected $message = "You have added the maximum stock for this item";
}

?>