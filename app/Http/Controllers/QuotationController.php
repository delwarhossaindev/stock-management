<?php

namespace App\Http\Controllers;

use App\Mail\QuotationMail;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Quotation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class QuotationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $quotations = Quotation::with('customer')->withCount('items')->latest();
            return DataTables::of($quotations)
                ->addIndexColumn()
                ->addColumn('date_fmt', fn($row) => $row->quotation_date->format('d/m/Y'))
                ->editColumn('quotation_no', fn($row) => '<strong>' . $row->quotation_no . '</strong>')
                ->addColumn('customer_display', fn($row) => $row->customer->name ?? ($row->customer_name ?? '-'))
                ->addColumn('total_price_fmt', fn($row) => '<strong>৳' . number_format($row->total_price, 2) . '</strong>')
                ->addColumn('action', function ($row) {
                    $show = route('quotations.show', $row);
                    $btn = '<a href="' . $show . '" class="btn btn-sm btn-info" title="' . __('View') . '" data-bs-toggle="tooltip"><i class="bi bi-eye"></i></a>';
                    if (auth()->user()->isAdmin()) {
                        $edit = route('quotations.edit', $row);
                        $delete = route('quotations.destroy', $row);
                        $btn .= ' <a href="' . $edit . '" class="btn btn-sm btn-warning" title="' . __('Edit') . '" data-bs-toggle="tooltip"><i class="bi bi-pencil"></i></a>
                            <form action="' . $delete . '" method="POST" class="d-inline" onsubmit="return confirm(\'' . __('Are you sure?') . '\')">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button class="btn btn-sm btn-danger" title="' . __('Delete') . '" data-bs-toggle="tooltip"><i class="bi bi-trash"></i></button>
                            </form>';
                    }
                    return $btn;
                })
                ->rawColumns(['quotation_no', 'total_price_fmt', 'action'])
                ->make(true);
        }
        return view('quotations.index');
    }

    public function create()
    {
        $products = Product::all();
        $customers = Customer::orderBy('name')->get();
        $quotationNo = Quotation::generateQuotationNo();
        return view('quotations.create', compact('products', 'customers', 'quotationNo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'customer_name' => 'nullable|string|max:255',
            'quotation_date' => 'required|date',
            'discount' => 'nullable|numeric|min:0',
            'tax_type' => 'nullable|in:percentage,fixed',
            'tax_value' => 'nullable|numeric|min:0',
            'note' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $subtotal = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                $lineTotal = $item['quantity'] * $item['unit_price'];
                $subtotal += $lineTotal;
                $itemsData[] = [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total' => $lineTotal,
                ];
            }

            $discount = $request->discount ?? 0;
            $afterDiscount = $subtotal - $discount;
            $taxType = $request->tax_type ?? 'percentage';
            $taxValue = $request->tax_value ?? 0;
            $taxAmount = $taxType === 'percentage' ? ($afterDiscount * $taxValue / 100) : $taxValue;
            $totalPrice = $afterDiscount + $taxAmount;

            $quotation = Quotation::create([
                'quotation_no' => Quotation::generateQuotationNo(),
                'customer_id' => $request->customer_id,
                'customer_name' => $request->customer_name,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax_type' => $taxType,
                'tax_value' => $taxValue,
                'tax_amount' => $taxAmount,
                'total_price' => $totalPrice,
                'quotation_date' => $request->quotation_date,
                'note' => $request->note,
            ]);

            foreach ($itemsData as $itemData) {
                $quotation->items()->create($itemData);
            }
        });

        return redirect()->route('quotations.index')->with('success', __('Quotation saved successfully.'));
    }

    public function show(Quotation $quotation)
    {
        $quotation->load('customer', 'items.product');
        return view('quotations.show', compact('quotation'));
    }

    public function edit(Quotation $quotation)
    {
        $quotation->load('items');
        $products = Product::all();
        $customers = Customer::orderBy('name')->get();
        return view('quotations.edit', compact('quotation', 'products', 'customers'));
    }

    public function update(Request $request, Quotation $quotation)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'customer_name' => 'nullable|string|max:255',
            'quotation_date' => 'required|date',
            'discount' => 'nullable|numeric|min:0',
            'tax_type' => 'nullable|in:percentage,fixed',
            'tax_value' => 'nullable|numeric|min:0',
            'note' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $quotation) {
            $quotation->items()->delete();

            $subtotal = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                $lineTotal = $item['quantity'] * $item['unit_price'];
                $subtotal += $lineTotal;
                $itemsData[] = [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total' => $lineTotal,
                ];
            }

            $discount = $request->discount ?? 0;
            $afterDiscount = $subtotal - $discount;
            $taxType = $request->tax_type ?? 'percentage';
            $taxValue = $request->tax_value ?? 0;
            $taxAmount = $taxType === 'percentage' ? ($afterDiscount * $taxValue / 100) : $taxValue;
            $totalPrice = $afterDiscount + $taxAmount;

            $quotation->update([
                'customer_id' => $request->customer_id,
                'customer_name' => $request->customer_name,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax_type' => $taxType,
                'tax_value' => $taxValue,
                'tax_amount' => $taxAmount,
                'total_price' => $totalPrice,
                'quotation_date' => $request->quotation_date,
                'note' => $request->note,
            ]);

            foreach ($itemsData as $itemData) {
                $quotation->items()->create($itemData);
            }
        });

        return redirect()->route('quotations.index')->with('success', __('Quotation updated successfully.'));
    }

    public function destroy(Quotation $quotation)
    {
        $quotation->delete();
        return redirect()->route('quotations.index')->with('success', __('Quotation deleted successfully.'));
    }

    public function downloadPdf(Quotation $quotation)
    {
        $quotation->load('customer', 'items.product');
        $pdf = Pdf::loadView('quotations.pdf', compact('quotation'));
        return $pdf->download($quotation->quotation_no . '.pdf');
    }

    public function sendEmail(Request $request, Quotation $quotation)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $quotation->load('customer', 'items.product');
        $pdf = Pdf::loadView('quotations.pdf', compact('quotation'));
        $pdfContent = $pdf->output();

        Mail::to($request->email)->send(new QuotationMail($quotation, $pdfContent));

        return redirect()->route('quotations.show', $quotation)->with('success', __('Quotation emailed successfully.'));
    }
}
