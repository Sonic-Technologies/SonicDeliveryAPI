<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResourceCollection;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\Request;
use App\Barangay;
use App\Customer;

class CustomerController extends Controller
{
    public function index(): CustomerResourceCollection
    {
        return new CustomerResourceCollection(Customer::all());
    }

    public function show($id): CustomerResource
    {
        $customer = Customer::find($id);

        return new CustomerResource($customer);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'    => 'required',
            'last_name'     => 'required',
            'email'         => 'required',
            'phone'         => 'required',
            'barangay'      => 'required',
            'street'        => 'required',
            'street2'       => 'nullable',
            'city'          => 'required',
            'province'      => 'required',
            'zip'           => 'required'
        ]);
        
        $barangay = Barangay::find($request->barangay);

        $customer = new Customer();
        $customer->first_name   = $request->first_name;
        $customer->last_name    = $request->last_name;
        $customer->email        = $request->email;
        $customer->phone        = $request->phone;
        $customer->barangay     = $barangay->name.$barangay->district;
        $customer->street       = $request->street;
        $customer->street2      = $request->street2;
        $customer->city         = $request->city;
        $customer->province     = $request->province;
        $customer->zip          = $request->zip;
        $customer->save();

        return new CustomerResource($customer);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);

        $customer->first_name   = $request->first_name;
        $customer->last_name    = $request->last_name;
        $customer->email        = $request->email;
        $customer->phone        = $request->phone;
        $customer->barangay     = $request->barangay;
        $customer->street       = $request->street;
        $customer->street2      = $request->street2;
        $customer->city         = $request->city;
        $customer->province     = $request->province;
        $customer->zip          = $request->zip;

        $customer->save();

        return new CustomerResource($customer);
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);

        $customer->delete();

        return "Customer removed";
    }

    public function delete()
    {
        Customer::truncate();

        return "All customers deleted";
    }
}
