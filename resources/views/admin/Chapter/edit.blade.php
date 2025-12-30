@extends('admin.layout.main')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<br>
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3>Edit Chapter</h3>
            <a href="{{ route('admin.chapter') }}" class="btn btn-dark">Back</a>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.updateChapter', $chapter->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
             
                <div class="form-group">
                    <label>Select Parent Category:</label>
                    @php
                    function renderCategoryOptions($categories, $selectedId = null, $prefix = '') {
                        foreach ($categories as $cat) {
                            $selected = ($cat->id == $selectedId) ? 'selected' : '';
                            echo '<option value="'.$cat->id.'" '.$selected.'>'.$prefix.$cat->name.'</option>';
                    
                            if ($cat->children->count()) {
                                renderCategoryOptions($cat->children, $selectedId, $prefix.'— ');
                            }
                        }
                    }
                    @endphp
                    <select name="category_id" class="form-control">
                        <option value="">Select Category</option>
                        @php renderCategoryOptions($categories, $chapter->category_id); @endphp
                    </select>
                </div>

                <div class="form-group">
                    <label>Chapter Name:</label>
                    <input type="text" class="form-control" name="chapter" value="{{ $chapter->name }}">
                </div>
                
                <div class="form-group">
                    <label for="floatingfirst">Order No:</label>
                    <input type="text" class="form-control" name="order_no" placeholder="Order no" value="{{ $chapter->order_no ?? '' }}">
                     @error('order_no')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input"
                           type="checkbox"
                           name="isFeature"
                           value="1"
                           id="isFeature"
                           {{ $chapter->isFeature ? 'checked' : '' }}>

                        <label class="form-check-label" for="isFeature">
                            Is Featured
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Status:</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $chapter->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $chapter->status == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success btn-lg">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('inlinescript')


    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        // ClassicEditor.create(document.querySelector('#editor'))
        //     .catch(error => console.error(error));
        
        
        ClassicEditor.create(document.querySelector('#editor'), {
            toolbar: [
                'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                'insertTable', 'uploadImage', 'blockQuote', 'undo', 'redo'
            ],
            ckfinder: {
                uploadUrl: '/store-posts' // your upload route
            },
            image: {
                toolbar: [
                    'imageTextAlternative', 'imageStyle:full', 'imageStyle:side', 'linkImage'
                ]
            }
        })
        .then(editor => {
         
            const editable = editor.ui.view.editable.element;
            editable.style.minHeight = '300px';
            editable.style.maxHeight = '400px';
            editable.style.overflowY = 'auto';
        })
        .catch(error => console.error(error));
    </script>
@endsection
