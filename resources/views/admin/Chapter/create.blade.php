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
                            <h3 class="card-title">Chapter</h3>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('admin.chapter') }}" style="margin-left:70%;" class="btn btn-info">Back</a>
                        </div>
                    </div>
                </div>
                <div class="container mt-3">
                    <form id="addUser" action="{{ route('admin.storeChapter') }}" autocomplete="off" method="post" enctype="multipart/form-data">
                        @csrf
                        <div id="successMessage" style="color: green; margin-top: 15px;"></div>
                        @php
                        function renderCategoryOptions($categories, $prefix = '') {
                            foreach ($categories as $cat) {
                                echo '<option value="'.$cat->id.'">'.$prefix.$cat->name.'</option>';
                        
                                if ($cat->children->count()) {
                                    renderCategoryOptions($cat->children, $prefix.'— '); // adds dashes
                                }
                            }
                        }
                        @endphp
                        <div class="form-group">
                            <label for="floatingfirst">Select Category:</label>
                            <select name="category_id" class="form-control">
                                <option value="">Select Category</option>
                                @php renderCategoryOptions($categories); @endphp
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="floatingfirst">Chapter Name:</label>
                            <input type="text" class="form-control" name="chapter" placeholder="chapter">
                            <span class="error" id="chapter" style="color: red;"></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="floatingfirst">Order No:</label>
                            <input type="text" class="form-control" name="order_no" id="order_no" placeholder="Order no" value="{{ old('order_no') }}">
                            <span class="error" id="order_no" style="color: red;"></span>
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
                                url: "{{ route('admin.getOrderNoByChapter') }}",
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
            
            @endsection
