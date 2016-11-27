<?php

namespace CMS\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth;

use CMS\Note;
use CMS\Card;

class Notes extends Controller
{
    public function store(Request $r,Card $card){
	    $this->validate($r,[
            'body' => 'required|min:10'
        ],['Body is verplicht','minimaal 10 letters']);
		$card->addNote(new Note($r->all()),1);
        //$note = new Note;
        //$note->body = $r->body;
        //$note->user_id = 1;
        //$note->by(Auth::user());
        // omdat de kaart een relatie heeft met notes kunnen we via card
        // een nieuwe note opslaan.zo hoeven we geen Card id toe te voegen,
        // want die staat al in de Card relatie.

        //$card->notes()->save($note);

        //$card->notes()->create([
        //	'body' => $request->body
        //]);

        // $card->notes()->create($r->all());

        //$card->addNote($note,1);
		return back();
	}

    public function edit(Note $note)
    {
        return view('cards.edit')->with(['note' => $note,'template'=>$this->template()]);
    }

    public function update(Request $r,Note $note)
    {
        $note->update($r->all());
        return back();
    }

}
