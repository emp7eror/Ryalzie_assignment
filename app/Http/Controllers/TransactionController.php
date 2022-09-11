<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

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
        return view('transactions.index', compact('transactions'));
    }

    public function getEmployees(Request $request, $clientid)
    {
        // return ;

        //  return $request->all();
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page
        $page = (int)$start > 0 ? ($start / $rowperpage) + 1 : 1;
        $limit = (int)$rowperpage > 0 ? $rowperpage : 10;
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Transaction::select('count(*) as allcount')->count();
        $totalRecords = Transaction::select('count(*) as allcount')->where('client_id', $clientid)->count();
        $totalRecordswithFilter = Transaction::select('count(*) as allcount')->where('client_id', $clientid)->when($columnName != null && $columnSortOrder != null, function ($query) use ($request, $columnName, $columnSortOrder) {


            $query->orderBy($columnName);
        })
            ->when($searchValue != null, function ($query) use ($request, $searchValue) {

                $query->where('type', 'like', '%' . $searchValue . '%')->orWhere('status', 'like', '%' . $searchValue . '%')->orWhere('amount', 'like', '%' . $searchValue . '%');
            })->count();

        // Fetch records
        $records = Transaction::with('branch')->where('client_id', $clientid)
            ->when($searchValue != null, function ($query) use ($request, $searchValue) {

                $query->where('type', 'like', '%' . $searchValue . '%')->orWhere('status', 'like', '%' . $searchValue . '%')->orWhere('amount', 'like', '%' . $searchValue . '%');
            })->skip($start)->orderBy($columnName, $columnSortOrder)
            ->take($rowperpage)

            ->get();

        // ->skip($start)


        // ->get();
        // $totalRecordswithFilter = 50;
        $data_arr = array();

        foreach ($records as $record) {
            $id = $record->id;
            $branch = $record->branch->name;
            $type = $record->type;
            $status = $record->status;
            $amount = $record->amount;
            $date = $record->date;

            $data_arr[] = array(
                "id" => $id,
                "branch" => $branch,
                "type" => $type,
                "status" => $status,
                "amount" => $amount,
                "date" => $date
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
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
