@extends('admin.layout.main')

@section('content')

<br>
<div id="alert-container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="mb-2">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
<div class="container-fluid">
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title">Heading</h3>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('admin.listHeading') }}" style="margin-left:70%;" class="btn btn-info">Back</a>
                        </div>
                    </div>
                </div>
                <div class="container mt-3">
                    <form id="addUser" action="{{ route('admin.storeHeading') }}" autocomplete="off" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="heading_id">Parent Heading:</label>
                            <select name="heading_id" class="form-control">
                                <option value="">-- Select Parent Heading --</option>
                                @foreach($headings as $heading)
                                    <option value="{{ $heading->id }}">{{ $heading->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter name" value="{{ old('name') }}">
                            <span class="error" id="name" style="color: red;"></span>
                        </div>
                    
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter title" value="{{ old('title') }}">
                        </div>
                    
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Short description...">{{ old('description') }}</textarea>
                        </div>
                    
                        <div class="form-group">
                            <label for="content">Content:</label>
                            <textarea name="content" class="form-control" rows="5" placeholder="Content...">{{ old('content') }}</textarea>
                        </div>
                    
                        <div class="form-group">
                            <label for="link">Link:</label>
                            <input type="text" class="form-control" name="link" placeholder="Enter link" value="{{ old('link') }}">
                        </div>
                    
                        <div class="form-group">
                            <label for="image">Image:</label>
                            <input type="file" class="form-control" name="image" accept="image/*">
                        </div>
                    
                        <div class="form-group">
                            <label for="isFeatured">Is Featured:</label>
                            <select name="isFeatured" class="form-control">
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    
                        <div class="form-group">
                            <label for="order_no">Order No:</label>
                            <input type="number" class="form-control" name="order_no" placeholder="Order no" value="{{ old('order_no') }}" required>
                            <span class="error" id="order_no" style="color: red;"></span>
                        </div>
                    
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select name="status" class="form-control">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
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
                    $('#myTable').DataTable(); // No ajax needed
                });
            </script>
            
            <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
            <script>
                CKEDITOR.replace('editor', {
                    height: 300,
                    extraPlugins: 'colorbutton,colordialog,justify,font,print,pagebreak,table,uploadimage,image2',
                    removePlugins: 'easyimage,cloudservices,exportpdf',
                    toolbarCanCollapse: true
                });
            </script>
            <script>
                $(document).ready(function () {
                    
                    //submit form using ajax
                    $("#addUser").submit(function (e) {
                        e.preventDefault();
                
                        let formData = new FormData(this);
                
                        $.ajax({
                            url: $(this).attr('action'),
                            method: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                
                            success: function (response) {
                                if (response.status) {
                                    $('#alert-container').html(`
                                        <div class="alert alert-success">${response.message}</div>
                                    `);
                                    $("#addUser")[0].reset();
                                }
                            },
                
                            error: function (xhr) {
                                let errors = xhr.responseJSON.errors;
                                $(".error").html("");
                
                                $.each(errors, function (key, value) {
                                    $("#" + key).html(value[0]);
                                });
                            }
                        });
                    });
                
                });

            </script>


            @endsection
