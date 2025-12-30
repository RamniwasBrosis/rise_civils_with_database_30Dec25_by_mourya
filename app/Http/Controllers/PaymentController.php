<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Payment;
use App\Models\Tickets;
use App\Models\orders_confirm;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\TicketBooking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    private $razorpayId;
    private $razorpayKey;
    public function __construct()
    {
        $this->razorpayId = env('RAZORPAY_KEY');
        // $this->razorpaySecret = env('RAZORPAY_SECRET');
    }


    public function index()
    {
        return view('payment-form');
    }

    public function paymentSuccess($id, Request $request)
    {
        Session::forget('date');
        Session::forget('time');
        Session::forget('ticket_qty');
        Session::forget('couponData');
        Session::forget('couponType');
        Session::forget('couponAmount');
        Session::forget('amount');

        $input = $request->all();

        $getUser = \App\Helpers\Helper::getUser();

        if (!$getUser) {
            Session::flash('error', 'User not found. Please login again.');
            return redirect()->route('front.login');
        }

        $input = $request->all();

        if (empty($input['razorpay_payment_id'])) {
            Session::flash('error', 'Payment ID is missing. Please try again.');
            return redirect()->route('front.tickets');
        }

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        $response = $payment->capture(['amount' => $payment['amount']]);

        Payment::create([
            'user_id' => $getUser->id,
            'transaction_id' => $response->id,
            'amount' => $response->amount / 100,
            'order_id' => $id,
            'payment_status' => 'Paid',
            'created_at' => now(),
        ]);

        $orders_confirm = orders_confirm::find($id);
        if ($orders_confirm) {
            $orders_confirm->status = 'Paid';
            $orders_confirm->role = 'User';
            $orders_confirm->ticket_type = 'Online';
            $orders_confirm->payment_type = 'Confirmed';
            
            $orders_confirm->save();
        }

        // ticket pdf
        $ticketQty = is_string($orders_confirm->ticketBooking->ticket_qty)
            ? json_decode($orders_confirm->ticketBooking->ticket_qty, true)
            : $orders_confirm->ticketBooking->ticket_qty;

        $tickets = Tickets::whereIn('id', array_keys($ticketQty))->get()->filter(function ($ticket) use ($ticketQty) {
            return (int) ($ticketQty[$ticket->id] ?? 0) > 0;
        })->map(function ($ticket) use ($ticketQty) {
            $ticket->quantity = (int) ($ticketQty[$ticket->id] ?? 0);
            return $ticket;
        });

        $result = [];
        $payPrice = 0;
        $totalQty = 0;
        foreach ($tickets as $ticket) {
            // $quantity = $ticketQty[$ticket->id] ?? 0;
            $quantity = (int) ($ticketQty[$ticket->id] ?? 0);
            $totalPrice = $ticket->total_price * $quantity;

            $payPrice += $totalPrice;
            $totalQty += $quantity;
            $result[] = [
                'ticket_id' => $ticket->id,
                'ticket_price' => $ticket->price,
                'ticket_name' => $ticket->name,
                'ticket_cgst' => $ticket->c_gst,
                'ticket_sgst' => $ticket->s_gst,
                'ticket_total_price' => $ticket->total_price,
                'quantity' => $quantity,
                'total_price' => $totalPrice,
            ];
        }
        $total_amount = $orders_confirm->total_amount;
        $pdf = Pdf::loadView('tickets_pdf', [
            'ticket_no' => $orders_confirm->ticket_no,
            'orders_confirm' => $orders_confirm,
            'getUser' => $getUser,
            'payPrice' => $payPrice,
            'totalQty' => $totalQty,
            'coupans_discount' => $coupans_discount ?? null,
            'total_amount' => $total_amount ?? null,
            'result' => $result,
        ]);

        $pdfPath = 'tickets/ticket_' . $orders_confirm->ticket_no . '.pdf';
        Storage::disk('public')->put($pdfPath, $pdf->output());

        $date = \Carbon\Carbon::parse($orders_confirm->ticketBooking->date)->format('d-M-Y');
        // $time = $orders_confirm->ticketBooking->time;
        $time = '8:00 AM To 8:00 PM';
        $ticketNo = $orders_confirm->ticket_no;
        $userMobile  = $getUser->nubhar; // User number

        $publicPdfUrl = asset('storage/' . $pdfPath);

        // send ticket pdf on whatsApp 
        $adminMobile1 = '8279077562'; //8279077556
        $adminMobile2 = '8279077560'; //8279077556
        
        Helper::sendTicketOnWhatsApp($adminMobile1, $publicPdfUrl, $ticketNo, $date, $time);
        
        Helper::sendTicketOnWhatsApp($adminMobile2, $publicPdfUrl, $ticketNo, $date, $time);
        
        //send ticket to user
        Helper::sendTicketOnWhatsApp($userMobile, $publicPdfUrl, $ticketNo, $date, $time);

        // send conformation to the sms
        Helper::sendConfirmationSMS($getUser->nubhar, $ticketNo, $date, $time);

        return redirect()->route('fornt.generate_ticket', $id)->with('success', 'Payment got successful!');
    }

    // public function paymentSuccess($id, Request $request)
    // {
    //     // Clear session except ticket_booking_id
    //     $ticketBookingId = Session::get('ticket_booking_id');
    //     Session::forget([
    //         'date', 'time', 'ticket_qty', 'couponData',
    //         'couponType', 'couponAmount', 'amount', 'gst_amount'
    //     ]);
    
    //     $ticketGst_amount = Session::get('gst_amount');
    //     $input = $request->all();
    //     $getUser = \App\Helpers\Helper::getUser();
    
    //     if (!$getUser) {
    //         Session::flash('error', 'User not found. Please login again.');
    //         return redirect()->route('front.login');
    //     }
    
    //     if (empty($input['razorpay_payment_id'])) {
    //         Session::flash('error', 'Payment ID is missing. Please try again.');
    //         return redirect()->route('front.tickets');
    //     }
    
    //     try {
    //         $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    //         $payment = $api->payment->fetch($input['razorpay_payment_id']);
    
    //         // Check if payment status is "captured" (success)
    //         if ($payment->status !== 'captured') {
    //             // Payment not successful, do not insert anything
    //             Session::flash('error', 'Payment is not confirmed. Please try again.');
    //             return redirect()->route('front.tickets');
    //         }
    
    //         // Capture the payment
    //         $response = $payment->capture(['amount' => $payment['amount']]);
    
    //         // ✅ Only now insert into Payment table
    //         Payment::create([
    //             'user_id'        => $getUser->id,
    //             'transaction_id' => $response->id,
    //             'amount'         => $response->amount / 100,
    //             'order_id'       => $id,
    //             'payment_status' => 'Paid',
    //             'created_at'     => now(),
    //         ]);
    
    //         // ✅ Only now update orders_confirm
    //         $orders_confirm = orders_confirm::find($id);
    //         if ($orders_confirm) {
    //             $orders_confirm->status            = 'Paid';
    //             $orders_confirm->role              = 'User';
    //             $orders_confirm->ticket_type       = 'Online';
    //             $orders_confirm->payment_type      = 'Confirmed';
    //             $orders_confirm->ticket_booking_id = $ticketBookingId;
    //             $orders_confirm->gst_amount        = $ticketGst_amount;
    //             $orders_confirm->save();
    //         }
    
    //         // ✅ Continue with PDF generation & notifications
    //         $ticketQty = is_string($orders_confirm->ticketBooking->ticket_qty)
    //             ? json_decode($orders_confirm->ticketBooking->ticket_qty, true)
    //             : $orders_confirm->ticketBooking->ticket_qty;
    
    //         $tickets = Tickets::whereIn('id', array_keys($ticketQty))->get()->filter(function ($ticket) use ($ticketQty) {
    //             return (int) ($ticketQty[$ticket->id] ?? 0) > 0;
    //         })->map(function ($ticket) use ($ticketQty) {
    //             $ticket->quantity = (int) ($ticketQty[$ticket->id] ?? 0);
    //             return $ticket;
    //         });
    
    //         $result = [];
    //         $payPrice = 0;
    //         $totalQty = 0;
    //         foreach ($tickets as $ticket) {
    //             $quantity = (int) ($ticketQty[$ticket->id] ?? 0);
    //             $totalPrice = $ticket->total_price * $quantity;
    
    //             $payPrice += $totalPrice;
    //             $totalQty += $quantity;
    //             $result[] = [
    //                 'ticket_id' => $ticket->id,
    //                 'ticket_price' => $ticket->price,
    //                 'ticket_name' => $ticket->name,
    //                 'ticket_cgst' => $ticket->c_gst,
    //                 'ticket_sgst' => $ticket->s_gst,
    //                 'ticket_total_price' => $ticket->total_price,
    //                 'quantity' => $quantity,
    //                 'total_price' => $totalPrice,
    //             ];
    //         }
    
    //         $total_amount = $orders_confirm->total_amount;
    //         $pdf = Pdf::loadView('tickets_pdf', [
    //             'ticket_no'       => $orders_confirm->ticket_no,
    //             'orders_confirm'  => $orders_confirm,
    //             'getUser'         => $getUser,
    //             'payPrice'        => $payPrice,
    //             'totalQty'        => $totalQty,
    //             'coupans_discount'=> $coupans_discount ?? null,
    //             'total_amount'    => $total_amount ?? null,
    //             'result'          => $result,
    //         ]);
    
    //         $pdfPath = 'tickets/ticket_' . $orders_confirm->ticket_no . '.pdf';
    //         Storage::disk('public')->put($pdfPath, $pdf->output());
    
    //         $date = \Carbon\Carbon::parse($orders_confirm->ticketBooking->date)->format('d-M-Y');
    //         $time = $orders_confirm->ticketBooking->time;
    //         $ticketNo = $orders_confirm->ticket_no;
    //         $publicPdfUrl = asset('storage/' . $pdfPath);
    
    //         Helper::sendTicketOnWhatsApp($getUser->nubhar, $publicPdfUrl, $ticketNo, $date, $time);
    //         Helper::sendConfirmationSMS($getUser->nubhar, $orders_confirm->ticket_no, $date, $time);
    
    //         return redirect()->route('fornt.generate_ticket', $id)->with('success', 'Payment successful!');
            
    //     } catch (\Exception $e) {
    //         \Log::error('Payment failed: '.$e->getMessage());
    //         Session::flash('error', 'Payment failed. Please try again.');
    //         return redirect()->route('front.tickets');
    //     }
    // }



    public function generate_ticket($id)
    {

        $getUser = \App\Helpers\Helper::getUser();
        $orders_confirm = orders_confirm::where('id', $id)->where('status', 'Paid')->first();

        if (empty($orders_confirm)) {
            return redirect()->route('front.tickets');
        }

        if ($orders_confirm->coupon_code == NULL) {

            $ticket_no = $orders_confirm->ticket_no;
            $total_amount = $orders_confirm->total_amount;
            // $ticketQty = json_decode($orders_confirm->ticketQty, true);
            // $ticketQty = $orders_confirm->ticketBooking->ticket_qty;
            $ticketQty = is_string($orders_confirm->ticketBooking->ticket_qty)
                ? json_decode($orders_confirm->ticketBooking->ticket_qty, true)
                : $orders_confirm->ticketBooking->ticket_qty;
            if (!is_array($ticketQty)) {
                Session::flash('error', 'Invalid ticket quantity format.');
                return redirect()->back();
            }
            // $tickets = Tickets::whereIn('id', array_keys($ticketQty))->get();
            $tickets = Tickets::whereIn('id', array_keys($ticketQty))->get()->filter(function ($ticket) use ($ticketQty) {
                return (int) ($ticketQty[$ticket->id] ?? 0) > 0;
            })->map(function ($ticket) use ($ticketQty) {
                $ticket->quantity = (int) ($ticketQty[$ticket->id] ?? 0);
                return $ticket;
            });

            $result = [];
            $payPrice = 0;
            $totalQty = 0;

            foreach ($tickets as $ticket) {
                $quantity = $ticketQty[$ticket->id] ?? 0;
                $quantity = (int) ($ticketQty[$ticket->id] ?? 0);
                $totalPrice = $ticket->total_price * $quantity;

                $payPrice += $totalPrice;
                $totalQty += $quantity;
                $result[] = [
                    'ticket_id' => $ticket->id,
                    'ticket_price' => $ticket->price,
                    'ticket_name' => $ticket->name,
                    'ticket_cgst' => $ticket->c_gst,
                    'ticket_sgst' => $ticket->s_gst,
                    'ticket_total_price' => $ticket->total_price,
                    'quantity' => $quantity,
                    'total_price' => $payPrice,
                ];
            }

            return view('tickets_d', [
                'ticket_no' => $ticket_no,
                'result' => $result,
                'payPrice' => $total_amount,
                'totalQty' => $totalQty,
                'getUser' => $getUser,
                'orders_confirm' => $orders_confirm,
                'id' => $id,
            ]);
        } else {

            $ticket_no = $orders_confirm->ticket_no;
            $c_discount = $orders_confirm->coupans_discount;
            $total_amount = $orders_confirm->total_amount;
            $ticketQty = json_decode($orders_confirm->ticketQty, true);
            if (!is_array($ticketQty)) {
                Session::flash('error', 'Invalid ticket quantity format.');
                return redirect()->back();
            }
            $tickets = Tickets::whereIn('id', array_keys($ticketQty))->get();
            $result = [];
            $payPrice = 0;
            $totalQty = 0;

            foreach ($tickets as $ticket) {
                $quantity = $ticketQty[$ticket->id] ?? 0;
                $totalPrice = $ticket->total_price * $quantity;

                $payPrice += $totalPrice;
                $totalQty += $quantity;

                $result[] = [
                    'ticket_id' => $ticket->id,
                    'ticket_price' => $ticket->price,
                    'ticket_name' => $ticket->name,
                    'ticket_cgst' => $ticket->c_gst,
                    'ticket_sgst' => $ticket->s_gst,
                    'ticket_total_price' => $ticket->total_price,
                    'quantity' => $quantity,
                    'total_price' => $totalPrice,
                ];
            }

            return view('tickets_d', [
                'ticket_no' => $ticket_no,
                'result' => $result,
                'coupans_discount' => $c_discount,
                'payPrice' => $payPrice,
                'total_amount' => $total_amount,
                'totalQty' => $totalQty,
                'getUser' => $getUser,
                'orders_confirm' => $orders_confirm,
                'id' => $id,
            ]);
        }
    }

    public function paymentFailure(Request $request)
    {

        Session::forget('date');
        Session::forget('time');
        Session::forget('ticket_qty');

        Session::flash('error', 'Payment Failed. Please try again!');
        return redirect()->route('front.index');
    }
}
