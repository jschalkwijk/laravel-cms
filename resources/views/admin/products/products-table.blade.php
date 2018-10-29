<form class="backend-form" method="post" action="/admin/products/action">
    {{ csrf_field() }}
    <table class="table table-sm table-striped">
        <thead class="thead-default">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Price</th>
            <th>Categories</th>
            <th>Date / Time</th>
            <th>Edit</th>
            <th>View</th>
            <th>Del</th>
            <th>
                <button type="button" id="check-all"><img class="glyph-small" alt="check-all-items" src="check.png"/>
                </button>
            </th>
        </tr>
        </thead>
        @foreach($products as $single)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td class="td-title"><a href="{{route('products.edit',$single->product_id)}}">{{ $single->name }}</a></td>
                <td>{{ $single->price}}</td>
                <td class="td-category">
                    {{ $single->category['title']}}
                </td>
                {{--@if($single->tags)--}}
                {{--<td class="td-category">--}}
                {{--<p>--}}
                {{--@foreach($single->tags as $tag)--}}
                {{--{{ " | " .$tag->title}}--}}
                {{--@endforeach--}}
                {{--</p>--}}
                {{--</td>--}}
                {{--@endif--}}

                <td><p>{{ $single->created_at }}</p></td>
                <td class="td-btn"><p><a href="{{ $single->table.'/'.$single->id().'/edit/'}}">Edit</a></p></td>
                @if ($single->approved == 0)
                    <td><a class="form-action btn btn-sm btn-warning"
                           href="{{ route($single->table.'.approve', $single->id()) }}"></a></td>
                @elseif ($single->approved == 1)
                    <td><a class="form-action btn btn-sm btn-success"
                           href="{{ route($single->table.'.hide', $single->id()) }}"></a></td>
                @endif
                @if ($single->trashed == 0)
                    <td><a href="{{route($single->table.'.trash',$single->id())}}"
                           class="form-action btn btn-sm btn-danger"></a></td>
                @elseif ($single->trashed == 1)
                    <td><a href="{{route($single->table.'.destroy',$single->id())}}"
                           class="form-action btn btn-sm btn-danger"><img
                                    class="glyph-small" alt="destroy-item" src=""/></a></td>
                @endif
                <td class="td-btn"><p><input type="checkbox" name="checkbox[]" value="{{ $single->id() }}"/></p></td>
            </tr>
        @endforeach
    </table>
    @include('admin.partials.actions')
</form>
