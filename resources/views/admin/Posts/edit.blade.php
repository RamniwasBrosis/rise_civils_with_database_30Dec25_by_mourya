@extends('admin.layout.main')

@section('content')
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('admin.posts') }}" class="btn btn-dark" style="margin-left: 67rem;">Back</a>
                    <h3>Edit Pages</h3>
                </div>
                <div class="container mt-3">

                    <form action="{{ route('admin.updatePosts', $post->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="floatingfirst">Select Chapter:</label>
                            <select class="form-control" name="category_id">
                                <option value="">Select</option>
                                
                                @foreach($categories as $category)
                                    <!-- Parent category -->
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                        
                                    <!-- Subcategories -->
                                    @foreach($category->children as $child)
                                        <option value="{{ $child->id }}">— {{ $child->name }}</option>
                        
                                        <!-- Grandchild categories -->
                                        @foreach($child->chapters as $grandchild)
                                            <option value="{{ $grandchild->id }}" {{ $grandchild->id == $post->category_id ? 'selected' : '' }}>—— {{ $grandchild->name }}</option>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Page Name:</label>
                            <input type="text" class="form-control" name="name"
                                   value="{{ old('name', $post->name) }}" placeholder="Post Name">
                        </div>

                        <div class="form-group">
                            <label>Description:</label>
                            <textarea name="description" class="form-control" rows="3"
                                      placeholder="Short description...">{{ old('description', $post->description) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Content:</label>
                            <textarea id="editor" name="content" class="form-control"
                                      placeholder="Write full content here...">{!! old('content', $post->content) !!}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Status:</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ $post->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $post->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Current Image:</label><br>
                            @if($post->image)
                                <img src="{{ asset($post->image) }}" width="120" class="mb-2">
                            @else
                                <p>No Image</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="image">Change Image:</label>
                            <input type="file" class="form-control" name="image">
                        </div>

                        <div class="form-group">
                            <label>Current PDF:</label><br>
                            @if($post->pdf)
                                <a href="{{ asset($post->pdf) }}" class="btn btn-sm btn-dark" target="_blank">View PDF</a>
                            @else
                                <p>No PDF uploaded</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Change PDF:</label>
                            <input type="file" class="form-control" name="pdf">
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input"
                                   type="checkbox"
                                   name="pass_protected"
                                   value="1"
                                   id="pass_protected"
                                   {{ $post->pass_protected ? 'checked' : '' }}>

                                <label class="form-check-label" for="pass_protected">
                                    Password Protected
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input"
                                   type="checkbox"
                                   name="isFeature"
                                   value="1"
                                   id="isFeature"
                                   {{ $post->isFeature ? 'checked' : '' }}>
        
                                <label class="form-check-label" for="isFeature">
                                    Is Featured
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input"
                                   type="checkbox"
                                   name="showOnFront"
                                   value="1"
                                   id="isFeature"
                                   {{ $post->showOnFront ? 'checked' : '' }}>
        
                                <label class="form-check-label" for="showOnFront">
                                    Show on Front
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cat_image">Order No:</label>
                            <input type="number" class="form-control" name="order_no" placeholder="Enter Order No" value="{{ $post->order_no }}">
                        </div>
                        <div class="form-group">
                            <label for="">Public Link:</label>
                            <input type="text" readonly class="form-control" value="{{ $post->getFullUrl() }}">
                        </div>


                        
                        @php
                            /* $category = $post->category;
                            $parent = $category?->parent;
                        
                            if ($parent && $category) {
                                // has both parent + child
                                $postUrl = route('category.posts.full', [
                                    'parentSlug' => $parent->slug,
                                    'childSlug' => $category->slug,
                                    'postSlug' => $post->slug,
                                ]);
                            } elseif ($category) {
                                // only has one level category
                                $postUrl = route('category.blog', [
                                    'slug' => $category->slug,
                                ]) . '/' . $post->slug;
                            } else {
                                // no category at all
                                $postUrl = url('/study-posts/' . $post->slug);
                            } */
                        @endphp
                        
                        <!--<div class="form-group">-->
                        <!--    <label for="">Link:</label>-->
                        <!--    <input type="text" readonly class="form-control" value="">-->
                        <!--</div>-->

                        
                        
                        <div class="form-group mt-3">
                            <label for="status">Status:</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ $post->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $post->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-info btn-lg mt-3">Update</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('inlinescript')

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
            <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
            <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('#myTable').DataTable(); // No ajax needed
                });
            </script>
            
            
            
            
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
