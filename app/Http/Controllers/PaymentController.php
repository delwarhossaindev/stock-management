<?php
namespace App\Http\Controllers;
use App\Models\Payment;
use App\Models\Sale;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Payment::with('payable')->latest())
                ->addIndexColumn()
                ->addColumn('reference', function($row) {
                    if ($row->payable_type === Sale::class) return __('Sale') . ': ' . ($row->payable->invoice_no ?? '-');
                    if ($row->payable_type === Purchase::class) return __('Purchase') . ': ' . ($row->payable->purchase_no ?? '-');
                    return '-';
                })
                ->addColumn('type', function($row) {
                    return $row->payable_type === Sale::class ? '<span class="badge bg-success">'.__('Sale').'</span>' : '<span class="badge bg-warning">'.__('Purchase').'</span>';
                })
                ->addColumn('amount_fmt', fn($row) => '৳'.number_format($row->amount, 2))
                ->addColumn('date_fmt', fn($row) => $row->payment_date->format('d/m/Y'))
                ->addColumn('action', fn($row) => '<a href="'.route('payments.show', $row).'" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>')
                ->rawColumns(['type', 'action'])->make(true);
        }
        return view('payments.index');
    }

    public function create()
    {
        $sales = Sale::where('due_amount', '>', 0)->latest()->get();
        $purchases = Purchase::where('due_amount', '>', 0)->latest()->get();
        return view('payments.create', compact('sales', 'purchases'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'payable_type' => 'required|in:sale,purchase',
            'payable_id' => 'required|integer',
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|string',
            'payment_date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        $type = $request->payable_type === 'sale' ? Sale::class : Purchase::class;
        $model = $type::findOrFail($request->payable_id);

        Payment::create([
            'payable_type' => $type,
            'payable_id' => $model->id,
            'amount' => $request->amount,
            'method' => $request->method,
            'payment_date' => $request->payment_date,
            'note' => $request->note,
        ]);

        $model->increment('paid_amount', $request->amount);
        $model->decrement('due_amount', $request->amount);

        return redirect()->route('payments.index')->with('success', __('Payment recorded successfully.'));
    }

    public function show(Payment $payment)
    {
        $payment->load('payable');
        return view('payments.show', compact('payment'));
    }
}
