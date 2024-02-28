<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">

    <!-- Title Page-->
    <title>EG - Filter Meeting</title>

    <!-- Jquery JS-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <!-- Icons font CSS-->
    <link href="{{ asset('vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/datepicker/daterangepicker.css') }}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" media="all">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <link href="{{ asset('css/bootstrap-multiselect.css') }}" rel="stylesheet" media="all">
</head>

<body>
    <div class="page-wrapper bg-gra-02 p-t-130 p-b-100 font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <h2 class="title">Filter Meeting Info</h2>
                    <form action="{{ route('search.submit') }}" method="post">
                        @csrf
                        <div class="form-group">
                        <label for="id-select-calendar">Calendar IDs</label>
                            <select class="form-control multiple-checkboxes" multiple id="id-select-calendar" name="nm_calendar_ids[]">                             
                                @foreach($calendarIds as $calendarId)
                                <option value={{ $calendarId }}>{{ $calendarId }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">
                                @error('nm_calendar_ids')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group mt-3">
                            <label for="id-duration">Duration(In Minutes)</label>
                            <input type="number" class="form-control" id="id-duration" name="nm_duration" placeholder="Duration(In Minutes)">
                            <span class="text-danger">
                                @error('nm_duration')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group mt-3">
                            <label for="id-start-time">Time Interval</label>
                            <input type="time" class="form-control" id="id-start-time" name="nm_start_time" placeholder="Start time interval">
                            <input type="time" class="form-control mt-3" id="id-end-time" name="nm_end_time" placeholder="End time interval">
                            <span class="text-danger">
                                @error('nm_start_time')
                                    {{ $message }}
                                @enderror
                                <br>
                                @error('nm_end_time')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group mt-3">
                            <label for="id-time-slot">Time slot type(Optional)</label>
                            <select class="form-control multiple-checkboxes" multiple="multiple" id="id-time-slot" name="nm_timeslottypes[]">                            
                                @foreach($timeslottypes as $timeslottype)
                                <option value={{ $timeslottype }}>{{ $timeslottype }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">
                                @error('nm_timeslottypes')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="p-t-15 text-center">
                            <button class="btn btn-primary" type="submit">Submit</button>
                            <a href="{{ route('upload.form') }}" class="btn btn-primary" type="submit">Go Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Vendor JS-->
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/datepicker/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/datepicker/daterangepicker.js') }}"></script>
    

    <!-- Main JS-->
    <script src="{{ asset('js/global.js') }}"></script>

    <script>
           $(document).ready(function() {
        $('.multiple-checkboxes').multiselect({
          includeSelectAllOption: true,
        });
    });
    </script>    

</body>

</html>
<!-- end document-->