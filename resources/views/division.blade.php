@extends('layouts.backend_layout')

@section('admin_header_script')
@endsection

@section('admin_content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $title }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            @if (session('danger'))
                                <div class="alert alert-danger">
                                    {{ session('danger') }}
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6">
                                    <div class="text-right pb-2">
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#add-division">
                                            + Add Division
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="add-division" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Add Division</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" id="division-form">
                                                <input type="hidden" name="action" id="add-action" value="add-division">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="division" class="col-form-label">Division
                                                                Name<span
                                                                    class="required">*</span></label>
                                                            <input type="text" name="division"
                                                                   class="form-control form-control-sm"
                                                                   id="division"
                                                                   placeholder="Enter Division Name" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" id="division-submit"
                                                            class="btn btn-primary btn-sm">Submit
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="edit-division" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Edit Division</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="get" id="edit-division-form">
                                                <input type="hidden" name="action" id="edit-action" value="edit-division">
                                                <input type="hidden" name="id" id="division-id">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="division" class="col-form-label">Division
                                                                Name<span
                                                                    class="required">*</span></label>
                                                            <input type="text" name="division"
                                                                   class="form-control form-control-sm"
                                                                   id="get-division"
                                                                   placeholder="Enter Division Name" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" id="division-edit"
                                                            class="btn btn-primary btn-sm">Submit
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal -->
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="text-sm text-center">Division Name</th>
                                    <th class="text-sm text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody id="bodyData">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('admin_footer_script')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('#division-form').validate({
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });


        function fetchData() {
            $(document).ready(function () {
                var url = "{{route('getDivisions')}}";
                $.ajax({
                    url: url,
                    type: "GET",
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    cache: false,
                    dataType: 'json',
                    success: function (dataResult) {
                        console.log(dataResult);
                        var resultData = dataResult.data;
                        var bodyData = '';
                        var i = 1;
                        $.each(resultData, function (index, row) {
                            // var editUrl = url+'/'+row.id+"/edit";
                            bodyData += "<tr>"
                            bodyData += `<td class="text-sm text-center align-middle">` + row.name + `</td>
                            <td class="text-sm text-center align-middle">
                                <i class="fas fa-edit text-primary icon pr-2" data-toggle="modal"
                                   data-target="#edit-division" id="edit-division-id" data-id="` + row.id + `"
                                   style="cursor: pointer" title="Edit Tenant"></i>
                                    <i class="fas fa-trash text-danger icon pr-2" id="delete" data-id="` + row.id + `"></i>
                            </td>`;
                            bodyData += "</tr>";

                        })
                        $("#bodyData").html(bodyData);
                    }
                });
            });
        }

        $(document).ready(function () {
            fetchData();
        });

        $(document.body).on('submit', '#division-form', function (e) {
            e.preventDefault();
            var division = $('#division').val();
            var action = $('#add-action').val();

            var url = "{{ route('division_process') }}"
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    action: action,
                    division: division,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.status == true) {
                        $("#division-form")[0].reset();
                        fetchData();
                        $('#add-division').modal('hide');
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: 'Division Added successfully'
                        })
                    }
                }
            })
        })

        $(document.body).on('click', '#edit-division-id', function () {
            var id = $(this).attr('data-id');

            var url = "{{ route('edit_division') }}"
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    $('#get-division').val(response.data['name']);
                    $('#division-id').val(response.data['id']);
                }
            })
        })

        $(document.body).on('submit', '#edit-division-form', function (e) {
            e.preventDefault();
            var division = $('#get-division').val();
            var action = $('#edit-action').val();
            var id = $('#division-id').val();

            var url = "{{ route('division_process') }}"
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    id: id,
                    division: division,
                    action: action,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.status == true) {
                        $("#edit-division-form")[0].reset();
                        fetchData();
                        $('#edit-division').modal('hide');
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: 'Division Updated successfully'
                        })
                    }
                }
            })
        })


        $(document.body).on('click', '#delete', function () {
            Swal.fire({
                title: 'Are you sure want to delete this?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = $(this).attr('data-id');
                    var url = "{{ route('division_process') }}"
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.status == true) {
                                fetchData();
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                                    }
                                })

                                Toast.fire({
                                    icon: 'success',
                                    title: 'Division Deleted successfully'
                                })
                            }
                        }
                    })
                }
            })
        })
    </script>
@endsection
