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
            <h3>Edit Category</h3>
            <a href="{{ route('admin.category') }}" class="btn btn-dark">Back</a>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.updateCategory', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @php
                    function renderCategoryOptions($categories, $selectedId = null, $prefix = '')
                    {
                        foreach ($categories as $cat) {
                            $selected = ($cat->id == $selectedId) ? 'selected' : '';
                            echo '<option value="'.$cat->id.'" '.$selected.'>'.$prefix.$cat->name.'</option>';
                    
                            if ($cat->children->count()) {
                                renderCategoryOptions($cat->children, $selectedId, $prefix.'— ');
                            }
                        }
                    }
                    @endphp
                <div class="form-group">
                    <label>Select Type:</label>
                    <select class="form-control" name="type_id">
                        <option value="">Select</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}" {{ $category->type_id == $type->id ? 'selected' : '' }}>
                                {{ $type->type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Select Parent Category:</label>
                    <select class="form-control" name="category_id">
                        <option value="">None</option>
                        @php renderCategoryOptions($categories, $category->category_id); @endphp
                    </select>
                </div>

                <div class="form-group">
                    <label>Category Name:</label>
                    <input type="text" class="form-control" name="category" value="{{ $category->name }}">
                </div>
                
                <div class="form-group">
                    <label for="floatingfirst">Order No:</label>
                    <input type="text" class="form-control" name="order_no" placeholder="Order no" value="{{ $category->order_no ?? '' }}">
                     @error('order_no')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                </div>
                
                <div class="form-group">
                    <label>Page Content:</label>
                    <textarea id="editor" name="short_description" class="form-control"
                        placeholder="Write short description here..." rows="5">{{$category->description}}</textarea>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input"
                           type="checkbox"
                           name="isFeature"
                           value="1"
                           id="isFeature"
                           {{ $category->isFeature ? 'checked' : '' }}>

                        <label class="form-check-label" for="isFeature">
                            Is Featured
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Status:</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Existing Image:</label><br>
                    @if($category->cat_image)
                        <img src="{{ asset($category->cat_image) }}" width="100">
                    @else
                        <span>No Image</span>
                    @endif
                </div>

                <div class="form-group">
                    <label>Change Image:</label>
                    <input type="file" name="cat_image" class="form-control">
                </div>

                <button type="submit" class="btn btn-success btn-lg">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('inlinescript')


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
