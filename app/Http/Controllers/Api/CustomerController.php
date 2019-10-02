<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
use App\Http\Resources\Customer\CustomerResource;
use App\Http\Resources\Customer\CustomerCollection;
class CustomerController extends Controller
{
    public function allCustomers(){

        return new CustomerCollection(Customer::orderBy('id', 'desc')->paginate(10));
        
    }

    public function customerDetails($customerId)
    {
        return new CustomerResource(Customer::find($customerId));
    }

    public function addCustomer(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:customers,email',
            'phone' => 'required|numeric',
            'address' => 'required',
            'total_buy' => 'required|numeric'
        ]);
        $addCustomer = new Customer();
        $addCustomer->name = $request->name;
        $addCustomer->email = $request->email;
        $addCustomer->phone = $request->phone;
        $addCustomer->address = $request->address;
        $addCustomer->total_buy = $request->total_buy;
        $addCustomer->save();
        return new CustomerResource($addCustomer);

    }

    public function updateCustomer(Request $request, $customerId)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:customers,email,'.$customerId,
            'phone' => 'required|numeric',
            'address' => 'required',
            'total_buy' => 'required|numeric'
        ]);
        $updateCustomer = Customer::find($customerId);
        $updateCustomer->name = $request->name;
        $updateCustomer->email = $request->email;
        $updateCustomer->phone = $request->phone;
        $updateCustomer->address = $request->address;
        $updateCustomer->total_buy = $request->total_buy;
        $updateCustomer->save();
        return response()->json(['successMsg' => 'Data updated successfully', 'status' => 200]);
    }
    public function deleteCustomer($customerId){
        $deleteCustomer = Customer::findOrFail($customerId);
        $deleteCustomer->delete();
        return response()->json(['successMsg' => 'Data deleted successfully :)', 'status' => 200]);
    }
     public function searchCustomer($fieldName, $query)
     {
         $searchCustomer = Customer::where($fieldName, 'LIKE', "%$query%")->latest()->paginate();

         return new CustomerCollection($searchCustomer);
     }
}
