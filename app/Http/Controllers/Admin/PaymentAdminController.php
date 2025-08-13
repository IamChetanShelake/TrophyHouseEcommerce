<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::query();

        // Filtering
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('payment_mode')) {
            $query->where('payment_mode', $request->payment_mode);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('transaction_id', 'like', "%{$search}%");
            });
        }

        $payments = $query->latest()->paginate(15);

        // Analytics
        $total_payments = Payment::count();
        $success_count = Payment::where('status', 'paid')->count();
        $failed_count = Payment::where('status', 'failed')->count();
        $pending_count = Payment::where('status', 'pending')->count();
        $total_amount = Payment::where('status', 'paid')->sum('amount');

        // Status distribution
        $status_distribution = Payment::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // Payment method distribution
        $payment_mode_distribution = Payment::where('status', 'paid')
            ->select('payment_mode', DB::raw('count(*) as total'))
            ->whereNotNull('payment_mode')
            ->groupBy('payment_mode')
            ->pluck('total', 'payment_mode');

        // Daily revenue for last 30 days
        $daily_revenue = Payment::where('status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as revenue'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Monthly statistics
        $monthly_stats = Payment::where('status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(amount) as revenue')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // Top customers
        $top_customers = Payment::where('status', 'paid')
            ->select('customer_name', 'customer_email', DB::raw('COUNT(*) as payment_count'), DB::raw('SUM(amount) as total_spent'))
            ->groupBy('customer_name', 'customer_email')
            ->orderBy('total_spent', 'desc')
            ->limit(10)
            ->get();

        // Recent failed payments
        $recent_failures = Payment::where('status', 'failed')
            ->latest()
            ->limit(5)
            ->get();

        // Average transaction value
        $avg_transaction_value = Payment::where('status', 'paid')->avg('amount');

        // Success rate
        $success_rate = $total_payments > 0 ? ($success_count / $total_payments) * 100 : 0;

        // Handle AJAX requests for real-time updates
        if ($request->ajax()) {
            return response()->json([
                'total_payments' => $total_payments,
                'success_count' => $success_count,
                'failed_count' => $failed_count,
                'pending_count' => $pending_count,
                'total_amount' => $total_amount,
                'success_rate' => round($success_rate, 2),
                'avg_transaction_value' => round($avg_transaction_value, 2)
            ]);
        }

        // Handle export requests
        if ($request->filled('export')) {
            return $this->exportPayments($request);
        }

        return view('admin.payments.index', compact(
            'payments', 'total_payments', 'success_count', 'failed_count', 'pending_count',
            'total_amount', 'status_distribution', 'payment_mode_distribution',
            'daily_revenue', 'monthly_stats', 'top_customers', 'recent_failures',
            'avg_transaction_value', 'success_rate'
        ));
    }

    public function show($order_id)
    {
        $payment = Payment::with(['paymentItems.product', 'paymentItems.variant'])
            ->where('order_id', $order_id)
            ->firstOrFail();

        return view('admin.payments.show', compact('payment'));
    }

    public function details($order_id)
    {
        $payment = Payment::with(['paymentItems.product', 'paymentItems.variant'])
            ->where('order_id', $order_id)
            ->firstOrFail();

        $html = view('admin.payments.details-modal', compact('payment'))->render();

        return response()->json(['html' => $html]);
    }

    public function invoice($order_id)
    {
        $payment = Payment::with(['paymentItems.product', 'paymentItems.variant'])
            ->where('order_id', $order_id)
            ->where('status', 'paid')
            ->firstOrFail();

        return view('admin.payments.invoice', compact('payment'));
    }

    private function exportPayments(Request $request)
    {
        $query = Payment::query();

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('payment_mode')) {
            $query->where('payment_mode', $request->payment_mode);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $payments = $query->latest()->get();

        $filename = 'payments_export_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($payments) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Order ID', 'Customer Name', 'Customer Email', 'Customer Phone',
                'Amount', 'Currency', 'Status', 'Payment Mode', 'Transaction ID',
                'Created At', 'Updated At'
            ]);

            // CSV data
            foreach ($payments as $payment) {
                fputcsv($file, [
                    $payment->order_id,
                    $payment->customer_name,
                    $payment->customer_email,
                    $payment->customer_phone,
                    $payment->amount,
                    $payment->currency,
                    $payment->status,
                    $payment->payment_mode,
                    $payment->transaction_id,
                    $payment->created_at,
                    $payment->updated_at,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function analytics()
    {
        // Advanced analytics endpoint
        $data = [
            'revenue_trend' => $this->getRevenueTrend(),
            'payment_method_performance' => $this->getPaymentMethodPerformance(),
            'hourly_distribution' => $this->getHourlyDistribution(),
            'failure_analysis' => $this->getFailureAnalysis(),
        ];

        return response()->json($data);
    }

    private function getRevenueTrend()
    {
        return Payment::where('status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as revenue'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getPaymentMethodPerformance()
    {
        return Payment::select(
                'payment_mode',
                DB::raw('COUNT(*) as total_attempts'),
                DB::raw('SUM(CASE WHEN status = "paid" THEN 1 ELSE 0 END) as successful'),
                DB::raw('SUM(CASE WHEN status = "paid" THEN amount ELSE 0 END) as revenue')
            )
            ->whereNotNull('payment_mode')
            ->groupBy('payment_mode')
            ->get();
    }

    private function getHourlyDistribution()
    {
        return Payment::select(
                DB::raw('HOUR(created_at) as hour'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();
    }

    private function getFailureAnalysis()
    {
        return Payment::where('status', 'failed')
            ->select('payment_mode', DB::raw('COUNT(*) as failures'))
            ->whereNotNull('payment_mode')
            ->groupBy('payment_mode')
            ->orderBy('failures', 'desc')
            ->get();
    }
}
