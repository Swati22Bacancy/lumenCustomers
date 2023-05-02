<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $customers = Customer::all();
        return $this->successResponse($customers);
    }

    //Create new customer
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|min:10',
        ];

        $this->validate($request, $rules);

        $customer = Customer::create($request->all());

        return $this->successResponse($customer, Response::HTTP_CREATED);
    }

    //Show the customer
    public function show($customer)
    {
        $customer = Customer::findOrFail($customer);

        return $this->successResponse($customer);
    }

    //Update the customer
    public function updatecustomer(Request $request, $customer)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'phone' => 'required',
        ];

        $this->validate($request, $rules);

        $customer = Customer::findOrFail($customer);

        $customer->fill($request->all());

        if ($customer->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $customer->save();

        return $this->successResponse($customer);
    }

    //Remove the customer
    public function destroy($customer)
    {
        $customer = Customer::findOrFail($customer);

        $customer->delete();

        return $this->successResponse($customer);
    }

    //
}
