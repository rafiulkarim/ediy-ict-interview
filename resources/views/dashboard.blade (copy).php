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
                        <div class="card-body text-sm">
                            <h1 id="population">Population: <span class="total"></span></h1>
                            <p class="pb-5"></p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="division">Select Division</label>
                                        <select class=" form-control form-control-sm" id="division" name="division">
                                            <option value="">Select One</option>
                                            @foreach($divisions as $division)
                                                <option value="{{ $division->id }}">{{ $division->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="district">Select District</label>
                                        <select class=" form-control form-control-sm" id="district" name="district">
                                            <option value="">Select One</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="upazila">Select Upazila</label>
                                        <select class=" form-control form-control-sm" id="upazila" name="upazila">
                                            <option value="">Select One</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="union">Select Union</label>
                                        <select class=" form-control form-control-sm" id="union" name="union">
                                            <option value="">Select One</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('admin_footer_script')
    <script></script>
    <script>
        function goToMap(a, b){
            console.log(a, b);
        }

        $(document.body).on('change', '#division', function () {
            var id = $(this).val();
            var conceptName = $('#division').find(":selected").text();
            var url = "{{ route('get_district') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    goToMap(response.data[0], conceptName);
                    $('#district').html(response.data[1]);
                    $('.total').html(response.data[0]);
                }
            });
        })

        $(document.body).on('change', '#district', function () {
            var id = $(this).val();
            var url = "{{ route('get_upazila') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    $('#upazila').html(response.data[1]);
                    $('.total').html(response.data[0]);
                }
            });
        })

        $(document.body).on('change', '#upazila', function () {
            var id = $(this).val();
            var url = "{{ route('get_union') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    $('#union').html(response.data[1]);
                    $('.total').html(response.data[0]);
                }
            });
        })

        $(document.body).on('change', '#union', function () {
            var id = $(this).val();
            var url = "{{ route('get_population') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    $('.total').html(response.data);
                }
            });
        })
    </script>
@endsection
