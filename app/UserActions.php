<?php

namespace CMS;

use Illuminate\Http\Request;

trait UserActions
{
    private function Actions(Request $r,$table)
    {
        if(isset($r['trash-selected'])){
            Action::trash($r,$table);
        }
        if(isset($r['approve-selected'])){

            Action::approve($r,$table);
        }
        if(isset($r['hide-selected'])){

            Action::hide($r,$table);
        }
        if(isset($r['restore-selected'])){

            Action::restore($r,$table);
        }
    }

}
