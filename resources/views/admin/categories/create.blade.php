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
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title">Category</h3>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('admin.category') }}" style="margin-left:70%;" class="btn btn-info">Back</a>
                        </div>
                    </div>
                </div>
                <div class="container mt-3">
                    <form id="addUser" action="{{ route('admin.storeCategory') }}" autocomplete="off" method="post" enctype="multipart/form-data">
                        @csrf
                        <div id="successMessage" style="color: green; margin-top: 15px;"></div>
                        <div class="form-group">
                            <label for="floatingfirst">Select Type:</label>
                            <select class="form-control" name="type_id">
                                <option value="">Select</option>
                                @foreach($types as $type)
                                    <option value="{{$type->id}}">{{ $type->type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="floatingfirst">Select Category:</label>
                            <select name="category_id" class="form-control" id="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="floatingfirst">Sub-Category Name:</label>
                            <input type="text" class="form-control" name="category" placeholder="Sub-Category">
                            <span class="error" id="sub-category" style="color: red;"></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="floatingfirst">Order No:</label>
                            <input type="text" class="form-control" name="order_no" id="order_no" placeholder="Order no" value="{{ old('order_no', $order_no) }}">
                            <span class="error" id="order_no" style="color: red;"></span>
                        </div>
                        
                        <div class="form-group">
                            <label>Page Content:</label>
                            <textarea id="editor" name="short_description" class="form-control"
                                placeholder="Write short description here..." rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="isFeature" 
                                       value="1" 
                                       id="isFeature">
                                <label class="form-check-label" for="isFeature">
                                    Is Featured
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select name="status" class="form-control">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cat_image">Image:</label>
                            <input type="file" class="form-control" name="cat_image" placeholder="Category image">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-lg">Save</button>
                        </div>
                    </form>

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
                    $('#myTable').DataTable(); 
                    
                    
                    
                    $('#category_id').on('change', function() {
                        var category_id = $(this).val();
                      
                        if(category_id) {
                            $.ajax({
                                url: "{{ route('admin.getOrderNoByCategory') }}",
                                type: "GET",
                                data: { category_id: category_id },
                                success: function(response) {
                                    if(response.order_no) {
                                        $('input[name="order_no"]').val(response.order_no);
                                    } else {
                                        $('#order_no').val('');
                                    }
                                },
                                error: function() {
                                    alert('Error fetching order number.');
                                }
                            });
                        } else {
                            $('#order_no').val('');
                        }
                    });
                    
                });
            </script>
            
            <!--<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>-->
            <!--<script>-->
               
            <!--    ClassicEditor.create(document.querySelector('#editor'), {-->
            <!--        toolbar: [-->
            <!--            'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',-->
            <!--            'insertTable', 'uploadImage', 'blockQuote', 'undo', 'redo'-->
            <!--        ],-->
            <!--        ckfinder: {-->
                        uploadUrl: '/store-posts' // your upload route
            <!--        },-->
            <!--        image: {-->
            <!--            toolbar: [-->
            <!--                'imageTextAlternative', 'imageStyle:full', 'imageStyle:side', 'linkImage'-->
            <!--            ]-->
            <!--        }-->
            <!--    })-->
            <!--    .then(editor => {-->
                 
            <!--        const editable = editor.ui.view.editable.element;-->
            <!--        editable.style.minHeight = '300px';-->
            <!--        editable.style.maxHeight = '400px';-->
            <!--        editable.style.overflowY = 'auto';-->
            <!--    })-->
            <!--    .catch(error => console.error(error));-->
            <!--</script>-->
            
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
