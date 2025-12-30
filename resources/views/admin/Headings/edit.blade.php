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
                            <h3 class="card-title">Edit Heading</h3>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('admin.listHeading') }}" style="margin-left:70%;" class="btn btn-info">Back</a>
                        </div>
                    </div>
                </div>
                <div class="container mt-3">
                    <form id="updateForm" action="{{ route('admin.updateHeading', $heading->id) }}" 
                          method="post" enctype="multipart/form-data">
                        @csrf
                    
                        <input type="hidden" id="edit_id" value="{{ $heading->id }}">
                    
                        <div class="modal-body">
                    
                            {{-- Parent Heading --}}
                            <div class="form-group">
                                <label>Parent Heading:</label>
                                <select name="heading_id" class="form-control">
                                    <option value="">-- Select Parent --</option>
                    
                                    @foreach($headings as $parent)
                                        @if($parent->id != $heading->id)
                                            <option value="{{ $parent->id }}"
                                                {{ $heading->heading_id == $parent->id ? 'selected' : '' }}>
                                                {{ $parent->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                <span class="edit-error" id="edit_heading_id_error"></span>
                            </div>
                    
                            {{-- Name --}}
                            <div class="form-group">
                                <label>Name:</label>
                                <input type="text" name="name" class="form-control" value="{{ $heading->name }}">
                                <span class="edit-error" id="edit_name_error"></span>
                            </div>
                    
                            {{-- Title --}}
                            <div class="form-group">
                                <label>Title:</label>
                                <input type="text" name="title" class="form-control" value="{{ $heading->title }}">
                                <span class="edit-error" id="edit_title_error"></span>
                            </div>
                    
                            {{-- Description --}}
                            <div class="form-group">
                                <label>Description:</label>
                                <textarea name="description" class="form-control">{{ $heading->description }}</textarea>
                            </div>
                    
                            {{-- Content --}}
                            <div class="form-group">
                                <label>Content:</label>
                                <textarea name="content" class="form-control">{{ $heading->content }}</textarea>
                            </div>
                    
                            {{-- Link --}}
                            <div class="form-group">
                                <label>Link:</label>
                                <input type="text" name="link" class="form-control" value="{{ $heading->link }}">
                            </div>
                    
                            {{-- Image --}}
                            <div class="form-group">
                                <label>Image:</label>
                                <input type="file" name="image" class="form-control">
                    
                                @if($heading->image)
                                    <img src="{{ asset('uploads/headings/'.$heading->image) }}" 
                                         width="100" class="mt-2">
                                @endif
                            </div>
                    
                            {{-- Is Featured --}}
                            <div class="form-group">
                                <label>Is Featured:</label>
                                <select name="isFeatured" class="form-control">
                                    <option value="0" {{ $heading->isFeatured == 0 ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ $heading->isFeatured == 1 ? 'selected' : '' }}>Yes</option>
                                </select>
                                <span class="edit-error" id="edit_isFeatured_error"></span>
                            </div>
                    
                            {{-- Order No --}}
                            <div class="form-group">
                                <label>Order No:</label>
                                <input type="number" name="order_no" class="form-control" value="{{ $heading->order_no }}">
                                <span class="edit-error" id="edit_order_no_error"></span>
                            </div>
                    
                            {{-- Status --}}
                            <div class="form-group">
                                <label>Status:</label>
                                <select name="status" class="form-control">
                                    <option value="1" {{ $heading->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $heading->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <span class="edit-error" id="edit_status_error"></span>
                            </div>
                    
                        </div>
                    
                        <div class="modal-footer">
                            <button class="btn btn-primary" type="submit">Update</button>
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
                
                    $("#updateForm").submit(function (e) {
                        e.preventDefault();
                
                        let id = $("#edit_id").val();
                        let formData = new FormData(this);
                
                        $.ajax({
                            url: "/admin/update-heading/" + id,
                            method: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                            },
                
                            success: function (response) {
                                if (response.status) {
                                    $("#editModal").modal("hide");
                                    
                                    alert(response.message);
                
                                    $('#alert-container').html(`
                                        <div class="alert alert-success">${response.message}</div>
                                    `);
                                }
                            },
                
                            error: function (xhr) {
                                $(".edit-error").html("");
                
                                if (xhr.status === 422) {
                                    let errors = xhr.responseJSON.errors;
                
                                    $.each(errors, function (key, value) {
                                        $("#edit_" + key + "_error").html(value[0]);
                                    });
                
                                } else {
                                    alert("Error: " + xhr.responseJSON.message);
                                }
                            }
                        });
                    });
                
                });
            </script>



            @endsection
