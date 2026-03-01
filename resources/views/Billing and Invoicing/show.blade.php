@extends('layouts.app')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet">

<style>
.iv-wrap * { box-sizing: border-box; }
.iv-wrap { font-family: 'DM Sans', sans-serif; color: #1e293b; background: #f8fafc; min-height: 100vh; }

/* Header */
.iv-header { background: #fff; border-bottom: 1px solid #e2e8f0; padding: 18px 32px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; box-shadow: 0 1px 4px rgba(0,0,0,0.04); }
.iv-header-left { display: flex; align-items: center; gap: 14px; }
.iv-back { width: 36px; height: 36px; border-radius: 9px; border: 1.5px solid #e2e8f0; background: #f8fafc; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #64748b; text-decoration: none; transition: all 0.18s; flex-shrink: 0; }
.iv-back:hover { border-color: #3b82f6; color: #3b82f6; background: #eff6ff; }
.iv-header-left h1 { font-family: 'Outfit', sans-serif; font-size: 20px; font-weight: 800; color: #0f172a; letter-spacing: -0.02em; margin: 0; }
.iv-header-left p  { font-size: 13px; color: #94a3b8; margin: 2px 0 0; }
.iv-header-right { display: flex; gap: 10px; }

/* Buttons */
.iv-btn { display: inline-flex; align-items: center; gap: 7px; padding: 9px 18px; border: none; border-radius: 9px; font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.18s; text-decoration: none; white-space: nowrap; }
.iv-btn-green  { background: #059669; color: #fff; }
.iv-btn-green:hover  { background: #047857; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(5,150,105,0.28); }
.iv-btn-ghost  { background: #f1f5f9; color: #475569; }
.iv-btn-ghost:hover  { background: #e2e8f0; }

/* Body */
.iv-body { max-width: 860px; margin: 0 auto; padding: 28px 24px 60px; }

/* AI Banner */
.iv-banner { display: flex; align-items: center; gap: 11px; padding: 14px 18px; border-radius: 11px; margin-bottom: 22px; font-size: 13.5px; font-weight: 600; }
.banner-ok  { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
.banner-err { background: #fff1f2; border: 1px solid #fecaca; color: #dc2626; }
.iv-banner-icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.banner-ok  .iv-banner-icon { background: #dcfce7; }
.banner-err .iv-banner-icon { background: #fee2e2; }

/* Invoice "document" header card */
.iv-doc-header { background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 60%, #2563eb 100%); border-radius: 16px 16px 0 0; padding: 28px 32px; display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 20px; }
.iv-doc-logo { display: flex; align-items: center; gap: 12px; }
.iv-doc-logo-icon { width: 44px; height: 44px; background: rgba(255,255,255,0.15); border-radius: 11px; display: flex; align-items: center; justify-content: center; }
.iv-doc-logo-text h2 { font-family: 'Outfit', sans-serif; font-size: 18px; font-weight: 800; color: #fff; margin: 0; letter-spacing: -0.02em; }
.iv-doc-logo-text p  { font-size: 12px; color: rgba(255,255,255,0.65); margin: 2px 0 0; }
.iv-doc-meta { text-align: right; }
.iv-doc-meta .iv-doc-uid { font-family: 'Outfit', sans-serif; font-size: 22px; font-weight: 800; color: #fff; letter-spacing: -0.02em; }
.iv-doc-meta .iv-doc-date { font-size: 12px; color: rgba(255,255,255,0.65); margin-top: 3px; }

/* Invoice body card */
.iv-doc-body { background: #fff; border: 1px solid #e2e8f0; border-top: none; border-radius: 0 0 16px 16px; overflow: hidden; margin-bottom: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); }

/* Client / Equipment strip */
.iv-parties { display: grid; grid-template-columns: 1fr 1px 1fr; background: #f8fafc; border-bottom: 1px solid #f1f5f9; }
.iv-party { padding: 20px 24px; }
.iv-party-divider { background: #f1f5f9; }
.iv-party-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: #94a3b8; margin-bottom: 8px; display: flex; align-items: center; gap: 6px; }
.iv-party-label svg { color: #94a3b8; }
.iv-party-name  { font-family: 'Outfit', sans-serif; font-size: 17px; font-weight: 700; color: #0f172a; margin-bottom: 3px; }
.iv-party-sub   { font-size: 12.5px; color: #64748b; }

/* Details grid */
.iv-details { padding: 24px; }
.iv-details-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 24px; }
.iv-detail-item {}
.iv-detail-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: #94a3b8; margin-bottom: 5px; }
.iv-detail-value { font-size: 14px; font-weight: 600; color: #1e293b; line-height: 1.4; }
.iv-detail-value.mono { font-family: 'Outfit', sans-serif; }

/* Status pill */
.iv-pill { display: inline-flex; align-items: center; padding: 3px 11px; border-radius: 20px; font-size: 12px; font-weight: 700; }
.pill-issued  { background: #fef3c7; color: #b45309; }
.pill-paid    { background: #dcfce7; color: #15803d; }
.pill-default { background: #f1f5f9; color: #475569; }

/* Billing period bar */
.iv-period-bar { background: #eff6ff; border: 1px solid #dbeafe; border-radius: 10px; padding: 13px 18px; display: flex; align-items: center; gap: 10px; margin-bottom: 24px; font-size: 13px; color: #1d4ed8; font-weight: 500; }
.iv-period-bar svg { flex-shrink: 0; }

/* Divider */
.iv-rule { border: none; border-top: 1px solid #f1f5f9; margin: 0 0 24px; }

/* Calculation breakdown */
.iv-calc { background: #f8fafc; border: 1px solid #f1f5f9; border-radius: 12px; overflow: hidden; }
.iv-calc-row { display: flex; justify-content: space-between; align-items: center; padding: 13px 20px; border-bottom: 1px solid #f1f5f9; font-size: 13.5px; }
.iv-calc-row:last-child { border-bottom: none; }
.iv-calc-label { color: #64748b; font-weight: 500; display: flex; align-items: center; gap: 8px; }
.iv-calc-label-icon { width: 28px; height: 28px; border-radius: 7px; display: flex; align-items: center; justify-content: center; }
.iv-calc-value { font-weight: 700; color: #1e293b; font-family: 'Outfit', sans-serif; }
.iv-calc-total { background: #1e40af; }
.iv-calc-total .iv-calc-label { color: rgba(255,255,255,0.8); font-size: 14px; font-weight: 700; }
.iv-calc-total .iv-calc-value { color: #fff; font-size: 22px; font-weight: 800; }

/* AI note */
.iv-ai-note { background: #f5f3ff; border: 1px solid #ddd6fe; border-radius: 10px; padding: 13px 18px; display: flex; gap: 10px; align-items: flex-start; margin-top: 20px; font-size: 13px; color: #4c1d95; font-weight: 500; line-height: 1.5; }

/* Animations */
@keyframes ivFU { from{opacity:0;transform:translateY(12px);} to{opacity:1;transform:translateY(0);} }
.iv-a  { animation: ivFU 0.35s ease both; }
.d1{animation-delay:.04s} .d2{animation-delay:.08s} .d3{animation-delay:.12s} .d4{animation-delay:.16s}

/* Responsive */
@media(max-width:700px) {
    .iv-parties { grid-template-columns: 1fr; }
    .iv-party-divider { display: none; }
    .iv-details-grid { grid-template-columns: 1fr 1fr; }
    .iv-body { padding: 18px 14px 40px; }
    .iv-header { padding: 14px 18px; }
    .iv-doc-header { padding: 20px; border-radius: 12px 12px 0 0; }
    .iv-doc-meta { text-align: left; }
}
@media(max-width:480px) { .iv-details-grid { grid-template-columns: 1fr; } }
</style>

<div class="iv-wrap">

    {{-- Header --}}
    <div class="iv-header">
        <div class="iv-header-left">
            <a href="{{ route('billing.invoices.index') }}" class="iv-back">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1>Invoice Details</h1>
                <p>{{ $invoice->invoice_uid }}</p>
            </div>
        </div>
        <div class="iv-header-right">
            <a href="{{ route('billing.invoices.pdf', $invoice->id) }}" class="iv-btn iv-btn-green">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Download PDF
            </a>
           
        </div>
    </div>

    <div class="iv-body">

        {{-- AI Banner --}}
        @if($invoice->ai_duplicate_flag ?? false)
        <div class="iv-banner banner-err iv-a d1">
            <div class="iv-banner-icon">
                <svg width="16" height="16" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <strong>AI Duplicate Alert</strong> — This invoice has similar entries detected within the last 30 days. Please review before processing.
            </div>
        </div>
        @else
        <div class="iv-banner banner-ok iv-a d1">
            <div class="iv-banner-icon">
                <svg width="16" height="16" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <strong>AI Verified</strong> — No duplicate issues detected. This invoice is clear for processing.
            </div>
        </div>
        @endif

        {{-- Invoice Document --}}
        <div class="iv-a d2">

            {{-- Doc Header --}}
            <div class="iv-doc-header">
                <div class="iv-doc-logo">
                    <div class="iv-doc-logo-icon">
                        <svg width="22" height="22" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div class="iv-doc-logo-text">
                        <h2>CaliCrane</h2>
                        <p>Equipment Rental Services</p>
                    </div>
                </div>
                <div class="iv-doc-meta">
                    <div class="iv-doc-uid">{{ $invoice->invoice_uid }}</div>
                    <div class="iv-doc-date">
                        Issued {{ \Carbon\Carbon::parse($invoice->created_at)->format('F d, Y') }}
                        @if($invoice->job_order_id)
                        · JO-{{ str_pad($invoice->job_order_id, 4, '0', STR_PAD_LEFT) }}
                        @endif
                    </div>
                    <div style="margin-top:10px;">
                        @if($invoice->status == 'billed' || $invoice->status == 'issued')
                            <span class="iv-pill pill-issued">Issued</span>
                        @elseif($invoice->status == 'paid')
                            <span class="iv-pill pill-paid">Paid</span>
                        @else
                            <span class="iv-pill pill-default">{{ ucfirst($invoice->status) }}</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Doc Body --}}
            <div class="iv-doc-body">

                {{-- Client / Equipment Strip --}}
                <div class="iv-parties">
                    <div class="iv-party">
                        <div class="iv-party-label">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Billed To
                        </div>
                        <div class="iv-party-name">{{ $invoice->client_name }}</div>
                        <div class="iv-party-sub">Client · Equipment Rental</div>
                    </div>
                    <div class="iv-party-divider"></div>
                    <div class="iv-party">
                        <div class="iv-party-label">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Equipment
                        </div>
                        <div class="iv-party-name">{{ ucfirst(str_replace('_', ' ', $invoice->equipment_type)) }}</div>
                        <div class="iv-party-sub">Unit ID: {{ $invoice->equipment_id ?? 'N/A' }}</div>
                    </div>
                </div>

                <div class="iv-details">

                    {{-- Billing Period Bar --}}
                    @if($invoice->billing_period_start && $invoice->billing_period_end)
                    <div class="iv-period-bar">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>
                            <strong>Billing Period:</strong>
                            {{ \Carbon\Carbon::parse($invoice->billing_period_start)->format('F d, Y') }}
                            &nbsp;→&nbsp;
                            {{ \Carbon\Carbon::parse($invoice->billing_period_end)->format('F d, Y') }}
                            ({{ \Carbon\Carbon::parse($invoice->billing_period_start)->diffInDays(\Carbon\Carbon::parse($invoice->billing_period_end)) }} days)
                        </span>
                    </div>
                    @endif

                    {{-- Details Grid --}}
                    <div class="iv-details-grid">
                        <div class="iv-detail-item">
                            <div class="iv-detail-label">Invoice ID</div>
                            <div class="iv-detail-value mono">{{ $invoice->invoice_uid }}</div>
                        </div>
                        <div class="iv-detail-item">
                            <div class="iv-detail-label">Job Order</div>
                            <div class="iv-detail-value mono">
                                @if($invoice->job_order_id)
                                    JO-{{ str_pad($invoice->job_order_id, 4, '0', STR_PAD_LEFT) }}
                                @else
                                    <span style="color:#94a3b8;font-weight:400;">Not linked</span>
                                @endif
                            </div>
                        </div>
                        <div class="iv-detail-item">
                            <div class="iv-detail-label">Hours Used</div>
                            <div class="iv-detail-value mono">{{ $invoice->hours_used ?? 'N/A' }} hrs</div>
                        </div>
                        <div class="iv-detail-item">
                            <div class="iv-detail-label">Equipment Type</div>
                            <div class="iv-detail-value">{{ ucfirst(str_replace('_', ' ', $invoice->equipment_type)) }}</div>
                        </div>
                        <div class="iv-detail-item">
                            <div class="iv-detail-label">Equipment ID</div>
                            <div class="iv-detail-value mono">{{ $invoice->equipment_id ?? 'N/A' }}</div>
                        </div>
                        <div class="iv-detail-item">
                            <div class="iv-detail-label">Status</div>
                            <div class="iv-detail-value">
                                @if($invoice->status == 'billed' || $invoice->status == 'issued')
                                    <span class="iv-pill pill-issued">Issued</span>
                                @elseif($invoice->status == 'paid')
                                    <span class="iv-pill pill-paid">Paid</span>
                                @else
                                    <span class="iv-pill pill-default">{{ ucfirst($invoice->status) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr class="iv-rule">

                    {{-- Calculation Breakdown --}}
                    <div class="iv-calc">
                        <div class="iv-calc-row">
                            <div class="iv-calc-label">
                                <div class="iv-calc-label-icon" style="background:#eff6ff;">
                                    <svg width="13" height="13" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                Hourly Rate
                            </div>
                            <div class="iv-calc-value">₱{{ number_format($invoice->hourly_rate, 2) }} / hr</div>
                        </div>
                        <div class="iv-calc-row">
                            <div class="iv-calc-label">
                                <div class="iv-calc-label-icon" style="background:#f0fdf4;">
                                    <svg width="13" height="13" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                </div>
                                Hours Used
                            </div>
                            <div class="iv-calc-value">{{ $invoice->hours_used ?? 0 }} hrs</div>
                        </div>
                        <div class="iv-calc-row">
                            <div class="iv-calc-label">
                                <div class="iv-calc-label-icon" style="background:#fef3c7;">
                                    <svg width="13" height="13" fill="none" stroke="#b45309" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
                                </div>
                                Subtotal
                            </div>
                            <div class="iv-calc-value">₱{{ number_format(($invoice->hourly_rate ?? 0) * ($invoice->hours_used ?? 0), 2) }}</div>
                        </div>
                        <div class="iv-calc-row iv-calc-total">
                            <div class="iv-calc-label">
                                <div class="iv-calc-label-icon" style="background:rgba(255,255,255,0.15);">
                                    <svg width="13" height="13" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                Total Amount Due
                            </div>
                            <div class="iv-calc-value">₱{{ number_format($invoice->total_amount, 2) }}</div>
                        </div>
                    </div>

                    {{-- AI note --}}
                    <div class="iv-ai-note">
                        <svg width="16" height="16" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <span><strong>AI Note:</strong> Amount is auto-calculated from billed hours × hourly rate. Total is verified against job order records.</span>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection