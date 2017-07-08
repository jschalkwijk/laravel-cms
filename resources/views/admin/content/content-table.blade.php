<tr>
    <th scope="row">{{ $loop->iteration }}</th>
    <td class="td-title"><p>{{ $single->title }}</p></td>
    <td class="hidden-xs-down">{{ $single->user['username']}}</td>
    <td class="hidden-xs-down">
                {{ $single->category['title']}}
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
    <td class="td-btn"><p><a href="{{ $single->table.'/'.$single->id().'/edit/'}}">Edit</a></p></td>
    {{--@if ($single->approved == 0 )--}}
        {{--<td class="td-btn"><img class="glyph-small" alt="item-hidden-from-front-end-user" src="hide.png"/></td>--}}
    {{--@elseif ($single->approved == 1 )--}}
        {{--<td class="td-btn"><img class="glyph-small" alt="item-visible-for-front-end-user" src="'show.png"/></td>--}}
    {{--@endif--}}
    @if ($single->approved == 0)
    <td><a class="form-action btn btn-sm btn-info" href="{{ route('posts.approve', $single->id()) }}"></a></td>
    @elseif ($single->approved == 1)
    <td><a class="form-action btn btn-sm btn-success" href="{{ route('posts.hide', $single->id()) }}"></a></td>
    @endif
    @if ($single->trashed == 0)
    <td><a href="{{route('posts.trash',$single->id())}}" class="form-action btn btn-sm btn-danger"></a></td>
    @elseif ($single->trashed == 1)
    <td><a href="{{route('posts.destroy',$single->id())}}" class="form-action btn btn-sm btn-danger"><img
                    class="glyph-small" alt="destroy-item" src=""/></a></td>
    @endif
    <td class="td-btn"><p><input type="checkbox" name="checkbox[]" value="{{ $single->id() }}"/></p></td>
</tr>