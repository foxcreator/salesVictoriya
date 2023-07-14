<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.suppliers.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $supplier = Supplier::create($data);

        if ($supplier) {
            return redirect()->route('admin.suppliers')->with('status', "Поставщик {$supplier->name} был успешно добавлен!");
        } else {
            return redirect()->back()->with('warn', 'Oops, something went wrong. Please check the logs.')->withInput();
        }
    }

    public function delete($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();

        return redirect()->back()->with('status', "Поставщик {$supplier->name} успешно удален");
    }
}
