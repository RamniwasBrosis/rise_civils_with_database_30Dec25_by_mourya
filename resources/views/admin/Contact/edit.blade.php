@extends('admin.layout.main')
@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
</head>
<body>

<div class="container mt-5">
    <div class="card">
    <div class="card-header w3-container w3-blue text-white">
    <h3 class="card-title">Contact Us Details</h3>
</div>

        <div class="card-body">
            <table class="table table-striped">
                <tr><th>Name</th><td><?php echo htmlspecialchars($getContactUs['name']); ?></td></tr>
                <tr><th>Email</th><td><?php echo htmlspecialchars($getContactUs['email']); ?></td></tr>
                <tr><th>Phone</th><td><?php echo htmlspecialchars($getContactUs['phone']); ?></td></tr>
                <tr><th>Subject</th><td><?php echo htmlspecialchars($getContactUs['subject']); ?></td></tr>
                <tr><th>Message</th><td><?php echo htmlspecialchars($getContactUs['message']); ?></td></tr>
                
            </table>
        </div>
        <div class="card-footer text-right">
            <a href="{{route('admin.ContactUs')}}" class="btn btn-secondary">Back to Contact Us List</a>
        </div>
    </div>
</div>

</body>
</html>

@endsection