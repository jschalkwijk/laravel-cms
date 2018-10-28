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
    @include('JornSchalkwijk\LaravelCMS::admin.partials.single-action')
</tr>