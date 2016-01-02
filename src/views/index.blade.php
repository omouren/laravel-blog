@extends(config('blog.layout_path'))

@section('content')

    <div class="main">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li class="active">{{ config('blog.base_name') }}</li>
            </ul>

            <div class="row margin-bottom-40">
                <div class="col-md-9 col-sm-9">
                    @each('blog::post.listView', $posts, 'post')
                    {{ $posts->render() }}
                </div>

                @include('blog::sidebar')

            </div>
        </div>
    </div>

@endsection