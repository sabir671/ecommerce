@extends('backend.layouts.app')

@section('page_title')
<div class="breadcrumbs-area clearfix">
    <h4 class="page-title pull-left">home</h4>
    <ul class="breadcrumbs pull-left">
        <li><a href="">products</a></li>
        <li><span>Roles</span></li>
    </ul>
</div>
@endsection
@section('content')
<div class="col-lg-12 mt-3 mb-3 row">
    <div class="col-lg-11"></div>
    <a href="{{ route('catagories.create') }}">
        <button type="button" class="btn btn-info">Create</button>
    </a>
</div>
<div class="col-lg-12 mt-1">
    <div class="card">
        <div class="card-body">
            <h4 class="header-title">Products</h4>
            <div class="single-table">
                <div class="table-responsive">
                    <table class="table text-center" id="mytable">
                        <thead class="text-uppercase bg-dark">
                            <tr class="text-white">
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Status</th> <!-- Corrected column name -->
                                <th scope="col">Parent_id</th>
                                <th scope="col">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($catagories as $catagory)
                            <!-- Corrected variable name -->
                            <tr>
                                <td>{{ $catagory->id }}</td>
                                <td>{{ $catagory->name }}</td>
                                <td>{{ $catagory->status }}</td> <!-- Corrected column name and case -->
                                <td>{{ $catagory->parent_id }}</td>
                                <!-- Corrected column name and case -->

                                <td>
                                    <div class="d-flex">
                                        <form method="POST" action="{{ route('catagories.destroy', $catagory->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="border: none; background: none; padding: 0;"><i class="fa fa-trash" style="color: blue;"></i></button>
                                        </form>

                                        <a class="ml-5 editButton" data-id="{{ $catagory->id }}" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-edit"></i></a>
                                    </div>
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="myForm" data-action="{{ route('catagories.update', 'id') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="role_id">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="title">status</label>
                        <input type="text" name="status" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="title">Parent_id</label>
                        <input type="text" name="parent_id" class="form-control" required>
                    </div>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection


@stack('script')
<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        $('.deleteButton').click(function() {
            $form = $(this).closest('.deleteForm');
            var url = $form.attr('action');
            $.ajax({
                type: 'DELETE'
                , url: url
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , success: function(response) {
                    console.log(response);
                    $form.closest('tr').remove();
                }
                , error: function(error) {
                    console.log(error);
                }
            });
        });
    });

    $(document).ready(function() {
        $('.editButton').click(function() {
            var $row = $(this).closest('tr');
            var id = $row.find('td:nth-child(1)').text();
            var name = $row.find('td:nth-child(2)').text();
            var status = $row.find('td:nth-child(3)').text();
            var parent_id = $row.find('td:nth-child(4)').text();

            $('#exampleModal [name="id"]').val(id);
            $('#exampleModal [name="name"]').val(name);
            $('#exampleModal [name="status"]').val(status);
            $('#exampleModal [name="parent_id"]').val(parent_id);

            var route = "{{ route('catagories.update', '') }}/" + id;
            $("#myForm").attr('action', route);

            // Show the modal
            $('#exampleModal').modal('show');
        });

        $('#myForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            var formData = $(this).serialize();
            var id = $('input[name="id"]').val(); // Retrieve the ID from the hidden input field

            $.ajax({
                type: "PUT"
                , url: "{{ route('catagories.update', '') }}/" + id
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , data: formData
                , success: function(response) {
                    console.log('Success:', response);

                    // Update the table row with the updated data
                    var $tableRow = $('a.editButton[data-id="' + response.id + '"]').closest('tr');

                    $tableRow.find('td:nth-child(2)').text(response.name);
                    $tableRow.find('td:nth-child(3)').text(response.status);
                    $tableRow.find('td:nth-child(4)').text(response.parent_id);

                    // Hide the modal
                    $('#exampleModal').modal('hide');
                }
                , error: function(error) {
                    console.log('Error:', error);
                }
            });
        });
    });
    $(document).ready(function() {
                                                        $('#tableId').dataTable({
                                                            dom: 'Bfrtip',

                                                            info: true,
                                                            ordering: false,
                                                            paging: true,
                                                            columnDefs: [
                                                                {
                                                                    targets: [0],
                                                                    orderData: [0, 1]
                                                                },
                                                                {
                                                                    className: 'dt-center', targets: '_all'
                                                                },

                                                            ],
                                                            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                                                        });
                                                    });


</script>
