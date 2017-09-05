@extends('layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-lg-6 offset-xs-3 offset-sm-3 offset-lg-3">
                <div class="center button-block">
                    <a href="/admin/category/create" class="btn btn-primary btn-sm visible-md-block">Add Category</a>
                    <a href="/admin/categories/deleted-categories" class="btn btn-primary visible-md-block">Deleted Categories</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-xs-3 offset-sm-3 offset-md-2 offset-lg-3">
                {{$category->title}}
                {{$category->description}}
                {{$category->user->first_name}}
                {{$category->created_at}}
                {{$category->updated_at}}
                {{--{{$category->parent->title}}--}}
                {!! $sub_categories !!}
                {{--@foreach($children as $child)--}}
                        {{--{{$child->title}}--}}
                {{--@endforeach--}}
                <?php
                $datas = array(
                    array('id' => 1, 'parent' => 0, 'name' => 'Page 1'),
                    array('id' => 2, 'parent' => 1, 'name' => 'Page 1.1'),
                    array('id' => 3, 'parent' => 2, 'name' => 'Page 1.1.1'),
                    array('id' => 4, 'parent' => 3, 'name' => 'Page 1.1.1.1'),
                    array('id' => 5, 'parent' => 3, 'name' => 'Page 1.1.1.2'),
                    array('id' => 6, 'parent' => 1, 'name' => 'Page 1.2'),
                    array('id' => 7, 'parent' => 6, 'name' => 'Page 1.2.1'),
                    array('id' => 8, 'parent' => 0, 'name' => 'Page 2'),
                    array('id' => 9, 'parent' => 0, 'name' => 'Page 3'),
                    array('id' => 10, 'parent' => 9, 'name' => 'Page 3.1'),
                    array('id' => 11, 'parent' => 9, 'name' => 'Page 3.2'),
                    array('id' => 12, 'parent' => 11, 'name' => 'Page 3.2.1'),
                );

                function generatePageTree($datas, $parent = 0, $depth=0){
                    if($depth > 1000) return ''; // Make sure not to have an endless recursion
                    $tree = '<ul class="list-group">';
                    foreach($datas as $data){
                        echo $data['parent'].'<br>';
                        if($data['parent'] == $parent){
                            $tree .= '<li class="list-group-item">';
                            $tree .= $data['name'];
                            // nog een keer deze functie draaien
                            $tree .= generatePageTree($datas, $data['id'], $depth+1);
                            $tree .= '</li>';
                        }
                        unset($datas[$data['id']]);
                    }
                    $tree .= '</ul>';

//                    print_r($datas);

                    return $tree;
                }

                echo(generatePageTree($datas));
                        ?>
            </div>
        </div>

    </div>
@stop