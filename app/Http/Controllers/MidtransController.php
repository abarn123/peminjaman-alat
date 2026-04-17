<?php
namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed !== $request->signature_key) {
            return response('Invalid signature', 403);
        }

        $loan = Loan::where('midtrans_order_id', $request->order_id)->first();
        if ($loan) {
            $loan->update([
                'midtrans_status' => $request->transaction_status,
                'midtrans_response' => json_encode($request->all()),
            ]);

            // Jika settlement, hapus bukti manual jika ada
            if ($request->transaction_status === 'settlement') {
                if ($loan->payment_proof_image_path) {
                    \Storage::disk('public')->delete($loan->payment_proof_image_path);
                    $loan->update(['payment_proof_image_path' => null]);
                }
            }
        }

        return response('OK', 200);
    }

    public function clientNotify(Request $request)
    {
        $data = $request->only(['order_id', 'transaction_status', 'gross_amount', 'fraud_status', 'status_code', 'signature_key']);

        $loan = Loan::where('midtrans_order_id', $data['order_id'] ?? null)->first();
        if (! $loan) {
            return response()->json(['error' => 'Loan not found'], 404);
        }

        $loan->update([
            'midtrans_status' => $data['transaction_status'] ?? 'pending',
            'midtrans_response' => json_encode($request->all()),
        ]);

        if (($data['transaction_status'] ?? null) === 'settlement' && $loan->payment_proof_image_path) {
            \Storage::disk('public')->delete($loan->payment_proof_image_path);
            $loan->update(['payment_proof_image_path' => null]);
        }

        return response()->json(['status' => 'updated']);
    }

    public function testCallback($orderId, $status)
    {
        $loan = Loan::where('midtrans_order_id', $orderId)->first();
        if ($loan) {
            $loan->update([
                'midtrans_status' => $status,
                'midtrans_response' => json_encode(['test' => true, 'status' => $status]),
            ]);
            return 'Status updated to ' . $status;
        }
        return 'Loan not found';
    }
}