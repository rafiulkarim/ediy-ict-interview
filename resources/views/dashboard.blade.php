@extends('layouts.backend_layout')

@section('admin_header_script')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/map.css') }}">
@endsection

@section('admin_content')
    <div class="content-header">
{{--        <div class="container-fluid">--}}
{{--            <div class="row mb-2">--}}
{{--                <div class="col-sm-6">--}}
{{--                    <h1 class="m-0">{{ $title }}</h1>--}}
{{--                </div><!-- /.col -->--}}
{{--                <div class="col-sm-6">--}}
{{--                    <ol class="breadcrumb float-sm-right">--}}
{{--                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>--}}
{{--                        <li class="breadcrumb-item active">{{ $title }}</li>--}}
{{--                    </ol>--}}
{{--                </div><!-- /.col -->--}}
{{--            </div><!-- /.row -->--}}
{{--        </div><!-- /.container-fluid -->--}}
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-sm">
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
                            <b><p id="population">Population: <span class="total"></span></p></b>
                            <div id="map-box">
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('admin_footer_script')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="{{ asset('assets/js/map/bd-divisions.js') }}"></script>
    <script src="{{ asset('assets/js/map/bd-districts.js') }}"></script>
    <script src="{{ asset('assets/js/map/division.js') }}"></script>
    <script src="{{ asset('assets/js/map/district.js') }}"></script>
    <script src="{{ asset('assets/js/map.js') }}"></script>
    <script>
        function goToDivision(p, division) {
            goDivision(p, division)
        }

        function goToDistrict(p, district) {
            goDistrict(p, district);
        }

        $(document.body).on('change', '#division', function () {
            var id = $(this).val();
            var divisionName = $('#division').find(":selected").text();
            var url = "{{ route('get_district') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    goToDivision(response.data[0], divisionName);
                    $('#district').html(response.data[1]);
                    $('.total').html(response.data[0]);
                }
            });
        })

        $(document.body).on('change', '#district', function () {
            var id = $(this).val();
            var districtName = $('#district').find(":selected").text();
            var url = "{{ route('get_upazila') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    goToDistrict(response.data[0], districtName)
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
