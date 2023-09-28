@extends('backend.layouts.app')

@section('page_title')
    <div class="breadcrumbs-area clearfix">
        <h4 class="page-title pull-left">Roles</h4>
        <ul class="breadcrumbs pull-left">
            <li><a href="{{ route('dashboard') }}">Home</a></li>
            <li><span>Roles</span></li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="col-lg-12 mt-3 mb-3 row">
        <div class="col-lg-11"></div>
       <a href="{{ route('roles.create') }}">
            <button type="button" class="btn btn-primary">Create</button>
       </a>

    </div>
    <div class="col-lg-12 mt-1">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Thead dark</h4>
                <div class="single-table">
                    <div class="table-responsive">
                        <table class="table text-center" id="mytable">
                            <thead class="text-uppercase bg-dark">
                                <tr class="text-white">
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Guard_name</th>
                                    <th scope="col">action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($role as $role)
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->title }}</td>
                                        <td>{{ $role->guard_name }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <form method="POST" action="{{ route('roles.destroy', $role->id) }}" >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"  style="border: none; background: none; padding: 0;" ><i class="fa fa-trash" style="color: blue;"></i></button>
                                                </form>

                                                 <a href="{{ $role->id }}" class="ml-5 editButton" data-id="{{ $role->id }}" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-edit"></i></a>
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

    <!-- Bootstrap Modal -->
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
                    <form id="myForm" action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="role_id">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="guard_name">Guard Name:</label>
                            <input type="text" name="guard_name" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Create Role</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
$(document).ready(function() {
    $('#myForm').on('submit', function(e) {
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "{{ route('products.store') }}",
            data: formData,
            success: function(response) {
                console.log(response);

                var newRow = $('<tr>')
                    .append($('<td>').text(response.id))
                    .append($('<td>').text(response.name))
                    .append($('<td>').text(response.price))
                    .append($('<td>').text(response.discount))
                    .append($('<td>').text(response.catagory_id))
                    .append($('<td>').html('<div class="d-flex"><form method="POST" action="' + response.delete_route + '"><button type="submit" style="border: none; background: none; padding: 0;"><i class="fa fa-trash" style="color: blue;"></i></button></form><a href="' + response.edit_route + '" class="ml-5"><i class="fa fa-edit"></i></a></div>'));

                $('#mytable tbody').append(newRow);
                console.log(newRow);

                $('#exampleModal').modal('hide');
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
});

                $(document).ready(function() {
                    $('#mytable').dataTable({
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





// for edit model form
$(document).ready(function() {
  $('.editButton').click(function() {
    // Get the parent row of the clicked button
    var $row = $(this).closest('tr');

    // Retrieve the data from the cells within the row
    var id = $row.find('td:nth-child(1)').text();
    var name = $row.find('td:nth-child(2)').text();
    var title = $row.find('td:nth-child(3)').text();
    var guard_name = $row.find('td:nth-child(4)').text();

    // Populate the form fields with the retrieved data
    $('#exampleModal [name="id"]').val(id);
    $('#exampleModal [name="name"]').val(name);
    $('#exampleModal [name="title"]').val(title);
    $('#exampleModal [name="guard_name"]').val(guard_name);

    // Show the modal
    $('#exampleModal').modal('show');
  });

  $('#myForm').on('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission

    var formData = $(this).serialize();
    var roleId = $('#role_id').val(); // Retrieve the role ID from the hidden input field

    $.ajax({
      type: "POST",
      url: "{{ route('roles.update', '') }}/" + roleId,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: formData,
      success: function(response) {
    console.log(response);

    // Update the table row with the updated data
    var $tableRow = $('a.editButton[data-id="' + roleId + '"]').closest('tr');

    $tableRow.find('td:nth-child(2)').text(response.name);
    $tableRow.find('td:nth-child(3)').text(response.title);
    $tableRow.find('td:nth-child(4)').text(response.guard_name);

    // Hide the modal
    $('#exampleModal').modal('hide');
}

    });
  });
});




$(document).ready(function() {
    $('#myButton').click(function() {
        Swal.fire('Hello, SweetAlert!');
    });
});


</script>
@endpush

