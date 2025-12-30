@extends('admin.layout.main')

@section('content')
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>Edit About Us</h3>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-dark">Back</a>
                </div>

                <div class="card-body">
                    <form method="POST"
                          action="{{ route('admin.about.update', $about->id) }}"
                          enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        {{-- Title --}}
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text"
                                   name="title"
                                   class="form-control"
                                   value="{{ old('title', $about->title) }}"
                                   required>
                        </div>

                        {{-- Description --}}
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" id="editor"
                                      rows="5"
                                      class="form-control"
                                      required>{{ old('description', $about->description) }}</textarea>
                        </div>

                        {{-- Current Image --}}
                        @if($about->image)
                            <div class="form-group">
                                <label>Current Image</label><br>
                                <img src="{{ asset($about->image) }}"
                                     width="150"
                                     class="mb-2">
                            </div>
                        @endif

                        {{-- Image Upload --}}
                        <div class="form-group">
                            <label>Change Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <button class="btn btn-info btn-lg mt-3">
                            Update About Page
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace('editor', {
        height: 400,
        extraPlugins: 'colorbutton,colordialog,justify,font,print,pagebreak,table,uploadimage,image2',
        removePlugins: 'easyimage,cloudservices,exportpdf',
        toolbarCanCollapse: true
    });
</script>
@endsection
