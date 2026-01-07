<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //Payment Page
    public function paymentMethodsPage(){
        $payments = Payment::when(request('searchKey'),function($query){
            $query->where('account_name','like','%'.request('searchKey').'%');

        })

        ->orderBy('created_at','desc')->paginate(5);

        $paymentMethods = $payments->toArray();

        $categoryCount = count($paymentMethods['data']);


        return view('admin.payment.paymentMethods',compact('payments','paymentMethods'));
    }

    public function paymentMethods( Request $request){
        $this->validationCheck($request);

       Payment::create([
        'account_number' => $request->accountNumber,
        'account_name' => $request->accountName,
        'account_type' => $request->accountType,
    ]);

       return back()->with(['success' => 'create success']);


    }

    //delete payment method
    public function deletePayment($id){
        Payment::destroy($id);
        return back();
    }

    //edit payment method
    public function editPayment($id){
        $payments = Payment::find($id);

        return view('admin.payment.editPayment',compact('payments'));

    }

    //update payment method
    public function updatePayment($id,Request $request){
        $request['id'] = $id;
        $this->validationCheck($request);

       Payment::where('id',$id)->update([
        'account_number' => $request->accountNumber,
        'account_name' => $request->accountName,
        'account_type' => $request->accountType,
       ]);

       return to_route('admin#paymentMethodsPage')->with('success', 'Update Success');
    }


    //validation check for payment

    private function validationCheck($request){

         $request->validate([
            'accountName' => 'required|min:2|max:30|unique:payments,account_name,'.$request->id, //self->skip|others->check
            'accountNumber' => 'required|min:2|max:30',
            'accountType' => 'required|min:2|max:30',
        ],[
            'accountName.unique' => 'account name is already taken',
            'accountName.min' => 'account name must have at least two letters'

        ]);

    }
}
