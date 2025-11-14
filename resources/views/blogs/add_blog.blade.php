@extends('layouts.app_base_horizontal')

@section('content')

<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Manage Blogs</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('/blogs/view')}}">Blogs</a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>


    <div class="card mb-3">
        <div class="card-body ">
            <h4 class="card-title mb-3">Add New Blog</h4>


            <form class="save-form " method="POST" action="{{ url('/blog/save') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="title">Blog Title</label>
                    <input class="form-control @error('title') is-invalid @enderror" id="title" type="text"
                        value="{{ old('title') }}" placeholder="Title" name="title">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Blog Media</label>
                    <input type="file" class="form-control @error('media') is-invalid @enderror" id="media" name="media">
                    @error('media')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="submit" name="submit" class="btn btn-primary waves-effect waves-light" value="Save Changes">
                </div>
            </form>
        </div>
    </div>
</div>


@stop


@section('javascript')

@stop
