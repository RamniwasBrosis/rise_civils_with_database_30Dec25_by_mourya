@extends('admin.layout.main')

@section('content')

<br>
<div class="container-fluid">
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title">Edit Type</h3>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('admin.types') }}" style="margin-left:70%;" class="btn btn-info">Back</a>
                        </div>
                    </div>
                </div>
                <div class="container mt-3">
                    <form id="addUser" action="{{ route('admin.updateTypes', $typesData->id) }}" autocomplete="off" method="post" enctype="multipart/form-data">
                        @csrf
                        <div id="successMessage" style="color: green; margin-top: 15px;"></div>
                        <div class="form-group">
                            <label for="floatingfirst">Type:</label>
                            <input type="text" class="form-control" name="type" placeholder="Enter type" value="{{ $typesData->type }}">
                            <span class="error" id="name" style="color: red;"></span>
                        </div>
                        <div class="form-group">
                            <label for="floatingfirst">Order No:</label>
                            <input type="number" class="form-control" name="order_no" placeholder="Order no" value="{{ $typesData->order_no }}">
                            <span class="error" id="order_no" style="color: red;"></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="floatingfirst">Title:</label>
                            <input type="text" class="form-control" name="title" placeholder="title" value="{{ $typesData?->title }}">
                        </div>
                        
                        <div class="form-group">
                            <label>Description:</label>
                            <textarea name="description" class="form-control" rows="3"
                                placeholder="Short description...">{{ $typesData?->description }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Page Content:</label>
                            <textarea id="editor" name="page_content" class="form-control"
                                placeholder="Write short description here..." rows="5">{{ $typesData?->page_content }}</textarea>
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select name="status" id="status" class="form-control">
                                {{-- Option 1: Active (value 1) --}}
                                <option value="1" {{ ($typesData->status ?? 1) == 1 ? 'selected' : '' }}>
                                    Active
                                </option>
                                
                                {{-- Option 2: Inactive (value 0) --}}
                                <option value="0" {{ ($typesData->status ?? 0) == 0 ? 'selected' : '' }}>
                                    Inactive
                                </option>
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

            @endsection
