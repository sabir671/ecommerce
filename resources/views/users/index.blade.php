@extends('backend.layouts.app')
@section('page_title')
    <div class="breadcrumbs-area clearfix">
        <h4 class="page-title pull-left">users</h4>
        <ul class="breadcrumbs pull-left">
            <li><a href="{{ route('dashboard') }}">Home</a></li>
            <li><span>Users</span></li>
        </ul>
    </div>
@endsection
@section('content')
<div class="col-lg-12 mt-3 mb-3 row">
    <div class="col-lg-11"></div>
   <a href="{{ route('users.create') }}">
        <button type="button" class="btn btn-primary">Create</button>
   </a>
</div>
<div class="col-lg-12 mt-1">
    <div class="card">
        <div class="card-body">
            <h4 class="header-title">Thead dark</h4>
            <div class="single-table">
                <div class="table-responsive">
                    <table class="table text-center" id="tableId">
                        <thead class="text-uppercase bg-dark">
                            <tr class="text-white">
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>

                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <form method="POST" action="{{ route('users.destroy', $user->id) }}" >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"  style="border: none; background: none; padding: 0;" ><i class="fa fa-trash" style="color: blue;"></i></button>
                                            </form>
                                             <a class="ml-5 editButton" data-id="{{ $user->id }}" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-edit"></i></a>
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
                <form id="myForm"  data-action="{{ route('users.update', 'id') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="role_id">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="title">email:</label>
                        <input type="text" name="email" class="form-control" required>
                    </div>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">User</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@push('script')
<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
    $('#myForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        var formData = $(this).serialize();

        $.ajax({
            type: "PUT",
            url: "{{ route('users.store') }}", // Update the URL to the appropriate route for inserting data
            data: formData,
            success: function(response) {
                console.log(response);

                // Append the new row to the table
                var newRow = $('<tr>')
                    .append($('<td>').text(response.id))
                    .append($('<td>').text(response.name))
                    .append($('<td>').text(response.email))
                    .append($('<td>').html('<div class="d-flex"><form method="POST" action="' + response.delete_route + '"><button type="submit" style="border: none; background: none; padding: 0;"><i class="fa fa-trash" style="color: blue;"></i></button></form><a href="' + response.edit_route + '" class="ml-5"><i class="fa fa-edit"></i></a></div>'));
                $('#mytable tbody').append(newRow);
                console.log(newRow);

                $('#exampleModal').modal('hide'); // Hide the modal upon successful form submission
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
});

$(document).ready(function() {
  $('.editButton').click(function() {
    // Get the parent row of the clicked button
    var $row = $(this).closest('tr');

    // Retrieve the data from the cells within the row
     id = $row.find('td:nth-child(1)').text();
    var name = $row.find('td:nth-child(2)').text();
    var email = $row.find('td:nth-child(3)').text();


    // Populate the form fields with the retrieved data
    $('#exampleModal [name="id"]').val(id);
    $('#exampleModal [name="name"]').val(name);
    $('#exampleModal [name="email"]').val(email);

    // var route = {{ route('users.update', 'id') }};
    var route = "{{ route('users.update', '') }}/" + id;
    // console.log(route);
    $("#myForm").attr('action', route);
    // Show the modal
    $('#exampleModal').modal('show');
  });

  $('#myForm').on('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission

    var formData = $(this).serialize();
    var userId = $(this).val(id); // Retrieve the role ID from the hidden input field
    console.clear();
    console.log(id);
    $.ajax({
      type: "PUT",
      url: "{{ route('users.update', '') }}/" + id,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: formData,
      success: function(response) {
    console.log('Success:', response);

    // Update the table row with the updated data
    var $tableRow = $('a.editButton[data-id="' + response.id + '"]').closest('tr');

    $tableRow.find('td:nth-child(2)').text(response.name);
    $tableRow.find('td:nth-child(3)').text(response.email);

    // Hide the modal
    $('#exampleModal').modal('hide');
},

    });
  });
});


$('.deleteButton').click(function() {
    var $form = $(this).closest('.deleteForm');
    var url = $form.attr('action');

    $.ajax({
        type: "DELETE",
        url: url,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log(response);

            // Remove the table row from the DOM
            $form.closest('tr').remove();
        },
        error: function(error) {
            console.log(error);
        }
    });
});

// Swal.fire({
//   title: 'Are you sure?',
//   text: "You won't be able to revert this!",
//   icon: 'warning',
//   showCancelButton: true,
//   confirmButtonColor: '#3085d6',
//   cancelButtonColor: '#d33',
//   confirmButtonText: 'Yes, delete it!'
// }).then((result) => {
//   if (result.isConfirmed) {
//     Swal.fire(
//       'Deleted!',
//       'Your file has been deleted.',
//       'success'
//     )
//   }
// });
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