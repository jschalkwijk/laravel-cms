<tr>
    <th scope="row">{{ $loop->iteration }}</th>
    <td class="td-title"><p><a href="{{route($single->table.'.show',$single->id())}}">{{ $single->title }}</a></p></td>
    <td class="hidden-xs-down"><p>{{ $single->user['first_name']}}</p></td>
    <td class="hidden-xs-down">
        @if(!$single->category['title'])
            <p>
                {{ $single->parent['title']}}
            </p>
        @else
            <p>
                {{ $single->category['title']}}
            </p>
        @endif

    </td>
    @if($single->tags)
        <td class="hidden-sm-down">
            <p>
                @foreach($single->tags as $tag)
                    {{ " | " .$tag->title}}
                @endforeach
            </p>
        </td>
    @endif
    <td class="hidden-md-down"><p>{{ $single->created_at }}</p></td>
    <td class="td-btn"><p><a href="{{ $single->table.'/'.$single->id().'/edit'}}">Edit</a></p></td>
    @if ($single->approved == 0)
    <td><a class="form-action btn btn-sm btn-warning" href="{{ route($single->table.'.approve', $single->id()) }}"></a></td>
    @elseif ($single->approved == 1)
    <td><a class="form-action btn btn-sm btn-success" href="{{ route($single->table.'.hide', $single->id()) }}"></a></td>
    @endif
    @if ($single->trashed == 0)
    <td><a href="{{route($single->table.'.trash',$single->id())}}" class="form-action btn btn-sm btn-danger"></a></td>
    @elseif ($single->trashed == 1)
    <td><a href="{{route($single->table.'.destroy',$single->id())}}" class="form-action btn btn-sm btn-danger"><img
                    class="glyph-small" alt="destroy-item" src=""/></a></td>
    @endif
    <td class="td-btn"><p><input type="checkbox" name="checkbox[]" value="{{ $single->id() }}"/></p></td>
</tr>