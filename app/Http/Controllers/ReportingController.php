<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use TCPDF;
use App\Models\MaintenanceSchedule;

class ReportingController extends Controller
{
    public function index()
    {
        $revenueBreakdown = DB::table('billing_invoices')
            ->select('equipment_type', DB::raw('SUM(total_amount) as total'))
            ->where('status', 'paid')
            ->groupBy('equipment_type')
            ->get();

        $invoiceDetails = DB::table('billing_invoices')
            ->select('id', 'client_name', 'equipment_type', 'equipment_id', 'hours_used', 'hourly_rate', 'total_amount', 'created_at')
            ->where('status', 'paid')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $totalRevenue = DB::table('billing_invoices')->where('status', 'paid')->sum('total_amount');
        $collectionRate = DB::table('billing_invoices')->where('status', 'paid')->count();
        $totalInvoices = DB::table('billing_invoices')->count();
        $collectionRatePercent = $totalInvoices > 0 ? round(($collectionRate / $totalInvoices) * 100) : 0;

        $completedThisMonth = MaintenanceSchedule::where('status', 'completed')
            ->whereMonth('completed_at', now()->month)
            ->whereYear('completed_at', now()->year)
            ->count();

        $pendingCount = MaintenanceSchedule::where('status', 'pending')->count();

        $overdueCount = MaintenanceSchedule::where('status', 'pending')
            ->where('scheduled_date', '<', now())
            ->count();

        $highRiskCount = MaintenanceSchedule::where('ai_risk_score', '>=', 0.8)
            ->where('status', 'pending')
            ->count();

        $mediumRiskCount = MaintenanceSchedule::whereBetween('ai_risk_score', [0.6, 0.79])
            ->where('status', 'pending')
            ->count();

        $lowRiskCount = MaintenanceSchedule::where('ai_risk_score', '<', 0.6)
            ->where('status', 'pending')
            ->count();

        $recentMaintenance = MaintenanceSchedule::with('maintenanceType')
            ->orderBy('scheduled_date', 'desc')
            ->take(10)
            ->get();

        $aiInsights = [
            'high_risk_equipment' => $highRiskCount,
            'medium_risk_equipment' => $mediumRiskCount,
            'low_risk_equipment' => $lowRiskCount,
            'total_at_risk' => $highRiskCount + $mediumRiskCount,
            'risk_percentage' => ($highRiskCount + $mediumRiskCount + $lowRiskCount) > 0 ?
                round((($highRiskCount + $mediumRiskCount) / ($highRiskCount + $mediumRiskCount + $lowRiskCount)) * 100, 1) : 0,
            'recommendation' => $highRiskCount > 5 ?
                "CRITICAL: Immediate maintenance review required for high-risk equipment." :
                ($highRiskCount > 2 ?
                    "WARNING: Schedule preventive maintenance for high-risk equipment." :
                    ($highRiskCount > 0 ?
                        "ATTENTION: Monitor high-risk equipment closely." :
                        "GOOD: Equipment maintenance status is optimal."))
        ];

        $upcomingFailures = MaintenanceSchedule::where('ai_predicted_failure_date', '>=', now())
            ->where('ai_predicted_failure_date', '<=', now()->addDays(30))
            ->where('status', 'pending')
            ->count();

        $aiPredictions = [
            'upcoming_failures_30days' => $upcomingFailures,
            'maintenance_cost_savings' => $upcomingFailures * 50000,
            'downtime_prevention' => $upcomingFailures * 8
        ];

        $revenueData = [];
        for ($i = 0; $i < 6; $i++) {
            $month = now()->subMonths(5 - $i)->month;
            $revenue = DB::table('billing_invoices')
                ->where('status', 'paid')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', now()->year)
                ->sum('total_amount');
            $revenueData[] = (float) $revenue;
        }

        $maintenanceData = [];
        for ($i = 0; $i < 6; $i++) {
            $month = now()->subMonths(5 - $i)->month;
            $completed = MaintenanceSchedule::where('status', 'completed')
                ->whereMonth('completed_at', $month)
                ->whereYear('completed_at', now()->year)
                ->count();
            $maintenanceData[] = (int) $completed;
        }

        $paymentMethods = [
            ['name' => 'Bank Transfer', 'percentage' => 45, 'color' => 'blue'],
            ['name' => 'Cash', 'percentage' => 25, 'color' => 'green'],
            ['name' => 'Credit Card', 'percentage' => 20, 'color' => 'yellow'],
            ['name' => 'Online Payment', 'percentage' => 10, 'color' => 'red']
        ];

        $predictiveData = [];
        for ($i = 0; $i < 4; $i++) {
            $startOfWeek = now()->addWeeks($i)->startOfWeek();
            $endOfWeek = now()->addWeeks($i)->endOfWeek();
            $failures = MaintenanceSchedule::where('ai_predicted_failure_date', '>=', $startOfWeek)
                ->where('ai_predicted_failure_date', '<=', $endOfWeek)
                ->where('status', 'pending')
                ->count();
            $predictiveData[] = (int) $failures;
        }

        return view('Reporting and Analytics.financial-report', compact(
            'revenueBreakdown', 'invoiceDetails', 'totalRevenue', 'collectionRatePercent',
            'completedThisMonth', 'pendingCount', 'overdueCount', 'highRiskCount',
            'mediumRiskCount', 'lowRiskCount', 'recentMaintenance', 'aiInsights',
            'aiPredictions', 'revenueData', 'maintenanceData', 'paymentMethods', 'predictiveData'
        ));
    }

    public function exportExcel()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="financial-report.csv"',
        ];

        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['Invoice ID', 'Client Name', 'Equipment Type', 'Equipment ID', 'Hours Used', 'Hourly Rate', 'Total Amount', 'Date Created']);

        $invoices = DB::table('billing_invoices')
            ->select('id', 'client_name', 'equipment_type', 'equipment_id', 'hours_used', 'hourly_rate', 'total_amount', 'created_at')
            ->where('status', 'paid')
            ->get();

        foreach ($invoices as $invoice) {
            fputcsv($handle, [
                'INV-' . str_pad($invoice->id, 3, '0', STR_PAD_LEFT),
                $invoice->client_name,
                ucfirst(str_replace('_', ' ', $invoice->equipment_type)),
                $invoice->equipment_id,
                $invoice->hours_used,
                $invoice->hourly_rate,
                $invoice->total_amount,
                \Carbon\Carbon::parse($invoice->created_at)->format('M d, Y')
            ]);
        }

        fclose($handle);
        return response()->streamDownload(function () use ($handle) {}, 'financial-report.csv', $headers);
    }

    public function exportPdf()
    {
        $invoiceDetails = DB::table('billing_invoices')
            ->select('id', 'client_name', 'equipment_type', 'equipment_id', 'hours_used', 'hourly_rate', 'total_amount', 'created_at')
            ->where('status', 'paid')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue = DB::table('billing_invoices')->where('status', 'paid')->sum('total_amount');
        $collectionRate = DB::table('billing_invoices')->where('status', 'paid')->count();
        $totalInvoices = DB::table('billing_invoices')->count();
        $collectionRatePercent = $totalInvoices > 0 ? round(($collectionRate / $totalInvoices) * 100) : 0;

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator('CraneCali Management System');
        $pdf->SetAuthor('CraneCali Admin');
        $pdf->SetTitle('Financial Intelligence Report');
        $pdf->SetSubject('Confidential Financial Data');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(15, 15, 15);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 10);

        $html = $this->buildFinancialPdfHtml($invoiceDetails, $totalRevenue, $collectionRatePercent);

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->SetProtection(['print', 'copy'], 'document', 'admin');
        return response($pdf->Output('financial-report.pdf', 'S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="financial-report.pdf"');
    }

    // ─── Shared HTML builder for Financial PDF ───────────────────────────────
    private function buildFinancialPdfHtml($invoiceDetails, $totalRevenue, $collectionRatePercent)
    {
        $generatedAt = date('F d, Y  H:i:s');
        $rows = '';
        $rowNum = 0;
        foreach ($invoiceDetails as $invoice) {
            $bg = $rowNum % 2 === 0 ? '#ffffff' : '#f8fafc';
            $rows .= '
            <tr style="background:' . $bg . ';">
                <td style="padding:7px 10px;border-bottom:1px solid #e2e8f0;font-weight:700;color:#1e40af;">INV-' . str_pad($invoice->id, 3, '0', STR_PAD_LEFT) . '</td>
                <td style="padding:7px 10px;border-bottom:1px solid #e2e8f0;font-weight:600;">' . htmlspecialchars($invoice->client_name) . '</td>
                <td style="padding:7px 10px;border-bottom:1px solid #e2e8f0;">' . ucfirst(str_replace('_', ' ', $invoice->equipment_type)) . '</td>
                <td style="padding:7px 10px;border-bottom:1px solid #e2e8f0;text-align:center;">' . $invoice->hours_used . '</td>
                <td style="padding:7px 10px;border-bottom:1px solid #e2e8f0;text-align:right;">PHP ' . number_format($invoice->hourly_rate, 2) . '</td>
                <td style="padding:7px 10px;border-bottom:1px solid #e2e8f0;text-align:right;font-weight:700;color:#059669;">PHP ' . number_format($invoice->total_amount, 2) . '</td>
                <td style="padding:7px 10px;border-bottom:1px solid #e2e8f0;text-align:center;">' . \Carbon\Carbon::parse($invoice->created_at)->format('M d, Y') . '</td>
            </tr>';
            $rowNum++;
        }

        return '
        <style>
            * { font-family: helvetica; }
            body { margin: 0; padding: 0; color: #1e293b; }
        </style>

        <!-- HEADER BANNER -->
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:0;">
            <tr>
                <td style="background:#1e3a5f;padding:22px 20px;border-radius:6px 6px 0 0;">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <div style="font-size:9px;color:#93c5fd;font-weight:700;letter-spacing:2px;text-transform:uppercase;margin-bottom:4px;">CRANECALI MANAGEMENT SYSTEM</div>
                                <div style="font-size:20px;font-weight:700;color:#ffffff;margin-bottom:3px;">Financial Intelligence Report</div>
                                <div style="font-size:9px;color:#bfdbfe;">Generated on: ' . $generatedAt . '</div>
                            </td>
                            <td style="text-align:right;vertical-align:top;">
                                <div style="background:#1e40af;border:1px solid #3b82f6;border-radius:5px;padding:8px 14px;display:inline-block;">
                                    <div style="font-size:8px;color:#93c5fd;margin-bottom:2px;">DOCUMENT STATUS</div>
                                    <div style="font-size:11px;font-weight:700;color:#ffffff;">CONFIDENTIAL</div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="background:#1e40af;padding:5px 20px;border-radius:0 0 6px 6px;">
                    <div style="font-size:8px;color:#bfdbfe;">Revenue Analytics from Payment Management System &nbsp;|&nbsp; Password Protected &nbsp;|&nbsp; Authorized Personnel Only</div>
                </td>
            </tr>
        </table>

        <br/>

        <!-- SUMMARY STATS ROW -->
        <table width="100%" cellpadding="0" cellspacing="6" style="margin-bottom:16px;">
            <tr>
                <td width="33%" style="background:#f0fdf4;border:1px solid #bbf7d0;border-left:4px solid #10b981;border-radius:5px;padding:12px 14px;">
                    <div style="font-size:8px;font-weight:700;color:#15803d;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Total Revenue</div>
                    <div style="font-size:16px;font-weight:700;color:#065f46;">PHP ' . number_format($totalRevenue, 2) . '</div>
                    <div style="font-size:8px;color:#16a34a;margin-top:2px;">From paid invoices</div>
                </td>
                <td width="4%"></td>
                <td width="33%" style="background:#eff6ff;border:1px solid #bfdbfe;border-left:4px solid #3b82f6;border-radius:5px;padding:12px 14px;">
                    <div style="font-size:8px;font-weight:700;color:#1e40af;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Collection Rate</div>
                    <div style="font-size:16px;font-weight:700;color:#1e3a5f;">' . $collectionRatePercent . '%</div>
                    <div style="font-size:8px;color:#3b82f6;margin-top:2px;">Invoice completion rate</div>
                </td>
                <td width="4%"></td>
                <td width="26%" style="background:#f8fafc;border:1px solid #e2e8f0;border-left:4px solid #64748b;border-radius:5px;padding:12px 14px;">
                    <div style="font-size:8px;font-weight:700;color:#475569;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Active Clients</div>
                    <div style="font-size:16px;font-weight:700;color:#0f172a;">' . $invoiceDetails->count() . '</div>
                    <div style="font-size:8px;color:#64748b;margin-top:2px;">Current period</div>
                </td>
            </tr>
        </table>

        <!-- SECTION HEADER: TRANSACTION DETAILS -->
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:8px;">
            <tr>
                <td style="background:#1e3a5f;padding:9px 14px;border-radius:5px 5px 0 0;">
                    <div style="font-size:10px;font-weight:700;color:#ffffff;">Transaction Details</div>
                    <div style="font-size:8px;color:#93c5fd;margin-top:1px;">All paid invoices for the current period</div>
                </td>
            </tr>
        </table>

        <!-- TRANSACTION TABLE -->
        <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e2e8f0;border-radius:0 0 5px 5px;margin-bottom:16px;">
            <thead>
                <tr style="background:#f1f5f9;">
                    <th style="padding:8px 10px;text-align:left;font-size:8px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #e2e8f0;">Invoice</th>
                    <th style="padding:8px 10px;text-align:left;font-size:8px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #e2e8f0;">Client Name</th>
                    <th style="padding:8px 10px;text-align:left;font-size:8px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #e2e8f0;">Equipment</th>
                    <th style="padding:8px 10px;text-align:center;font-size:8px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #e2e8f0;">Hours</th>
                    <th style="padding:8px 10px;text-align:right;font-size:8px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #e2e8f0;">Rate</th>
                    <th style="padding:8px 10px;text-align:right;font-size:8px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #e2e8f0;">Total Amount</th>
                    <th style="padding:8px 10px;text-align:center;font-size:8px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #e2e8f0;">Date</th>
                </tr>
            </thead>
            <tbody>
                ' . $rows . '
            </tbody>
        </table>

        <!-- FOOTER NOTE -->
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td style="background:#fefce8;border:1px solid #fde68a;border-left:4px solid #f59e0b;border-radius:5px;padding:10px 14px;">
                    <div style="font-size:8px;font-weight:700;color:#92400e;margin-bottom:2px;">CONFIDENTIALITY NOTICE</div>
                    <div style="font-size:8px;color:#78350f;">This document contains privileged and confidential financial information belonging to CraneCali Management System. Any unauthorized review, use, disclosure, or distribution is strictly prohibited. If you received this in error, please notify the sender immediately.</div>
                </td>
            </tr>
        </table>

        <br/>
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td style="border-top:1px solid #e2e8f0;padding-top:8px;">
                    <div style="font-size:8px;color:#94a3b8;">CraneCali Management System &nbsp;|&nbsp; Reporting & Analytics Hub &nbsp;|&nbsp; ' . date('Y') . '</div>
                </td>
                <td style="text-align:right;border-top:1px solid #e2e8f0;padding-top:8px;">
                    <div style="font-size:8px;color:#94a3b8;">Page 1 of 1 &nbsp;|&nbsp; Auto-generated report</div>
                </td>
            </tr>
        </table>';
    }

    // ─── Shared HTML builder for Maintenance PDF ─────────────────────────────
    private function buildMaintenancePdfHtml()
    {
        $generatedAt = date('F d, Y  H:i:s');

        $completedThisMonth = MaintenanceSchedule::where('status', 'completed')
            ->whereMonth('completed_at', now()->month)
            ->whereYear('completed_at', now()->year)
            ->count();

        $pendingCount = MaintenanceSchedule::where('status', 'pending')->count();

        $overdueCount = MaintenanceSchedule::where('status', 'pending')
            ->where('scheduled_date', '<', now())
            ->count();

        $highRisk = MaintenanceSchedule::where('ai_risk_score', '>=', 0.8)->where('status', 'pending')->count();
        $mediumRisk = MaintenanceSchedule::whereBetween('ai_risk_score', [0.6, 0.79])->where('status', 'pending')->count();
        $lowRisk = MaintenanceSchedule::where('ai_risk_score', '<', 0.6)->where('status', 'pending')->count();

        $recentMaintenance = MaintenanceSchedule::with('maintenanceType')
            ->orderBy('scheduled_date', 'desc')
            ->take(15)
            ->get();

        $rows = '';
        $rowNum = 0;
        foreach ($recentMaintenance as $schedule) {
            $bg = $rowNum % 2 === 0 ? '#ffffff' : '#f8fafc';
            if ($schedule->status === 'completed') {
                $statusBg = '#dcfce7'; $statusColor = '#15803d'; $statusLabel = 'Completed';
            } elseif ($schedule->status === 'pending' && \Carbon\Carbon::parse($schedule->scheduled_date)->isPast()) {
                $statusBg = '#fee2e2'; $statusColor = '#dc2626'; $statusLabel = 'Overdue';
            } else {
                $statusBg = '#fef3c7'; $statusColor = '#b45309'; $statusLabel = 'Pending';
            }
            $risk = $schedule->ai_risk_score > 0 ? number_format($schedule->ai_risk_score * 100, 0) . '%' : 'N/A';
            if ($schedule->ai_risk_score >= 0.8) { $riskColor = '#dc2626'; }
            elseif ($schedule->ai_risk_score >= 0.6) { $riskColor = '#d97706'; }
            else { $riskColor = '#15803d'; }

            $rows .= '
            <tr style="background:' . $bg . ';">
                <td style="padding:7px 10px;border-bottom:1px solid #e2e8f0;font-weight:600;">' . htmlspecialchars($schedule->equipment_name ?? 'N/A') . '</td>
                <td style="padding:7px 10px;border-bottom:1px solid #e2e8f0;">' . htmlspecialchars($schedule->maintenanceType->name ?? 'N/A') . '</td>
                <td style="padding:7px 10px;border-bottom:1px solid #e2e8f0;text-align:center;">' . \Carbon\Carbon::parse($schedule->scheduled_date)->format('M d, Y') . '</td>
                <td style="padding:7px 10px;border-bottom:1px solid #e2e8f0;text-align:center;">
                    <span style="background:' . $statusBg . ';color:' . $statusColor . ';padding:2px 8px;border-radius:10px;font-size:8px;font-weight:700;">' . $statusLabel . '</span>
                </td>
                <td style="padding:7px 10px;border-bottom:1px solid #e2e8f0;text-align:center;font-weight:700;color:' . $riskColor . ';">' . $risk . '</td>
            </tr>';
            $rowNum++;
        }

        return '
        <style>* { font-family: helvetica; }</style>

        <!-- HEADER -->
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:0;">
            <tr>
                <td style="background:#78350f;padding:22px 20px;border-radius:6px 6px 0 0;">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <div style="font-size:9px;color:#fde68a;font-weight:700;letter-spacing:2px;text-transform:uppercase;margin-bottom:4px;">CRANECALI MANAGEMENT SYSTEM</div>
                                <div style="font-size:20px;font-weight:700;color:#ffffff;margin-bottom:3px;">Maintenance Compliance Report</div>
                                <div style="font-size:9px;color:#fde68a;">Generated on: ' . $generatedAt . '</div>
                            </td>
                            <td style="text-align:right;vertical-align:top;">
                                <div style="background:#92400e;border:1px solid #d97706;border-radius:5px;padding:8px 14px;display:inline-block;">
                                    <div style="font-size:8px;color:#fde68a;margin-bottom:2px;">DOCUMENT STATUS</div>
                                    <div style="font-size:11px;font-weight:700;color:#ffffff;">CONFIDENTIAL</div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="background:#92400e;padding:5px 20px;border-radius:0 0 6px 6px;">
                    <div style="font-size:8px;color:#fde68a;">Equipment Maintenance Status from Maintenance Scheduling System &nbsp;|&nbsp; AI-Powered Risk Analysis</div>
                </td>
            </tr>
        </table>

        <br/>

        <!-- STATS ROW -->
        <table width="100%" cellpadding="0" cellspacing="4" style="margin-bottom:16px;">
            <tr>
                <td width="24%" style="background:#f0fdf4;border:1px solid #bbf7d0;border-left:4px solid #10b981;border-radius:5px;padding:10px 12px;">
                    <div style="font-size:8px;font-weight:700;color:#15803d;text-transform:uppercase;letter-spacing:1px;margin-bottom:3px;">Completed</div>
                    <div style="font-size:18px;font-weight:700;color:#065f46;">' . $completedThisMonth . '</div>
                    <div style="font-size:7px;color:#16a34a;">This month</div>
                </td>
                <td width="2%"></td>
                <td width="24%" style="background:#fef3c7;border:1px solid #fde68a;border-left:4px solid #f59e0b;border-radius:5px;padding:10px 12px;">
                    <div style="font-size:8px;font-weight:700;color:#b45309;text-transform:uppercase;letter-spacing:1px;margin-bottom:3px;">Pending</div>
                    <div style="font-size:18px;font-weight:700;color:#92400e;">' . $pendingCount . '</div>
                    <div style="font-size:7px;color:#d97706;">Awaiting service</div>
                </td>
                <td width="2%"></td>
                <td width="24%" style="background:#fff1f2;border:1px solid #fecaca;border-left:4px solid #ef4444;border-radius:5px;padding:10px 12px;">
                    <div style="font-size:8px;font-weight:700;color:#b91c1c;text-transform:uppercase;letter-spacing:1px;margin-bottom:3px;">Overdue</div>
                    <div style="font-size:18px;font-weight:700;color:#dc2626;">' . $overdueCount . '</div>
                    <div style="font-size:7px;color:#ef4444;">Past schedule</div>
                </td>
                <td width="2%"></td>
                <td width="24%" style="background:#fff1f2;border:1px solid #fecaca;border-left:4px solid #dc2626;border-radius:5px;padding:10px 12px;">
                    <div style="font-size:8px;font-weight:700;color:#b91c1c;text-transform:uppercase;letter-spacing:1px;margin-bottom:3px;">High Risk</div>
                    <div style="font-size:18px;font-weight:700;color:#dc2626;">' . $highRisk . '</div>
                    <div style="font-size:7px;color:#ef4444;">AI score >= 80%</div>
                </td>
            </tr>
        </table>

        <!-- TABLE HEADER -->
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:0;">
            <tr>
                <td style="background:#78350f;padding:9px 14px;border-radius:5px 5px 0 0;">
                    <div style="font-size:10px;font-weight:700;color:#ffffff;">Recent Maintenance Activity</div>
                    <div style="font-size:8px;color:#fde68a;margin-top:1px;">Latest 15 maintenance schedules with AI risk scoring</div>
                </td>
            </tr>
        </table>

        <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e2e8f0;border-radius:0 0 5px 5px;margin-bottom:16px;">
            <thead>
                <tr style="background:#f1f5f9;">
                    <th style="padding:8px 10px;text-align:left;font-size:8px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #e2e8f0;">Equipment</th>
                    <th style="padding:8px 10px;text-align:left;font-size:8px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #e2e8f0;">Type</th>
                    <th style="padding:8px 10px;text-align:center;font-size:8px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #e2e8f0;">Scheduled</th>
                    <th style="padding:8px 10px;text-align:center;font-size:8px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #e2e8f0;">Status</th>
                    <th style="padding:8px 10px;text-align:center;font-size:8px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #e2e8f0;">AI Risk</th>
                </tr>
            </thead>
            <tbody>' . $rows . '</tbody>
        </table>

        <!-- CONFIDENTIALITY FOOTER -->
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td style="background:#fefce8;border:1px solid #fde68a;border-left:4px solid #f59e0b;border-radius:5px;padding:10px 14px;">
                    <div style="font-size:8px;font-weight:700;color:#92400e;margin-bottom:2px;">CONFIDENTIALITY NOTICE</div>
                    <div style="font-size:8px;color:#78350f;">This document contains privileged and confidential maintenance and compliance information. Unauthorized use or distribution is strictly prohibited.</div>
                </td>
            </tr>
        </table>
        <br/>
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td style="border-top:1px solid #e2e8f0;padding-top:8px;">
                    <div style="font-size:8px;color:#94a3b8;">CraneCali Management System &nbsp;|&nbsp; Maintenance Compliance Report &nbsp;|&nbsp; ' . date('Y') . '</div>
                </td>
                <td style="text-align:right;border-top:1px solid #e2e8f0;padding-top:8px;">
                    <div style="font-size:8px;color:#94a3b8;">Page 1 of 1 &nbsp;|&nbsp; Auto-generated report</div>
                </td>
            </tr>
        </table>';
    }

    // ─── generateReportPdf — used by forwardDocument ──────────────────────────
    private function generateReportPdf($documentType)
    {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator('CraneCali Management System');
        $pdf->SetAuthor('CraneCali Admin');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetFont('helvetica', '', 9);

        if ($documentType === 'Financial Intelligence Report') {
            $invoiceDetails = DB::table('billing_invoices')
                ->select('id', 'client_name', 'equipment_type', 'equipment_id', 'hours_used', 'hourly_rate', 'total_amount', 'created_at')
                ->where('status', 'paid')
                ->orderBy('created_at', 'desc')
                ->get();
            $totalRevenue = DB::table('billing_invoices')->where('status', 'paid')->sum('total_amount');
            $collectionRate = DB::table('billing_invoices')->where('status', 'paid')->count();
            $totalInvoices = DB::table('billing_invoices')->count();
            $collectionRatePercent = $totalInvoices > 0 ? round(($collectionRate / $totalInvoices) * 100) : 0;

            $pdf->SetTitle('Financial Intelligence Report');
            $pdf->AddPage();
            $pdf->writeHTML($this->buildFinancialPdfHtml($invoiceDetails, $totalRevenue, $collectionRatePercent), true, false, true, false, '');

        } elseif ($documentType === 'Maintenance Compliance Report') {
            $pdf->SetTitle('Maintenance Compliance Report');
            $pdf->AddPage();
            $pdf->writeHTML($this->buildMaintenancePdfHtml(), true, false, true, false, '');

        } elseif ($documentType === 'Regulatory Compliance Report') {
            $pdf->SetTitle('Regulatory Compliance Report');
            $pdf->AddPage();
            $pdf->writeHTML($this->buildRegulatoryPdfHtml(), true, false, true, false, '');

        } else {
            // Project Status Update
            $pdf->SetTitle('Project Status Update');
            $pdf->AddPage();
            $pdf->writeHTML($this->buildProjectPdfHtml(), true, false, true, false, '');
        }

        $pdf->SetProtection(['print', 'copy'], 'document', 'admin');
        return $pdf->Output(str_replace(' ', '-', strtolower($documentType)) . '.pdf', 'S');
    }

    // ─── Regulatory Compliance PDF ────────────────────────────────────────────
    private function buildRegulatoryPdfHtml()
    {
        $generatedAt = date('F d, Y  H:i:s');
        $permits = DB::table('contracts')
            ->where('contract_type', 'like', '%permit%')
            ->orWhere('contract_type', 'like', '%compliance%')
            ->select('company_name', 'contract_type', 'start_date', 'end_date', 'status')
            ->limit(20)
            ->get();

        $rows = '';
        $rowNum = 0;
        foreach ($permits as $permit) {
            $bg = $rowNum % 2 === 0 ? '#ffffff' : '#f8fafc';
            if ($permit->status === 'active') { $sBg = '#dcfce7'; $sC = '#15803d'; $sL = 'Active'; }
            elseif ($permit->status === 'expired') { $sBg = '#fee2e2'; $sC = '#dc2626'; $sL = 'Expired'; }
            else { $sBg = '#fef3c7'; $sC = '#b45309'; $sL = ucfirst($permit->status); }
            $rows .= '
            <tr style="background:' . $bg . ';">
                <td style="padding:7px 10px;border-bottom:1px solid #e2e8f0;font-weight:600;">' . htmlspecialchars($permit->company_name ?? 'N/A') . '</td>
                <td style="padding:7px 10px;border-bottom:1px solid #e2e8f0;">' . ucfirst(str_replace('_', ' ', $permit->contract_type ?? 'N/A')) . '</td>
                <td style="padding:7px 10px;border-bottom:1px solid #e2e8f0;text-align:center;">' . ($permit->start_date ? \Carbon\Carbon::parse($permit->start_date)->format('M d, Y') : 'N/A') . '</td>
                <td style="padding:7px 10px;border-bottom:1px solid #e2e8f0;text-align:center;">' . ($permit->end_date ? \Carbon\Carbon::parse($permit->end_date)->format('M d, Y') : 'N/A') . '</td>
                <td style="padding:7px 10px;border-bottom:1px solid #e2e8f0;text-align:center;"><span style="background:' . $sBg . ';color:' . $sC . ';padding:2px 8px;border-radius:10px;font-size:8px;font-weight:700;">' . $sL . '</span></td>
            </tr>';
            $rowNum++;
        }

        if (empty(trim($rows))) {
            $rows = '<tr><td colspan="5" style="padding:20px;text-align:center;color:#94a3b8;font-size:9px;">No compliance records found.</td></tr>';
        }

        return '
        <style>* { font-family: helvetica; }</style>
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:0;">
            <tr>
                <td style="background:#1e3a5f;padding:22px 20px;border-radius:6px 6px 0 0;">
                    <table width="100%" cellpadding="0" cellspacing="0"><tr>
                        <td>
                            <div style="font-size:9px;color:#93c5fd;font-weight:700;letter-spacing:2px;text-transform:uppercase;margin-bottom:4px;">CRANECALI MANAGEMENT SYSTEM</div>
                            <div style="font-size:20px;font-weight:700;color:#ffffff;margin-bottom:3px;">Regulatory Compliance Report</div>
                            <div style="font-size:9px;color:#bfdbfe;">Generated on: ' . $generatedAt . '</div>
                        </td>
                        <td style="text-align:right;vertical-align:top;">
                            <div style="background:#1e40af;border:1px solid #3b82f6;border-radius:5px;padding:8px 14px;display:inline-block;">
                                <div style="font-size:8px;color:#93c5fd;margin-bottom:2px;">DOCUMENT STATUS</div>
                                <div style="font-size:11px;font-weight:700;color:#ffffff;">CONFIDENTIAL</div>
                            </div>
                        </td>
                    </tr></table>
                </td>
            </tr>
            <tr><td style="background:#1e40af;padding:5px 20px;border-radius:0 0 6px 6px;">
                <div style="font-size:8px;color:#bfdbfe;">Safety, Equipment Certification &amp; Environmental Standards &nbsp;|&nbsp; Authorized Personnel Only</div>
            </td></tr>
        </table>
        <br/>
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:0;">
            <tr><td style="background:#1e3a5f;padding:9px 14px;border-radius:5px 5px 0 0;">
                <div style="font-size:10px;font-weight:700;color:#ffffff;">Compliance Records</div>
                <div style="font-size:8px;color:#93c5fd;margin-top:1px;">Active permits, certifications and regulatory compliance status</div>
            </td></tr>
        </table>
        <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e2e8f0;border-radius:0 0 5px 5px;margin-bottom:16px;">
            <thead><tr style="background:#f1f5f9;">
                <th style="padding:8px 10px;text-align:left;font-size:8px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #e2e8f0;">Company</th>
                <th style="padding:8px 10px;text-align:left;font-size:8px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #e2e8f0;">Type</th>
                <th style="padding:8px 10px;text-align:center;font-size:8px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #e2e8f0;">Start Date</th>
                <th style="padding:8px 10px;text-align:center;font-size:8px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #e2e8f0;">End Date</th>
                <th style="padding:8px 10px;text-align:center;font-size:8px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #e2e8f0;">Status</th>
            </tr></thead>
            <tbody>' . $rows . '</tbody>
        </table>
        <table width="100%" cellpadding="0" cellspacing="0"><tr>
            <td style="background:#fefce8;border:1px solid #fde68a;border-left:4px solid #f59e0b;border-radius:5px;padding:10px 14px;">
                <div style="font-size:8px;font-weight:700;color:#92400e;margin-bottom:2px;">CONFIDENTIALITY NOTICE</div>
                <div style="font-size:8px;color:#78350f;">This document contains privileged regulatory and compliance information. Unauthorized use or distribution is strictly prohibited.</div>
            </td>
        </tr></table>
        <br/>
        <table width="100%" cellpadding="0" cellspacing="0"><tr>
            <td style="border-top:1px solid #e2e8f0;padding-top:8px;"><div style="font-size:8px;color:#94a3b8;">CraneCali Management System &nbsp;|&nbsp; Regulatory Compliance Report &nbsp;|&nbsp; ' . date('Y') . '</div></td>
            <td style="text-align:right;border-top:1px solid #e2e8f0;padding-top:8px;"><div style="font-size:8px;color:#94a3b8;">Page 1 of 1 &nbsp;|&nbsp; Auto-generated report</div></td>
        </tr></table>';
    }

    // ─── Project Status PDF ───────────────────────────────────────────────────
    private function buildProjectPdfHtml()
    {
        $generatedAt = date('F d, Y  H:i:s');
        $contracts = DB::table('contracts')
            ->select('company_name', 'contract_type', 'start_date', 'end_date', 'status', 'total_amount')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        $rows = '';
        $rowNum = 0;
        foreach ($contracts as $contract) {
            $bg = $rowNum % 2 === 0 ? '#ffffff' : '#f8fafc';
            if ($contract->status === 'active') { $sBg = '#dcfce7'; $sC = '#15803d'; $sL = 'Active'; }
            elseif ($contract->status === 'expired' || $contract->status === 'terminated') { $sBg = '#fee2e2'; $sC = '#dc2626'; $sL = ucfirst($contract->status); }
            else { $sBg = '#fef3c7'; $sC = '#b45309'; $sL = ucfirst($contract->status ?? 'Pending'); }
            $rows .= '
            <tr style="background:' . $bg . ';">
                <td style="padding:7px 10px;border-bottom:1px solid #e2e8f0;font-weight:600;">' . htmlspecialchars($contract->company_name ?? 'N/A') . '</td>
                <td style="padding:7px 10px;border-bottom:1px solid #e2e8f0;">' . ucfirst(str_replace('_', ' ', $contract->contract_type ?? 'N/A')) . '</td>
                <td style="padding:7px 10px;border-bottom:1px solid #e2e8f0;text-align:center;">' . ($contract->start_date ? \Carbon\Carbon::parse($contract->start_date)->format('M d, Y') : 'N/A') . '</td>
                <td style="padding:7px 10px;border-bottom:1px solid #e2e8f0;text-align:center;">' . ($contract->end_date ? \Carbon\Carbon::parse($contract->end_date)->format('M d, Y') : 'N/A') . '</td>
                <td style="padding:7px 10px;border-bottom:1px solid #e2e8f0;text-align:right;font-weight:700;color:#059669;">' . ($contract->total_amount ? 'PHP ' . number_format($contract->total_amount, 2) : 'N/A') . '</td>
                <td style="padding:7px 10px;border-bottom:1px solid #e2e8f0;text-align:center;"><span style="background:' . $sBg . ';color:' . $sC . ';padding:2px 8px;border-radius:10px;font-size:8px;font-weight:700;">' . $sL . '</span></td>
            </tr>';
            $rowNum++;
        }

        if (empty(trim($rows))) {
            $rows = '<tr><td colspan="6" style="padding:20px;text-align:center;color:#94a3b8;font-size:9px;">No project records found.</td></tr>';
        }

        return '
        <style>* { font-family: helvetica; }</style>
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:0;">
            <tr>
                <td style="background:#14532d;padding:22px 20px;border-radius:6px 6px 0 0;">
                    <table width="100%" cellpadding="0" cellspacing="0"><tr>
                        <td>
                            <div style="font-size:9px;color:#86efac;font-weight:700;letter-spacing:2px;text-transform:uppercase;margin-bottom:4px;">CRANECALI MANAGEMENT SYSTEM</div>
                            <div style="font-size:20px;font-weight:700;color:#ffffff;margin-bottom:3px;">Project Status Update</div>
                            <div style="font-size:9px;color:#bbf7d0;">Generated on: ' . $generatedAt . '</div>
                        </td>
                        <td style="text-align:right;vertical-align:top;">
                            <div style="background:#15803d;border:1px solid #22c55e;border-radius:5px;padding:8px 14px;display:inline-block;">
                                <div style="font-size:8px;color:#86efac;margin-bottom:2px;">DOCUMENT STATUS</div>
                                <div style="font-size:11px;font-weight:700;color:#ffffff;">CONFIDENTIAL</div>
                            </div>
                        </td>
                    </tr></table>
                </td>
            </tr>
            <tr><td style="background:#15803d;padding:5px 20px;border-radius:0 0 6px 6px;">
                <div style="font-size:8px;color:#bbf7d0;">Contract &amp; Project Progress Overview &nbsp;|&nbsp; Milestones &amp; Completion Status</div>
            </td></tr>
        </table>
        <br/>
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:0;">
            <tr><td style="background:#14532d;padding:9px 14px;border-radius:5px 5px 0 0;">
                <div style="font-size:10px;font-weight:700;color:#ffffff;">Active Contracts &amp; Projects</div>
                <div style="font-size:8px;color:#86efac;margin-top:1px;">Current contract portfolio with status and financial overview</div>
            </td></tr>
        </table>
        <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e2e8f0;border-radius:0 0 5px 5px;margin-bottom:16px;">
            <thead><tr style="background:#f1f5f9;">
                <th style="padding:8px 10px;text-align:left;font-size:8px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #e2e8f0;">Client</th>
                <th style="padding:8px 10px;text-align:left;font-size:8px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #e2e8f0;">Type</th>
                <th style="padding:8px 10px;text-align:center;font-size:8px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #e2e8f0;">Start</th>
                <th style="padding:8px 10px;text-align:center;font-size:8px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #e2e8f0;">End</th>
                <th style="padding:8px 10px;text-align:right;font-size:8px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #e2e8f0;">Value</th>
                <th style="padding:8px 10px;text-align:center;font-size:8px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #e2e8f0;">Status</th>
            </tr></thead>
            <tbody>' . $rows . '</tbody>
        </table>
        <table width="100%" cellpadding="0" cellspacing="0"><tr>
            <td style="background:#fefce8;border:1px solid #fde68a;border-left:4px solid #f59e0b;border-radius:5px;padding:10px 14px;">
                <div style="font-size:8px;font-weight:700;color:#92400e;margin-bottom:2px;">CONFIDENTIALITY NOTICE</div>
                <div style="font-size:8px;color:#78350f;">This document contains privileged project and contract information. Unauthorized use or distribution is strictly prohibited.</div>
            </td>
        </tr></table>
        <br/>
        <table width="100%" cellpadding="0" cellspacing="0"><tr>
            <td style="border-top:1px solid #e2e8f0;padding-top:8px;"><div style="font-size:8px;color:#94a3b8;">CraneCali Management System &nbsp;|&nbsp; Project Status Update &nbsp;|&nbsp; ' . date('Y') . '</div></td>
            <td style="text-align:right;border-top:1px solid #e2e8f0;padding-top:8px;"><div style="font-size:8px;color:#94a3b8;">Page 1 of 1 &nbsp;|&nbsp; Auto-generated report</div></td>
        </tr></table>';
    }

    public function forwardDocument(Request $request)
{
    try {
        $request->validate([
            'document_type' => 'required|string',
            'category' => 'required|string'
        ]);

        // ✅ Generate PDF content (no file save, just raw PDF bytes)
        $pdfContent = $this->generateReportPdf($request->document_type);
        $filename = str_replace(' ', '_', $request->document_type) . '_' . now()->format('Ymd_His') . '.pdf';

        // ✅ SEND TO EXTERNAL API
        $response = Http::withOptions([
            'verify' => false,
            'timeout' => 30
        ])
        ->attach('file', $pdfContent, $filename)
        ->post('https://admin.cranecali-ms.com/api/documents/store', [
            'title' => $request->document_type,
            'description' => "Automatically generated " . strtolower($request->document_type),
        ]);

        // ✅ RETURN JSON — HINDI HTML!
        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'message' => '✅ File successfully sent to Document Manager!',
                'filename' => $filename
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => '❌ API returned status: ' . $response->status() . ' — ' . $response->body()
        ], 500);

    } catch (\Throwable $e) {
        \Log::error('Forward Document Exception', [
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
        ]);

        return response()->json([
            'success' => false,
            'message' => '❌ ' . $e->getMessage()
        ], 500);
    }
}
    public function dashboard()
    {
        $totalRevenue = DB::table('billing_invoices')->where('status', 'paid')->sum('total_amount');
        $collectionRate = DB::table('billing_invoices')->where('status', 'paid')->count();
        $totalInvoices = DB::table('billing_invoices')->count();
        $collectionRatePercent = $totalInvoices > 0 ? round(($collectionRate / $totalInvoices) * 100) : 0;
        $activeContracts = DB::table('billing_invoices')->where('status', 'paid')->count();
        $completedThisMonth = MaintenanceSchedule::where('status', 'completed')
            ->whereMonth('completed_at', now()->month)
            ->whereYear('completed_at', now()->year)
            ->count();
        $complianceReports = DB::table('maintenance_schedules')->whereNotNull('ai_risk_score')->count();

        return view('dashboard', compact(
            'totalRevenue', 'collectionRatePercent', 'activeContracts',
            'completedThisMonth', 'complianceReports'
        ));
    }
}