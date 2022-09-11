@extends('clients.layout')
@section('content')
    <div class="container">

        <div class="card">
            <div class="card-header">Client Information</div>
            <div class="card-body">


                <div class="card-body">
                    <h5 class="card-title">Name : {{ $clients->name }}</h5>
                    <p class="card-text">Address : {{ $clients->address }}</p>
                    <p class="card-text">Mobile : {{ $clients->mobile }}</p>
                </div>

                </hr>

            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-header">Client Transaction Page</div>
            <div class="card-body">
                <table>
                    <tr>
                        <td>
                            <input type='text' readonly id='search_fromdate' class="datepicker" placeholder='From date'>
                        </td>
                        <td>
                            <input type='text' readonly id='search_todate' class="datepicker" placeholder='To date'>
                        </td>
                        <td>
                            <input type='button' id="btn_search" value="Search">
                        </td>
                    </tr>
                </table>

                <table id="thetable" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Branch</th>
                            <th>type</th>
                            <th>status</th>
                            <th>amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            // Datapicker
            $(".datepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });


            var table = $('#thetable').DataTable({
                processing: true,
                serverSide: true,
                // ajax: "{{ $clients->id }}/getTransactions",
                'ajax': {
                    'url': "{{ $clients->id }}/getTransactions",
                    'data': function(data) {
                        // Read values
                        var from_date = $('#search_fromdate').val();
                        var to_date = $('#search_todate').val();

                        // Append to data
                        data.searchByFromdate = from_date;
                        data.searchByTodate = to_date;
                    }
                },

                paging: true,
                filter: true,
                ordering: true,
                info: true,
                columns: [{
                        data: 'id',
                        name: 'id',
                    },
                    {
                        data: 'branch',
                        name: 'branch',
                        orderable: false


                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    }

                ],
            });


            $('#btn_search').click(function() {
                table.draw();
            });

        });
    </script>
@endsection
