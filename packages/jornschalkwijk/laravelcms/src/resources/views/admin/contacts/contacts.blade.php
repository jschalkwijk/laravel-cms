@extends('JornSchalkwijk\LaravelCMS::admin.layout')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                <a href="/admin/contacts/create" class="link-btn">Add Contact</a>
                <a href="/admin/contacts/deleted-contacts" class="link-btn">Deleted Contacts</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                <form class="backend-form" method="post" action="/admin/contacts/action">
                    {{ csrf_field() }}
                    <table class="backend-table title">
                        <tbody>
                        <tr>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Phone</th>
                            <th>E-mail</th>
                            <th>Edit</th>
                            <th>
                                <button type="button" id="check-all"><img class="glyph-small" alt="check-all-items" src="check.png"/></button>
                            </th>
                        </tr>
                        @foreach($contacts as $contact)
                        <tr>
                            <td>{{$contact->first_name}}</td>
                            <td>{{$contact->last_name}}</td>
                            <td>{{$contact->phone_1}}</td>
                            <td>{{$contact->email_1}}</td>
                            <td><a href="{{ $contact->table.'/'.$contact->contact_id.'/edit/'}}"><img class="glyph-small link-btn" alt="edit-item" src="edit.png"/></a></td>
                            <td class="td-btn"><p><input type="checkbox" name="checkbox[]" value="{{$contact->contact_id}}"/></p></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <table>
                        @if($trashed === 0)
                        <tr><th>Trash</th><th>Show</th><th>Hide</th></tr>
                        <tr>
                            <td><p><button type="submit" name="trash-selected" id="trash-selected"><img class="glyph-small" alt="trash-selected" src="<?= 'trash-post.png'?>"/></button></p></td>
                            <td><p><button type="submit" name="approve-selected" id="approve-selected"><img class="glyph-small" alt="approve-selected-for-front-end-view" src="<?= 'show.png'?>"/></button></p></td>
                            <td><p><button type="submit" name="hide-selected" id="hide-selected"><img class="glyph-small" alt="hide-selected-from-front-end-view" src="<?= 'hide.png'?>"/></button></p></td>
                        </tr>
                        @elseif ($trashed === 1)
                        <th>Restore</th><th>Remove</th></tr>
                        <tr>
                            <td><p><button type="submit" name="restore-selected" id="restore-selected"><img class="glyph-small" alt="restore-selected-from-trash" src="<?= 'add-post.png'?>"/></button></p></td>
                            <td><p><button type="submit" name="delete-selected" id="delete-selected"><img class="glyph-small" alt="delete-selected-from-trash" src="<?= 'delete-post.png'?>"/></button></p></td>
                        </tr>
                       @endif
                    </table>
                </form>
            </div>
        </div>
    </div>
@stop