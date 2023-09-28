@extends('backend.layouts.app')

@section('page_title')
<div class="breadcrumbs-area clearfix">
    <h4 class="page-title pull-left">home</h4>
    <ul class="breadcrumbs pull-left">
        <li><a href="{{ route('products.index') }}">products</a></li>
        <li><span>Roles</span></li>
    </ul>
</div>
@endsection

@section('content')
<div class="col-lg-12 mt-3 mb-3 row">
    <div class="col-lg-11"></div>
    <a href="{{ route('products.create') }}">
        <button type="button" class="btn btn-secondary">Create</button>
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
                                <th scope="col">Price</th> <!-- Corrected column name -->
                                <th scope="col">Discount</th>
                                <th scope="col">Catagory_ID</th> <!-- Corrected column name -->
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <!-- Corrected variable name -->
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->price }}</td> <!-- Corrected column name and case -->
                                <td>{{ $product->discount }}</td>
                                <td>{{ $product->catagory_id }}</td> <!-- Corrected column name and case -->

                                <td>
                                    <div class="d-flex">
                                        <form method="POST" action="{{ route('products.destroy', $product->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="border: none; background: none; padding: 0;"><i class="fa fa-trash" style="color: blue;"></i></button>
                                        </form>

                                        <a class="ml-5 editButton" data-id="{{ $product->id }}" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-edit"></i></a>
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
                <form id="myForm" data-action="{{ route('products.update', 'id') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="role_id">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="title">Price:</label>
                        <input type="number" name="price" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="title">Discount:</label>
                        <input type="number" name="discount" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="title">Catagory Id:</label>
                        <input type="number" name="catagory_id" class="form-control" required>
                    </div>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Product</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        $('#myForm').on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                type: "POST"
                , url: "{{ route('products.store') }}"
                , data: formData
                , success: function(response) {
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
                }
                , error: function(error) {
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
            var id = $row.find('td:nth-child(1)').text();
            var name = $row.find('td:nth-child(2)').text();
            var price = $row.find('td:nth-child(3)').text();
            var discount = $row.find('td:nth-child(4)').text();
            var catagory_id = $row.find('td:nth-child(4)').text();


            // Populate the form fields with the retrieved data
            $('#exampleModal [name="id"]').val(id);
            $('#exampleModal [name="name"]').val(name);
            $('#exampleModal [name="price"]').val(price);
            $('#exampleModal [name="discount"]').val(discount);
            $('#exampleModal [name="catagory_id"]').val(catagory_id);


            // Show the modal
            $('#exampleModal').modal('show');
        });

        $('#myForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            var formData = $(this).serialize();
            var roleId = $('#role_id').val(); // Retrieve the role ID from the hidden input field

            $.ajax({
                type: "POST"
                , url: "{{ route('products.update', '') }}/" + roleId
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , data: formData
                , success: function(response) {
                    console.log(response);

                    // Update the table row with the updated data
                    var $tableRow = $('a.editButton[data-id="' + roleId + '"]').closest('tr');

                    $tableRow.find('td:nth-child(2)').text(response.name);
                    $tableRow.find('td:nth-child(3)').text(response.price);
                    $tableRow.find('td:nth-child(4)').text(response.discount);
                    $tableRow.find('td:nth-child(5)').text(response.catagory_id);


                    // Hide the modal
                    $('#exampleModal').modal('hide');
                }

            });
        });
    });
    $(.deleteButton).click(function(event) {

        event.preventDefault;
        var $form = $(this).closest('.deleteForm');
        $.ajax({
            type: "delete"
            , url: url
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , success: function(response) {
                console.log(response);

                // Remove the table row from the DOM
                $form.closest('tr').remove();
            }
            , error: function(error) {
                console.log(error);
            }
        });
    });
    $(document).ready(function() {
        $('#mytable').dataTable({
            dom: 'Bfrtip',

            info: true
            , ordering: false
            , paging: true
            , columnDefs: [{
                    targets: [0]
                    , orderData: [0, 1]
                }
                , {
                    className: 'dt-center'
                    , targets: '_all'
                },

            ]
            , buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });
    });

</script>
