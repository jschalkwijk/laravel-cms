<tr>
    <td class="td-title"><p>{{ $single->title }}</p></td>
    <td>{{ $single->user['username']}}</td>
    @if($single->categories)
        <td class="td-category">
            <p>
                @foreach($single->categories as $category)
                    {{ " | " .$category->title}}
                @endforeach
            </p>
        </td>
    @endif

    <td><p>{{ $single->created_at }}</p></td>
    <td class="td-btn"><a href="{{ $single->table.'/'.$single->id().'/edit/'}}"><img class="glyph-small link-btn" alt="edit-item" src="edit.png"/></a></td>
    @if ($single->approved == 0 )
        <td class="td-btn"><img class="glyph-small" alt="item-hidden-from-front-end-user" src="hide.png"/></td>
    @elseif ($single->approved == 1 )
        <td class="td-btn"><img class="glyph-small" alt="item-visible-for-front-end-user" src="'show.png"/></td>
    @endif
    <td class="td-btn"><p><input type="checkbox" name="checkbox[]" value="{{ $single->id() }}"/></p></td>
</tr>