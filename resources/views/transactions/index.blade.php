@extends('transactions.layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Transactions List</h2>
                    </div>
                    <div class="card-body">
                        {{-- <a href="{{ url('/transaction/create') }}" class="btn btn-success btn-sm" title="Add New client">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a> --}}
                        <br />
                        <br />
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Client</th>
                                        <th>Branch</th>
                                        <th>type</th>
                                        <th>status</th>
                                        <th>amount</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if ($item->client)
                                                    <a href="{{ url('/clients/' . $item->client->id) }}"
                                                        title="View client"><button class="btn btn-primary btn-sm">
                                                            {{ $item->client->name }}</button></a>
                                                @endif
                                            </td>
                                            <td>{{ $item->branch?$item->branch->name:"Unknown"}}</td>

                                            <td>{{ $item->type }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>{{ $item->amount }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                <a href="{{ url('/transaction/' . $item->id) }}" title="View client"><button
                                                        class="btn btn-info btn-sm"><i class="fa fa-eye"
                                                            aria-hidden="true"></i> View</button></a>
                                                <a href="{{ url('/transaction/' . $item->id . '/edit') }}"
                                                    title="Edit client"><button class="btn btn-primary btn-sm"><i
                                                            class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                        Edit</button></a>
                                                <form method="POST" action="{{ url('/transaction' . '/' . $item->id) }}"
                                                    accept-charset="UTF-8" style="display:inline">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        title="Delete client"
                                                        onclick="return confirm(&quot;Confirm delete?&quot;)"><i
                                                            class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                                </form>
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
    </div>

@endsection
