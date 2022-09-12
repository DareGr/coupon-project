<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Email;

class EmailController extends Controller
{
    public function all()
    {
        $coupons = Email::paginate(10);

        $filter = true;

        return view('email.all', compact('coupons', 'filter'));
    }
}
