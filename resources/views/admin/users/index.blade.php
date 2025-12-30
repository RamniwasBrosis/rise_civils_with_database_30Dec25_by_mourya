@extends('admin.layout.main')

@section('content')



<!DOCTYPE html>

<html>
<head>

    <title>Laravel Datatables Tutorial</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />

    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

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
                                <h3 class="card-title">User List</h3>
                            </div>
                            <div class="col-md-4 text-right">
                                <!--<a href="#" style="margin-left:70%;" class="btn btn-info">Add User</a>-->
                            </div>
                        </div>
                    </div>
                    <div class="container mt-5">
                        <table id="myTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Full Name</th>
                                    <th>email</th>
                                    <th>Phone No.</th>
                                    <th>Status</th>
                                    <!--<th>User Type</th>-->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ ucfirst(strtolower($value->name)) .' ' . ucfirst(strtolower($value->last_name)) }}</td>
                                    <td>{{ $value->email }}</td>
                                    <td>{{ $value->nubhar }}</td>
                                    <td>
                                        <button
                                            class="btn btn-sm {{ $value->status == 'Active' ? 'btn-success' : 'btn-danger' }}"
                                            disabled>
                                            {{ $value->status }}
                                        </button>
                                    </td>
                                    <!--<td><button class="btn btn-sm btn-info disabled">{{ $value->user_type }}</button></td>-->
                                    <td>
                                        <form action="{{ route('admin.deleteUser', $value->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
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
        $('#myTable').DataTable(); // No ajax needed
    });
</script>

@endsection