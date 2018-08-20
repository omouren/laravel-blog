@extends('blog::admin.layout')

@section('content')
    @parent
    @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
            <div class="alert error">{{ $error }}</div>
        @endforeach
    @endif

    @if ($post->id)
        <h1 class="col-md-offset-2">Edit a Post</h1>
    @else
        <h1 class="col-md-offset-2">Create a Post</h1>
    @endif


    <form class="form-horizontal" method="POST" action="{{ $post->id ? Route('didcode-admin-edit-post', $post->id) : Route('didcode-admin-create-post') }}">
        {{ csrf_field() }}
        <div class="form-group">
            <label class="col-sm-2 control-label" for="title">Title</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') ?: $post->title }}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="slug">Slug</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') ?: $post->slug }}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="published_at">Publish date</label>
            <div class="col-sm-10">
                <input type="date" name="published_at_date" value="{{ old('published_at_date') ?: ($post->published_at ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->published_at)->format('Y-m-d H-i-s') : '') }}">
                <input type="time" name="published_at_time" value="{{ old('published_at_time') ?: ($post->published_at ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->published_at)->format('H:i') : '') }}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="chapo">Category</label>
            <div class="col-sm-10">
                <?php $postCategoryId = isset($post) ? $post->category_id : null; ?>
                <select name="category_id" id="category_id">
                    @foreach($categories as $categoryId => $categoryName)
                        <option value="{{ $categoryId }}" {{ $postCategoryId === $categoryId ? 'selected' : null }}>
                            {{ $categoryName }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="chapo">Excerpt</label>
            <div class="col-sm-10">
                <textarea id="chapo" name="chapo" class="ckeditor form-control">{{ old('chapo') ?: $post->chapo }}</textarea>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="content">Content</label>
            <div class="col-sm-10">
                <textarea id="content" name="content" class="ckeditor form-control">{{ old('content') ?: $post->content }}</textarea>
            </div>
        </div>

        <button type="submit" name="action" value="{{ $post->id ? 'update' : 'create' }}" class="col-md-offset-2 btn btn-primary">Save post</button>
    </form>
@endsection