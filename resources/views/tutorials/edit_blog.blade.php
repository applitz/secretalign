@extends('layouts.app_base_horizontal')

@section('content')

<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Manage Tutorials</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('/tutorials/view')}}">Tutorials</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>


    <div class="card mb-3">
        <div class="card-body ">
            <h4 class="card-title mb-3">Edit Tutorial</h4>


            <form class="save-form " method="POST" action="{{ url('/tutorial/update/'.$blog->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="title">Tutorial Title</label>
                    <input class="form-control @error('title') is-invalid @enderror" id="title" type="text"
                        value="{{ $blog->blog_name }}" placeholder="Title" name="title">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Tutorial Media</label>
                    <input type="file" class="form-control @error('media') is-invalid @enderror" id="media" name="media">
                    @error('media')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description">{{ $blog->description }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Iframe / Embeded Code</label>
                    <textarea class="form-control @error('iframe') is-invalid @enderror" name="iframe" rows="10">{{ $blog->iframe }}</textarea>
                    @error('iframe')
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
