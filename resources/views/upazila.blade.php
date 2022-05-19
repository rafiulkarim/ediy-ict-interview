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
                                                data-target="#add-upazila">
                                            + Add Upazila
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="add-upazila" tabindex="-1" role="dialog"
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
                                            <form method="post" id="upazila-form">
                                                <input type="hidden" name="action" id="add-action" value="add-upazila">
                                                <div class="form-group">
                                                    <label for="district" class="col-form-label">Upazila
                                                        Name<span
                                                            class="required">*</span></label>
                                                    <input type="text" name="upazila"
                                                           class="form-control form-control-sm"
                                                           id="upazila"
                                                           placeholder="Enter Upazila Name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="division">Select Division<span
                                                            class="required">*</span></label>
                                                    <select class="form-control form-control-sm division" id="division"
                                                            name="division" required>
                                                        <option value="">Select Division</option>
                                                        @foreach($divisions as $division)
                                                            <option
                                                                value="{{ $division->id }}"> {{ $division->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="district">Select District<span
                                                            class="required">*</span></label>
                                                    <select class="form-control form-control-sm district" id="district"
                                                            name="district" required>
                                                        <option value="">Select District</option>
                                                    </select>
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

                            <div class="modal fade" id="edit-upazila" tabindex="-1" role="dialog"
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
                                            <form method="get" id="edit-upazila-form">
                                                <input type="hidden" name="action" id="edit-action"
                                                       value="edit-upazila">
                                                <input type="hidden" name="id" id="upazila-id">
                                                <div class="form-group">
                                                    <label for="division" class="col-form-label">District
                                                        Name<span
                                                            class="required">*</span></label>
                                                    <input type="text" name="division"
                                                           class="form-control form-control-sm"
                                                           id="get-upazila"
                                                           placeholder="Enter Upazila Name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="division">Select Division<span
                                                            class="required">*</span></label>
                                                    <select class="form-control form-control-sm division" id="get-division"
                                                            name="division" required>
                                                        <option value="">Select Division</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="district">Select District<span
                                                            class="required">*</span></label>
                                                    <select class="form-control form-control-sm district" id="get-district"
                                                            name="district" required>
                                                    </select>
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
                                    <th class="text-sm text-center">Upazila Name</th>
                                    <th class="text-sm text-center">District Name</th>
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
        $('#upazila-form').validate({
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
                var url = "{{route('getUpazila')}}";
                $.ajax({
                    url: url,
                    type: "GET",
                    cache: false,
                    dataType: 'json',
                    success: function (dataResult) {
                        console.log(dataResult);
                        var resultData = dataResult.data;
                        var bodyData = '';
                        $.each(resultData, function (index, row) {
                            bodyData += "<tr>"
                            bodyData += `<td class="text-sm text-center align-middle">` + row.name + `</td>
                            <td class="text-sm text-center align-middle">` + row.district.name + `</td>
                            <td class="text-sm text-center align-middle">` + row.district.division.name + `</td>
                            <td class="text-sm text-center align-middle">
                                <i class="fas fa-edit text-primary icon pr-2" data-toggle="modal"
                                   data-target="#edit-upazila" id="edit-upazila-id" data-id="` + row.id + `"
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

        $(document.body).on('change', '.division', function (e) {
            let division_id = $(this).val();
            var url = "{{ route('district_find') }}";
            console.log('comes');
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    division_id: division_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    $('.district').html(response);
                }
            });
        });

        $(document.body).on('submit', '#upazila-form', function (e) {
            e.preventDefault();
            var upazila = $('#upazila').val();
            var action = $('#add-action').val();
            var district = $('#district').val();

            var url = "{{ route('upazila_process') }}"
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    action: action,
                    upazila: upazila,
                    district: district,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.status == true) {
                        $("#upazila-form")[0].reset();
                        fetchData();
                        $('#add-upazila').modal('hide');
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
                            title: 'Upazila Added successfully'
                        })
                    }
                }
            })
        })

        $(document.body).on('click', '#edit-upazila-id', function () {
            var id = $(this).attr('data-id');

            var url = "{{ route('edit_upazila') }}"
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    $('#get-upazila').val(response.data[0]['name']);
                    $('#upazila-id').val(response.data[0]['id']);
                    var resultData = response.data[1];
                    var option = '';
                    option += `<option value="">Select District</option>`;
                    $.each(resultData, function (index, row) {
                        if (row.id === response.data[0].district['id']) {
                            option += `<option value="` + row.id + `" selected>` + row.name + `</option>`;
                        } else {
                            option += `<option value="` + row.id + `">` + row.name + `</option>`;
                        }
                    });
                    $('#get-district').html(option);

                    var division = response.data[2];
                    var op = '';
                    op += `<option value="">Select Division</option>`;
                    $.each(division, function (index, row) {
                        if (row.id === response.data[0].district.division['id']) {
                            op += `<option value="` + row.id + `" selected>` + row.name + `</option>`;
                        } else {
                            op += `<option value="` + row.id + `">` + row.name + `</option>`;
                        }
                    });
                    $('#get-division').html(op);
                }
            })
        })

        $(document.body).on('submit', '#edit-upazila-form', function (e) {
            e.preventDefault();
            var upazila = $('#get-upazila').val();
            var district = $('#get-district').val();
            var action = $('#edit-action').val();
            var id = $('#upazila-id').val();

            console.log(district, division, action, id);

            var url = "{{ route('upazila_process') }}"
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    id: id,
                    upazila: upazila,
                    district: district,
                    action: action,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.status == true) {
                        $("#edit-upazila-form")[0].reset();
                        fetchData();
                        $('#edit-upazila').modal('hide');
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
                            title: 'Upazila Updated successfully'
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
                    var url = "{{ route('upazila_process') }}"
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
                                    title: 'Upazila Deleted successfully'
                                })
                            }
                        }
                    })
                }
            })
        })
    </script>
@endsection
