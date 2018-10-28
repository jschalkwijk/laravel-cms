<form class="backend-form" method="post" action="/admin/posts/action">
    {{ csrf_field() }}
    <table class="table table-sm table-striped">
        <thead class="thead-default">
        <tr>
            <th>#</th>
            <th>Title</th>
            <th class="hidden-xs-down">Author</th>
            <th class="hidden-xs-down">Category</th>
            <th class="hidden-xs-down">Tags</th>
            <th class="hidden-md-down">Date / Time</th>
            <th>Edit</th>
            <th>Status</th>
            <th>Del</th>
            <th>
                <button type="button" id="check-all"><img class="glyph-small" alt="check-all-items"
                                                          src="check.png"/></button>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $single)
            @include('JornSchalkwijk\LaravelCMS::admin.content.content-table')
        @endforeach
        </tbody>
    </table>
    @include('JornSchalkwijk\LaravelCMS::admin.partials.actions')
</form>