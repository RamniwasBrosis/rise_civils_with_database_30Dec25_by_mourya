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
                                <h3 class="card-title">Type list</h3>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{ route('admin.addTypes') }}" style="margin-left:70%;" class="btn btn-info">Add
                                    More</a>
                            </div>
                        </div>
                    </div>
                    <div class="container mt-5">
                        <table id="myTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Type</th>
                                    <th>Order No</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($types as $type)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $type->type }}</td>
                                    <td>{{ $type->order_no ?? '-' }}</td>
                                    <td>
                                        @if($type->status == 1)
                                            <button class="btn btn-sm btn-success disabled">Active</button>
                                        @else
                                            <button class="btn btn-sm btn-danger disabled">Inactive</button>
                                        
                                        @endif
                                    </td>
                                    <td>
                                        <a class="badge badge-info light border-0" href="{{ route('admin.editTypes', $type->id) }}">Edit</a>
                                        <form action="{{ route('type.delete', $type->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge badge-danger light border-0" onclick="return confirm('Are you sure you want to delete this Type?')">
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