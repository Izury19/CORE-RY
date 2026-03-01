<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_uid }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            background: #fff;
            color: #1e293b;
            font-size: 13px;
            padding: 0;
        }

        /* ── Top accent bar ── */
        .accent-bar {
            height: 6px;
            background: linear-gradient(90deg, #1e40af, #2563eb, #3b82f6);
        }

        /* ── Page wrapper ── */
        .page { padding: 40px 48px 48px; }

        /* ── Header ── */
        .inv-header { display: table; width: 100%; margin-bottom: 36px; }
        .inv-header-left  { display: table-cell; vertical-align: top; width: 55%; }
        .inv-header-right { display: table-cell; vertical-align: top; text-align: right; }

        .company-name { font-size: 22px; font-weight: 900; color: #0f172a; letter-spacing: -0.5px; margin-bottom: 3px; }
        .company-tag  { font-size: 11px; color: #64748b; letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 2px; }
        .company-addr { font-size: 11.5px; color: #94a3b8; margin-top: 6px; line-height: 1.6; }

        .inv-label { font-size: 10px; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase; color: #94a3b8; margin-bottom: 5px; }
        .inv-uid   { font-size: 26px; font-weight: 900; color: #1e40af; letter-spacing: -0.5px; margin-bottom: 6px; }
        .inv-date  { font-size: 12px; color: #64748b; }

        /* Status badge */
        .inv-status { display: inline-block; padding: 3px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; margin-top: 8px; }
        .status-issued  { background: #fef3c7; color: #b45309; }
        .status-paid    { background: #dcfce7; color: #15803d; }
        .status-default { background: #f1f5f9; color: #475569; }

        /* ── Divider ── */
        .divider { border: none; border-top: 1.5px solid #f1f5f9; margin: 0 0 28px; }
        .divider-blue { border-top-color: #dbeafe; }

        /* ── Parties (Bill To / Details) ── */
        .parties { display: table; width: 100%; margin-bottom: 28px; }
        .party-cell { display: table-cell; vertical-align: top; width: 50%; }
        .party-cell:last-child { text-align: right; }
        .party-label { font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: #94a3b8; margin-bottom: 8px; }
        .party-name  { font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 4px; }
        .party-sub   { font-size: 12px; color: #64748b; line-height: 1.6; }
        .party-meta  { font-size: 12px; color: #475569; line-height: 1.8; }
        .party-meta strong { color: #1e293b; }

        /* ── Billing period banner ── */
        .period-bar { background: #eff6ff; border: 1px solid #dbeafe; border-radius: 8px; padding: 11px 16px; margin-bottom: 24px; font-size: 12px; color: #1d4ed8; font-weight: 600; }
        .period-bar span { color: #3b82f6; font-weight: 400; }

        /* ── Line items table ── */
        .inv-table { width: 100%; border-collapse: collapse; margin-bottom: 0; }
        .inv-table thead tr { background: #1e40af; }
        .inv-table thead th { padding: 11px 16px; text-align: left; font-size: 10.5px; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase; color: rgba(255,255,255,0.85); }
        .inv-table thead th:last-child { text-align: right; }
        .inv-table tbody tr { border-bottom: 1px solid #f1f5f9; }
        .inv-table tbody tr:last-child { border-bottom: none; }
        .inv-table tbody td { padding: 14px 16px; font-size: 13px; color: #334155; vertical-align: top; }
        .inv-table tbody td:last-child { text-align: right; font-weight: 700; color: #0f172a; }
        .item-name  { font-weight: 700; color: #0f172a; margin-bottom: 3px; font-size: 13.5px; }
        .item-sub   { font-size: 11.5px; color: #94a3b8; }

        /* ── Totals block ── */
        .totals-wrap { display: table; width: 100%; margin-top: 0; }
        .totals-spacer { display: table-cell; width: 55%; }
        .totals-block  { display: table-cell; vertical-align: top; }
        .totals-inner { border: 1px solid #f1f5f9; border-top: none; border-radius: 0 0 10px 10px; overflow: hidden; }
        .total-row-item { display: table; width: 100%; border-bottom: 1px solid #f8fafc; }
        .total-row-item:last-child { border-bottom: none; }
        .total-row-item td { display: table-cell; padding: 10px 16px; font-size: 12.5px; }
        .total-row-item td:last-child { text-align: right; font-weight: 700; color: #0f172a; }
        .total-row-item .tl { color: #64748b; }
        .total-final { background: #1e40af; }
        .total-final td { padding: 14px 16px !important; }
        .total-final .tl { color: rgba(255,255,255,0.8) !important; font-size: 13px !important; font-weight: 700; }
        .total-final td:last-child { color: #fff !important; font-size: 18px !important; font-weight: 900; }

        /* ── Payment instructions ── */
        .payment-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px 20px; margin-top: 28px; display: table; width: 100%; }
        .payment-col { display: table-cell; vertical-align: top; width: 50%; }
        .payment-col:last-child { padding-left: 24px; border-left: 1px solid #e2e8f0; }
        .payment-label { font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: #94a3b8; margin-bottom: 8px; }
        .payment-item  { font-size: 12px; color: #475569; margin-bottom: 4px; }
        .payment-item strong { color: #1e293b; }
        .payment-email { font-size: 12.5px; font-weight: 700; color: #1d4ed8; }

        /* ── AI verified strip ── */
        .ai-strip { margin-top: 24px; border-radius: 8px; padding: 10px 16px; font-size: 11.5px; font-weight: 600; display: table; width: 100%; }
        .ai-ok  { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
        .ai-err { background: #fff1f2; border: 1px solid #fecaca; color: #dc2626; }

        /* ── Footer ── */
        .inv-footer { margin-top: 36px; border-top: 1px solid #f1f5f9; padding-top: 18px; display: table; width: 100%; }
        .footer-left  { display: table-cell; vertical-align: middle; font-size: 11px; color: #94a3b8; line-height: 1.7; }
        .footer-right { display: table-cell; vertical-align: middle; text-align: right; }
        .footer-badge { display: inline-block; background: #eff6ff; border: 1px solid #dbeafe; border-radius: 6px; padding: 5px 12px; font-size: 10.5px; font-weight: 700; color: #1d4ed8; letter-spacing: 0.3px; }

        /* ── Page number ── */
        .page-num { font-size: 10px; color: #cbd5e1; margin-top: 4px; }
    </style>
</head>
<body>

    {{-- Top accent bar --}}
    <div class="accent-bar"></div>

    <div class="page">

        {{-- ── HEADER ── --}}
        <div class="inv-header">
            <div class="inv-header-left">
                <div class="company-name">CALI HEAVY EQUIPMENT INC.</div>
                <div class="company-tag">Equipment Rental Services</div>
                <div class="company-addr">
                    Manila, Philippines<br>
                    billing@caliheavy.com · +63 (2) 8XXX-XXXX
                </div>
            </div>
            <div class="inv-header-right">
                <div class="inv-label">Official Invoice</div>
                <div class="inv-uid">{{ $invoice->invoice_uid }}</div>
                <div class="inv-date">Issued: {{ \Carbon\Carbon::now()->format('F d, Y') }}</div>
                @if($invoice->job_order_id)
                <div class="inv-date" style="margin-top:3px;">Job Order: JO-{{ str_pad($invoice->job_order_id, 4, '0', STR_PAD_LEFT) }}</div>
                @endif
                <div>
                    @if($invoice->status == 'billed' || $invoice->status == 'issued')
                        <span class="inv-status status-issued">ISSUED</span>
                    @elseif($invoice->status == 'paid')
                        <span class="inv-status status-paid">PAID</span>
                    @else
                        <span class="inv-status status-default">{{ strtoupper($invoice->status) }}</span>
                    @endif
                </div>
            </div>
        </div>

        <hr class="divider divider-blue">

        {{-- ── PARTIES ── --}}
        <div class="parties">
            <div class="party-cell">
                <div class="party-label">Billed To</div>
                <div class="party-name">{{ $invoice->client_name }}</div>
                <div class="party-sub">Equipment Rental Client</div>
            </div>
            <div class="party-cell">
                <div class="party-meta">
                    <strong>Equipment:</strong> {{ ucfirst(str_replace('_', ' ', $invoice->equipment_type)) }}<br>
                    <strong>Unit ID:</strong> {{ $invoice->equipment_id ?? 'N/A' }}<br>
                    <strong>Hours Used:</strong> {{ $invoice->hours_used ?? 'N/A' }} hrs<br>
                    <strong>Hourly Rate:</strong> ₱{{ number_format($invoice->hourly_rate, 2) }}/hr
                </div>
            </div>
        </div>

        {{-- ── BILLING PERIOD ── --}}
        @if($invoice->billing_period_start && $invoice->billing_period_end)
        <div class="period-bar">
            Billing Period:&nbsp;
            <span>
                {{ \Carbon\Carbon::parse($invoice->billing_period_start)->format('F d, Y') }}
                &nbsp;—&nbsp;
                {{ \Carbon\Carbon::parse($invoice->billing_period_end)->format('F d, Y') }}
                ({{ \Carbon\Carbon::parse($invoice->billing_period_start)->diffInDays(\Carbon\Carbon::parse($invoice->billing_period_end)) }} days)
            </span>
        </div>
        @endif

        {{-- ── LINE ITEMS TABLE ── --}}
        <table class="inv-table">
            <thead>
                <tr>
                    <th style="width:45%;">Description</th>
                    <th>Qty / Hours</th>
                    <th>Unit Price</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="item-name">{{ ucfirst(str_replace('_', ' ', $invoice->equipment_type)) }} Rental Service</div>
                        <div class="item-sub">
                            Unit: {{ $invoice->equipment_id ?? 'N/A' }}
                            @if($invoice->billing_period_start && $invoice->billing_period_end)
                                · {{ \Carbon\Carbon::parse($invoice->billing_period_start)->format('M d') }} – {{ \Carbon\Carbon::parse($invoice->billing_period_end)->format('M d, Y') }}
                            @endif
                        </div>
                    </td>
                    <td style="vertical-align:top; padding-top:14px;">{{ $invoice->hours_used ?? 1 }} hrs</td>
                    <td style="vertical-align:top; padding-top:14px;">₱{{ number_format($invoice->hourly_rate, 2) }}</td>
                    <td style="vertical-align:top; padding-top:14px;">₱{{ number_format($invoice->total_amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        {{-- ── TOTALS ── --}}
        <div class="totals-wrap">
            <div class="totals-spacer"></div>
            <div class="totals-block">
                <div class="totals-inner">
                    <table class="total-row-item" style="width:100%;">
                        <tr><td class="tl">Subtotal</td><td>₱{{ number_format(($invoice->hourly_rate ?? 0) * ($invoice->hours_used ?? 0), 2) }}</td></tr>
                    </table>
                    <table class="total-row-item" style="width:100%;">
                        <tr><td class="tl">VAT (0%)</td><td>₱0.00</td></tr>
                    </table>
                    <table class="total-row-item total-final" style="width:100%;">
                        <tr><td class="tl">Total Amount Due</td><td>₱{{ number_format($invoice->total_amount, 2) }}</td></tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- ── PAYMENT INSTRUCTIONS ── --}}
        <div class="payment-box">
            <div class="payment-col">
                <div class="payment-label">Payment Methods</div>
                <div class="payment-item">🏦 <strong>Bank Transfer</strong> — BDO / BPI</div>
                <div class="payment-item">📱 <strong>GCash</strong> — 09XX-XXX-XXXX</div>
                <div class="payment-item">💵 <strong>Cash</strong> — At main office</div>
            </div>
            <div class="payment-col">
                <div class="payment-label">Send Proof of Payment To</div>
                <div class="payment-email">billing@caliheavy.com</div>
                <div class="payment-item" style="margin-top:6px;">Please include invoice number<br><strong>{{ $invoice->invoice_uid }}</strong> as reference.</div>
            </div>
        </div>

        {{-- ── AI STATUS ── --}}
        @if($invoice->ai_duplicate_flag ?? false)
        <div class="ai-strip ai-err">
            ⚠ AI Alert: Similar invoice entries detected within the last 30 days. Please review before processing payment.
        </div>
        @else
        <div class="ai-strip ai-ok">
            ✓ AI Verified: No duplicate issues detected. This invoice has been cleared for processing.
        </div>
        @endif

        {{-- ── FOOTER ── --}}
        <div class="inv-footer">
            <div class="footer-left">
                This is a computer-generated invoice. No signature required.<br>
                Thank you for choosing Cali Heavy Equipment Inc. — We appreciate your business.
            </div>
            <div class="footer-right">
                <div class="footer-badge">CALI HEAVY EQUIPMENT INC.</div>
                <div class="page-num">Invoice {{ $invoice->invoice_uid }}</div>
            </div>
        </div>

    </div>
</body>
</html>