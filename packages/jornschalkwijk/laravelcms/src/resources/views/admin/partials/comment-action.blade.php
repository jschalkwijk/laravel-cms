<td class="td-btn"><p><a href="{{ $single->table.'/'.$single->id().'/edit'}}">Edit</a></p></td>
@if ($single->approved == 0)
    <td><a class="form-action btn btn-sm btn-warning" href="{{ route($single->table.'.approve', $single->id()) }}"></a></td>
@elseif ($single->approved == 1)
    <td><a class="form-action btn btn-sm btn-success" href="{{ route($single->table.'.hide', $single->id()) }}"></a></td>
@endif
<td><a href="{{route($single->table.'.destroy',$single->id())}}" class="form-action btn btn-sm btn-danger"><img
                    class="glyph-small" src=""/></a></td>
<td class="td-btn"><p><input type="checkbox" name="checkbox[]" value="{{ $single->id() }}"/></p></td>