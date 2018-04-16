<?php

namespace CMS\Models;

use Illuminate\Http\Request;

trait UserActions
{
    private function Actions(Request $r,$model)
    {
        if(isset($r['trash-selected'])){
            Action::trash($model,$r['checkbox']);
        }
        if(isset($r['approve-selected'])){

            Action::approve($model,$r['checkbox']);
        }
        if(isset($r['hide-selected'])){

            Action::hide($model,$r['checkbox']);
        }
        if(isset($r['restore-selected'])){

            Action::restore($model,$r['checkbox']);
        }
        if(isset($r['delete-selected'])){
            Action::remove($model,$r['checkbox']);
        }
    }

}
