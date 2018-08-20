@extends('blog::admin.layout')

@section('content')
    @parent
    @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
            <div class="alert error">{{ $error }}</div>
        @endforeach
    @endif

    @if ($category->id)
        <h1 class="col-md-offset-2">Edit a Category</h1>
    @else
        <h1 class="col-md-offset-2">Create a Category</h1>
    @endif


    <form class="form-horizontal" method="POST" action="{{ $category->id ? Route('didcode-admin-edit-category', $category->id) : Route('didcode-admin-create-category') }}">
        {{ csrf_field() }}
        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ?: $category->name }}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="slug">Slug</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') ?: $category->slug }}">
            </div>
        </div>

        <button type="submit" name="action" value="{{ $category->id ? 'update' : 'create' }}" class="col-md-offset-2 btn btn-primary">Save category</button>
    </form>
@endsection