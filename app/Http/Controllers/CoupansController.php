<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\coupans;
use App\Models\orders_confirm;
use PhpParser\Node\Stmt\TryCatch;
use Yajra\DataTables\DataTables;

class CoupansController extends Controller
{
    public function index()
    {

        if (\request()->ajax()) {
            $data = coupans::with('users')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<!-- <a href="' . route('coupans.edit', [base64_encode($row->id)]) . '" class="edit btn btn-success btn-sm">Edit</a> -->
                  <a href="' . route('coupans.delete', $row->id) . '" class="delete btn btn-danger btn-sm" onclick="return confirm(\'Are You sure to delete this coupans\')">Delete</a>';
                    return $actionBtn;
                })
                ->addColumn('status', function ($row) {
                    return $row->status == 1 ? "Active" : "Inactive";
                })
                ->rawColumns(['action', 'type'])
                ->make(true);
        }
        return view('admin.Coupans.index');
    }

    public function add()
    {
        $users = User::orderBy('id', 'desc')->get();
        return view('admin.Coupans.add', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'coupans_code' => 'required',
            'amount' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'coupon_count' => 'required',
        ]);
        $coupansdata = new coupans;
        $coupansdata->coupans_code = $request->coupans_code;
        $coupansdata->type = 'Unused';
        $coupansdata->amount = $request->amount;
        $coupansdata->coupon_count = $request->coupon_count;
        $coupansdata->start_date = $request->start_date;
        $coupansdata->end_date = $request->end_date;
        if ($coupansdata->save()) {
            return redirect()->route('coupans.index')->with('success', 'coupans successfully added');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error in coupans add. Please try again');
        }
    }

    public function edit($id)
    {
        $getcopans = coupans::findOrFail(base64_decode($id));
        $users = User::orderBy('id', 'desc')->get();
        return view('admin.Coupans.edit', compact('getcopans', 'users'));
    }

    public function uptate($id, Request $request)
    {
        $request->validate([
            'coupans_code' => 'required',
            'amount' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        $coupansdata = coupans::find($id);
        $coupansdata->coupans_code = $request->coupans_code;
        $coupansdata->type = 'Unused';
        $coupansdata->amount = $request->amount;
        $coupansdata->start_date = $request->start_date;
        $coupansdata->end_date = $request->end_date;
        if ($coupansdata->save()) {
            return redirect()->route('coupans.index')->with('success', 'coupans successfully Edit');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error in coupans Edit. Please try again');
        }
    }

    public function coupansdelete($id)
    {
        $coupans = coupans::find($id);
        if (!is_null($coupans)) {
            $coupans->delete();
            return redirect()->back()->with('success', 'coupans  successfully deleted');
        }
    }



    // COUPON DATA FOR FRONTEND
    
    public function couponcodes(Request $request)
    {
        try {
            $getUser = \App\Helpers\Helper::getUser();
            $couponCode = $request->input('couponCode');
            $subtotal = intval($request->input('subtotal'));

            if (!$getUser) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please log in.',
                ], 401);
            }

            // Already used coupon by the same user
            $ticketCheck = orders_confirm::where('user_id', $getUser->id)
                ->where('coupon_code', $couponCode)
                ->first();

            if ($ticketCheck) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already used this coupon.',
                ]);
            }

            if (empty($couponCode) || $subtotal <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid coupon code or subtotal.',
                ]);
            }

            $couponData = Coupans::where('coupans_code', $couponCode)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->where('amount', '<=', $subtotal)
                ->where('status', 1)
                ->first();

            if (!$couponData) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or expired coupon code.',
                ]);
            }

            // ✅ Check if coupon count is available
            if ($couponData->coupon_count <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'This coupon has reached its usage limit.',
                ]);
            }

            // Calculate discount
            $discountAmount = round(($subtotal * $couponData->amount) / 100);
            /* $discountAmount = $couponData->type === 'percentage'
                ? round(($subtotal / 100) * $couponData->amount)
                : min($couponData->amount, $subtotal); */

            // ✅ Reduce coupon count in DB
            $couponData->decrement('coupon_count');

            // Store in session
            $request->session()->put('couponData', $couponData);
            $request->session()->put('couponType', $couponData->type);
            $request->session()->put('couponAmount', $discountAmount);
            $request->session()->put('amount', $couponData->amount);

            return response()->json([
                'success' => true,
                'couponData' => $couponData,
                'percent' => $couponData->amount,
                'discountAmount' => $discountAmount,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    /*   public function couponcodes(Request $request)
    {
        $getUser = \App\Helpers\Helper::getUser();
        $couponCode = $request->input('couponCode');

        if (!$getUser) {
            return response()->json([
                'success' => false,
                'message' => 'Please log in.',
            ], 401);
        }
        $tcket_chack = orders_confirm::where('user_id', $getUser->id)
            ->where('coupans_code', $couponCode)
            ->first();

        if ($tcket_chack) {
            return response()->json([
                'success' => false,
                'message' => 'You have already used this coupon.',
            ], 200);  // You can set this to 200 to ensure SweetAlert can detect the message properly.
        }


        $request->session()->forget(['couponData', 'couponType', 'couponAmount', 'amount']);
        $subtotal = intval($request->input('subtotal'));

        if (empty($couponCode) || $subtotal <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code or subtotal.',
            ]);
        }

        $couponData = Coupans::where('coupans_code', $couponCode)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('amount', '<=', $subtotal)
            ->where('status', 1)
            ->first();

        if (!$couponData) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired coupon code.',
            ]);
        }

        $couponType = $couponData->type;
        $discountAmount = $couponType === 'percentage'
            ? round(($subtotal / 100) * $couponData->amount)
            : min($couponData->amount, $subtotal);

        $request->session()->put('couponData', $couponData);
        $request->session()->put('couponType', $couponType);
        $request->session()->put('couponAmount', $discountAmount);
        $request->session()->put('amount', $couponData->amount);

        return response()->json([
            'success' => true,
            'couponData' => $couponData,
            'amount' => $couponData->amount,
            'discountAmount' => $discountAmount,
        ]);
    } */

    /* public function couponcodes(Request $request)
    {
        try {
            $getUser = \App\Helpers\Helper::getUser();
            $couponCode = $request->input('couponCode');
            $subtotal = intval($request->input('subtotal'));

            if (!$getUser) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please log in.',
                ], 401);
            }

            // Already used coupon
            $ticketCheck = orders_confirm::where('user_id', $getUser->id)
                ->where('coupon_code', $couponCode)
                ->first();

            if ($ticketCheck) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already used this coupon.',
                ]);
            }

            if (empty($couponCode) || $subtotal <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid coupon code or subtotal.',
                ]);
            }

            $couponData = Coupans::where('coupans_code', $couponCode)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->where('amount', '<=', $subtotal)
                ->where('status', 1)
                ->first();

            if (!$couponData) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or expired coupon code.',
                ]);
            }

            $discountAmount = $couponData->type === 'percentage'
                ? round(($subtotal / 100) * $couponData->amount)
                : min($couponData->amount, $subtotal);

            // Store to session
            $request->session()->put('couponData', $couponData);
            $request->session()->put('couponType', $couponData->type);
            $request->session()->put('couponAmount', $discountAmount);
            $request->session()->put('amount', $couponData->amount);

            return response()->json([
                'success' => true,
                'couponData' => $couponData,
                'amount' => $couponData->amount,
                'discountAmount' => $discountAmount,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    } */


    public function showLoginForm(Request $request)
    {

        $couponlogin = 'couponlogins';
        session()->put('couponlogin', $couponlogin);

        return view('login');
    }
}
