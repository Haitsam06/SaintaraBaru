<?php

namespace App\Http\Controllers\Personal;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingPersonalController extends Controller
{
    public function index()
    {
        $user = auth()->guard('customer')->user()->id_customer;
        $customer = Customer::where('id_customer', $user)->first();
        return inertia('Personal/setting', [
            'customer' => $customer
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed'
        ]);

         $user = auth()->guard('customer')->user()->id_customer;
        $customer = Customer::where('id_customer', $user)->first();

        if (!Hash::check($request->current_password, $customer->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama salah.'
            ]);
        }

        $customer->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }


    public function deleteAccount()
    {
        $user = auth()->guard('customer')->user()->id_customer;
        $customer = Customer::where('id_customer', $user)->first();
        $customer->delete();

        return redirect('/')->with('success', 'Akun Anda berhasil dihapus.');
    }
}
