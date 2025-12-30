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
                                <h3 class="card-title">Courses list</h3>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{ route('admin.createCourse') }}" style="margin-left:70%;" class="btn btn-info">Add
                                    More</a>
                            </div>
                        </div>
                    </div>
                    <div class="container mt-5">
                        <table id="myTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Thumbnail</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Show On Front</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($courses as $index => $course)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                
                                        <td>{{ $course->title }}</td>
                                
                                        <td>
                                            @if($course->thumbnail)
                                                <img src="{{ asset($course->thumbnail) }}" 
                                                     width="80" 
                                                     height="50" 
                                                     style="object-fit:cover;">
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                
                                        <td>
                                            ₹ {{ number_format($course->price, 2) }}
                                        </td>
                                
                                        <td>
                                            @if($course->status == 1)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($course->showOnFront == 1)
                                                <span class="badge badge-success">Visible</span>
                                            @else
                                                <span class="badge badge-danger">Invisible</span>
                                            @endif
                                        </td>
                                
                                        <td>
                                            <a href="{{ route('admin.editCourse', $course->id) }}" 
                                               class="btn btn-sm btn-primary">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.deleteCourse', $course->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this course?')">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            No courses found
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-4">
                            {{ $courses->links('pagination::bootstrap-5') }}
                        </div>
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

@endsection