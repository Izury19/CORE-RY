<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Financial Intelligence Report</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
            background: #fff;
            padding: 0;
        }

        /* ── TOP HEADER BAND ── */
        .top-band {
            background: #1e293b;
            color: #fff;
            padding: 28px 36px 22px;
            position: relative;
            overflow: hidden;
        }
        .top-band::after {
            content: '';
            position: absolute;
            right: -40px;
            top: -40px;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }
        .top-band::before {
            content: '';
            position: absolute;
            right: 60px;
            bottom: -60px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(255,255,255,0.03);
        }
        .brand-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }
        .brand-name {
            font-size: 13px;
            font-weight: bold;
            color: #94a3b8;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }
        .report-badge {
            background: #3b82f6;
            color: #fff;
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: 20px;
        }
        .report-title {
            font-size: 24px;
            font-weight: bold;
            color: #fff;
            letter-spacing: -0.02em;
            line-height: 1.2;
            margin-bottom: 6px;
        }
        .report-subtitle {
            font-size: 11px;
            color: #94a3b8;
        }

        /* ── ACCENT BAR ── */
        .accent-bar {
            height: 4px;
            background: linear-gradient(to right, #3b82f6, #8b5cf6, #10b981);
        }

        /* ── BODY CONTENT ── */
        .content {
            padding: 28px 36px;
        }

        /* ── SUMMARY CARDS ── */
        .summary-row {
            display: table;
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px;
            margin-bottom: 24px;
        }
        .summary-card {
            display: table-cell;
            width: 33%;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 14px 16px;
            vertical-align: top;
        }
        .summary-card.blue  { border-top: 3px solid #3b82f6; }
        .summary-card.green { border-top: 3px solid #10b981; }
        .summary-card.slate { border-top: 3px solid #64748b; }
        .card-label {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94a3b8;
            margin-bottom: 6px;
        }
        .card-value {
            font-size: 20px;
            font-weight: bold;
            color: #0f172a;
            line-height: 1;
            margin-bottom: 3px;
        }
        .card-hint {
            font-size: 9px;
            color: #64748b;
        }

        /* ── SECTION HEADING ── */
        .section-heading {
            font-size: 12px;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .section-heading .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #3b82f6;
            display: inline-block;
        }

        /* ── TABLE ── */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin-bottom: 24px;
        }
        .data-table thead tr {
            background: #1e293b;
            color: #fff;
        }
        .data-table thead th {
            padding: 9px 12px;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            border: none;
        }
        .data-table thead th:first-child { border-radius: 6px 0 0 0; }
        .data-table thead th:last-child  { border-radius: 0 6px 0 0; }
        .data-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
        }
        .data-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }
        .data-table tbody tr:hover {
            background: #eff6ff;
        }
        .data-table tbody td {
            padding: 8px 12px;
            color: #334155;
            vertical-align: middle;
            border: none;
        }
        .data-table tbody td.inv-id {
            font-weight: bold;
            color: #1e40af;
            font-size: 10px;
        }
        .data-table tbody td.client {
            font-weight: bold;
            color: #0f172a;
        }
        .data-table tbody td.amount {
            font-weight: bold;
            color: #059669;
        }
        .data-table tfoot tr {
            background: #f1f5f9;
            border-top: 2px solid #e2e8f0;
        }
        .data-table tfoot td {
            padding: 9px 12px;
            font-weight: bold;
            color: #0f172a;
            font-size: 10px;
        }

        /* ── INFO BOX ── */
        .info-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-left: 4px solid #3b82f6;
            border-radius: 6px;
            padding: 12px 16px;
            margin-bottom: 24px;
            font-size: 10px;
            color: #1d4ed8;
            line-height: 1.5;
        }

        /* ── FOOTER ── */
        .footer-band {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 16px 36px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .footer-left {
            font-size: 9px;
            color: #94a3b8;
            line-height: 1.6;
        }
        .footer-right {
            font-size: 9px;
            color: #94a3b8;
            text-align: right;
        }
        .confidential-tag {
            background: #fef3c7;
            border: 1px solid #fde68a;
            color: #92400e;
            font-size: 8px;
            font-weight: bold;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 3px 10px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 4px;
        }

        /* ── PAGE BREAK ── */
        .page-break { page-break-after: always; }
    </style>
</head>
<body>

    {{-- ══ HEADER ══ --}}
    <div class="top-band">
        <div class="brand-row">
            <span class="brand-name">CraneCali Management System</span>
            <span class="report-badge">Confidential</span>
        </div>
        <div class="report-title">Financial Intelligence Report</div>
        <div class="report-subtitle">
            Generated on {{ date('F d, Y') }} at {{ date('h:i A') }} &nbsp;·&nbsp; Reporting & Analytics Hub
        </div>
    </div>
    <div class="accent-bar"></div>

    <div class="content">

        {{-- ══ SUMMARY CARDS ══ --}}
        <table class="summary-row">
            <tr>
                <td class="summary-card green">
                    <div class="card-label">Total Revenue</div>
                    <div class="card-value">₱{{ number_format($totalRevenue, 2) }}</div>
                    <div class="card-hint">From all paid invoices</div>
                </td>
                <td class="summary-card blue">
                    <div class="card-label">Collection Rate</div>
                    <div class="card-value">{{ $collectionRatePercent }}%</div>
                    <div class="card-hint">Paid vs total invoices</div>
                </td>
                <td class="summary-card slate">
                    <div class="card-label">Active Clients</div>
                    <div class="card-value">{{ $invoiceDetails->count() }}</div>
                    <div class="card-hint">With paid invoices</div>
                </td>
            </tr>
        </table>

        {{-- ══ AI INSIGHT ══ --}}
        <div class="info-box">
            🤖 <strong>AI Insight:</strong> Total revenue is calculated as the sum of all billed hours × hourly rates from paid invoices. Collection rate reflects payment performance across all billing periods.
        </div>

        {{-- ══ TRANSACTION TABLE ══ --}}
        <div class="section-heading">
            <span class="dot"></span> Transaction Details
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Invoice ID</th>
                    <th>Client Name</th>
                    <th>Equipment Type</th>
                    <th>Equip. ID</th>
                    <th>Hours</th>
                    <th>Rate / hr</th>
                    <th>Total Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoiceDetails as $invoice)
                <tr>
                    <td class="inv-id">INV-{{ str_pad($invoice->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td class="client">{{ $invoice->client_name }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $invoice->equipment_type)) }}</td>
                    <td>{{ $invoice->equipment_id }}</td>
                    <td style="text-align:center;">{{ $invoice->hours_used }}</td>
                    <td>₱{{ number_format($invoice->hourly_rate, 2) }}</td>
                    <td class="amount">₱{{ number_format($invoice->total_amount, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('M d, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" style="text-align:right;">TOTAL REVENUE</td>
                    <td style="color:#059669;">₱{{ number_format($totalRevenue, 2) }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

    </div>

    {{-- ══ FOOTER ══ --}}
    <div class="footer-band">
        <div class="footer-left">
            <div class="confidential-tag">🔒 Confidential</div><br>
            This is a system-generated report from CraneCali Management System.<br>
            Do not distribute without authorization from management.
        </div>
        <div class="footer-right">
            Financial Intelligence Report<br>
            {{ date('F Y') }}<br>
            Page 1 of 1
        </div>
    </div>

</body>
</html>