@extends('admin.layout.main')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>RISE - An Institute For Civil Services</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
        #myTable_processing {
            display: none;
        }
    </style>
</head>
<body>
    <br>
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8">
                                <h3 class="card-title">Category list</h3>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{ route('admin.addCategory') }}" style="margin-left:70%;" class="btn btn-info">Add
                                    More</a>
                            </div>
                        </div>
                    </div>
                    <div class="container mt-5">
                        <table id="myTable" class="table table-bordered">
                            <thead>
                                <!-- 🔹 Row 1: Search Inputs -->
                                <tr>
                                    <th><input type="text" class="form-control form-control-sm column-search" placeholder="Search No"></th>
                                    <th><input type="text" class="form-control form-control-sm column-search" placeholder="Search Category Name"></th>
                                    <th><input type="text" class="form-control form-control-sm column-search" placeholder="Search Parent"></th>
                                    <th><input type="text" class="form-control form-control-sm column-search" placeholder="Search Grand"></th>
                                    <th><input type="text" class="form-control form-control-sm column-search" placeholder="Search Type"></th>
                                    <th></th> <!-- Image: no search -->
                                    <th>
                                        <select class="form-control form-control-sm column-search">
                                            <option value="">All</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </th>
                                    <th></th> <!-- Action: no search -->
                                </tr>
                        
                                <!-- 🔹 Row 2: Table Headings -->
                                <tr>
                                    <th>No</th>
                                    <th>Category Name</th>
                                    <th>Parent Category</th>
                                    <th>Grand Category</th>
                                    <th>Type</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        
                            <tbody>
                                @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->parent ? $category->parent->name : '-' }}</td>
                                    <td>{{ $category->parent && $category->parent->parent ? $category->parent->parent->name : '-' }}</td>
                                    <td>{{ $category->type->type }}</td>
                                    <td>
                                        @php
                                            $imagePath = public_path($category->cat_image);
                                            $fallbackImagePath = asset('assets_rise/img/no_image.jpg');
                                        @endphp
                                    
                                        @if ($category->cat_image && file_exists($imagePath))
                                            <img src="{{ asset($category->cat_image) }}" alt="{{ $category->name ?? 'Category Image' }}" width="100">
                                        @else
                                            <img src="{{ $fallbackImagePath }}" alt="No Image Available" width="100">
                                        @endif
                                    </td>
                                    <td>
                                        @if($category->status == 1)
                                            Active
                                        @else
                                            Inactive
                                        @endif
                                    </td>
                                    <td>
                                        <a class="badge badge-info border-0" href="{{ route('admin.editCategory', $category->id) }}">Edit</a>
                                        <form action="{{ route('admin.deleteCategory', $category->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge badge-danger light border-0"
                                                onclick="return confirm('Are you sure you want to delete this Category?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>

</body>

@endsection



@section('inlinescript')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable only once
    let table = $('#myTable').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
    });

    // Apply search per column (for the first header row)
    $('#myTable thead tr:eq(0) th').each(function(i) {
        $('input, select', this).on('keyup change', function() {
            if (table.column(i).search() !== this.value) {
                table
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });
});
</script>



@endsection