<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:transaction-list|transaction-create|transaction-edit|transaction-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:transaction-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:transaction-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:transaction-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $transactions = Transaction::latest()->with('client', 'branch')->paginate(5);

        // return  $transactions;
        return response()->json([
            'status' => true,
            'message' => 'transactions retrieve Successfully',
            'transactions' => $transactions
        ], 200);
    }

    public function getTransactions(Request $request,)
    {



        $request->validate([
            'limit' => 'nullable|int',
            'page' => 'nullable|int',
            'keyword' => 'nullable|string',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
            // 'clientid' => 'nullable|date'
            'clientid' => 'nullable|exists:App\Models\Client,id'
        ]);

        $limit = $request->limit ? $request->limit : 10;
        $page = $request->page && $request->page > 0 ? $request->page : 1;
        $skip = ($page - 1) * $limit;

        $keyword = $request->keyword && $request->keyword != null ? $request->keyword : null;
        $from_date = $request->from_date && $request->from_date != null ?  Carbon::createFromFormat('Y-m-d', $request->from_date) : null;
        $to_date = $request->to_date && $request->to_date != null ?  Carbon::createFromFormat('Y-m-d', $request->to_date) : null;
        $clientid = $request->clientid && $request->clientid != null ? $request->clientid : null;


        if ($clientid != null) {
            $totalRecords = Transaction::select('count(*) as allcount')->where('client_id', $clientid)->count();
        } else {
            $totalRecords = Transaction::select('count(*) as allcount')->count();
        }

        $totalRecordswithFilter = Transaction::select('count(*) as allcount')
            ->with('branch', 'client')->when($clientid != null, function ($query) use ($request, $clientid) {

                $query->where('client_id', $clientid);
            })
            ->when($from_date != null && $to_date != null, function ($query) use ($request, $from_date, $to_date) {

                $query->whereBetween(DB::raw('DATE(`date`)'),[$from_date, $to_date]);

            })->when($keyword != null, function ($query) use ($request, $keyword) {

                $query->where('type', 'like', '%' . $keyword . '%')->orWhere('status', 'like', '%' . $keyword . '%')->orWhere('amount', 'like', '%' . $keyword . '%')->orWhereRelation('branch', 'name', 'like', '%' . $keyword . '%');
            })->count();

        $records = Transaction::with('branch', 'client')->when($keyword != null, function ($query) use ($request, $keyword) {

            $query->where('type', 'like', '%' . $keyword . '%')->orWhere('status', 'like', '%' . $keyword . '%')->orWhere('amount', 'like', '%' . $keyword . '%')->orWhereRelation('branch', 'name', 'like', '%' . $keyword . '%');
        })->when($clientid != null, function ($query) use ($request, $clientid) {

            $query->where('client_id', $clientid);
        })
            ->when($from_date != null && $to_date != null, function ($query) use ($request, $from_date, $to_date) {

                $query->whereBetween(DB::raw('DATE(`date`)'),[$from_date, $to_date]);
            })->skip($skip)
            ->take($limit)

            ->get();


        $data_arr = array();

        foreach ($records as $record) {
            $id = $record->id;
            $branch = $record->branch;
            $client = $record->client;
            $type = $record->type;
            $status = $record->status;
            $amount = $record->amount;
            $date = $record->date;

            $data_arr[] = array(
                "id" => $id,

                "type" => $type,
                "status" => $status,
                "amount" => $amount,
                "date" => $date,
                "branch" => $branch,
                "client" => $client
            );
        }



        return response()->json([
            'status' => true,
            'message' => 'Transaction retrieve Successfully',
            "total" => $totalRecords,
            "filtered" => $totalRecordswithFilter,
            "transaction" => $data_arr
        ], 200);
    }



    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        Transaction::create($request->all());

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction created successfully.');
    }

    public function show(Transaction $transaction)
    {
        return view('transactions.show', compact('transactions'));
    }

    public function edit(Transaction $transactions)
    {
        return view('transactions.edit', compact('transactions'));
    }

    public function update(Request $request, Transaction $transactions)
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        $transactions->update($request->all());

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction updated successfully');
    }

    public function destroy(Transaction $transactions)
    {
        $transactions->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully');
    }
}
