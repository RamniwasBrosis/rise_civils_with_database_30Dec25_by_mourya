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
                            <h3 class="card-title">Category</h3>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('admin.subAdminsList') }}" style="margin-left:70%;" class="btn btn-info">Back</a>
                        </div>
                    </div>
                </div>
                <div class="container mt-3">
                    <form id="addUser" action="{{ route('admin.storeSubject') }}" autocomplete="off" method="post" enctype="multipart/form-data">
                        @csrf
                        <div id="successMessage" style="color: green; margin-top: 15px;"></div>
                        <div class="form-group">
                            <label for="type_select">Select Type:</label>
                            <select class="form-control" name="type_id" id="type_select">
                                <option value="">Select</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category_select">Select Category:</label>
                            {{-- Changed name to category_id (as it is selecting a Category) --}}
                            <select class="form-control" name="category_id" id="category_select" disabled>
                                <option value="">Select Type First</option>
                                {{-- Categories will be inserted here by JavaScript --}}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="floatingfirst">Subject Name:</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Subject">
                            <span class="error" id="name" style="color: red;"></span>
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
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const typeSelect = document.getElementById('type_select');
                    const categorySelect = document.getElementById('category_select');
            
                    // Function to clear and disable the category dropdown
                    const resetCategorySelect = () => {
                        categorySelect.innerHTML = '<option value="">Select Type First</option>';
                        categorySelect.disabled = true;
                    };
            
                    typeSelect.addEventListener('change', function () {
                        const typeId = this.value;
            
                        if (typeId) {
                            // Get the URL for the AJAX request. You MUST define this route (see step 2)
                            const url = '{{ route("admin.categories.byType", ["type" => ":typeId"]) }}'.replace(':typeId', typeId);
            
                            categorySelect.innerHTML = '<option value="">Loading...</option>';
                            categorySelect.disabled = true;
            
                            // Make the AJAX request using the Fetch API
                            fetch(url)
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Network response was not ok');
                                    }
                                    return response.json();
                                })
                                .then(categories => {
                                    categorySelect.innerHTML = '<option value="">Select Category</option>';
                                    
                                    if (categories.length > 0) {
                                        categories.forEach(category => {
                                            const option = document.createElement('option');
                                            option.value = category.id;
                                            option.textContent = category.name; // Use category->name as per your model/migration
                                            categorySelect.appendChild(option);
                                        });
                                        categorySelect.disabled = false;
                                    } else {
                                        categorySelect.innerHTML = '<option value="">No Categories Found</option>';
                                        categorySelect.disabled = true;
                                    }
                                })
                                .catch(error => {
                                    console.error('Error fetching categories:', error);
                                    alert('Could not load categories. Check console for details.');
                                    resetCategorySelect();
                                });
            
                        } else {
                            // If "Select" is chosen, reset the category dropdown
                            resetCategorySelect();
                        }
                    });
                });
            </script>

            @endsection
