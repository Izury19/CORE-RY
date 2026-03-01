<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Dashboard</title>

    <style>
        /* ── MAIN CONTENT STYLES ONLY ── */
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        .dash-main { background: #f0f2f7; min-height: 100vh; }

        /* Page Header */
        .dash-page-header { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 22px; }
        .dash-page-title { font-family: 'Outfit', sans-serif; font-size: 22px; font-weight: 700; color: #111827; letter-spacing: -0.02em; }
        .dash-page-sub { font-size: 12.5px; color: #9ca3af; margin-top: 3px; }
        .dash-export-btn {
            display: inline-flex; align-items: center; gap: 7px; padding: 9px 18px;
            background: #111827; color: #fff; border: none; border-radius: 9px;
            font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600;
            cursor: pointer; transition: background 0.18s, transform 0.1s;
        }
        .dash-export-btn:hover { background: #1f2937; transform: translateY(-1px); }

        /* Filter Bar */
        .dash-filter-bar {
            background: #fff; border: 1px solid #e5e7eb; border-radius: 14px;
            padding: 16px 20px; margin-bottom: 22px; display: flex;
            align-items: flex-end; gap: 14px; flex-wrap: wrap;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        }
        .dash-filter-group { display: flex; flex-direction: column; gap: 5px; flex: 1; min-width: 130px; }
        .dash-filter-label { font-size: 10.5px; font-weight: 700; letter-spacing: 0.07em; text-transform: uppercase; color: #9ca3af; }
        .dash-filter-input, .dash-filter-select {
            height: 38px; padding: 0 12px; border: 1.5px solid #e5e7eb; border-radius: 9px;
            background: #f9fafb; color: #111827; font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13.5px; outline: none; transition: border-color 0.18s, box-shadow 0.18s;
        }
        .dash-filter-input:focus, .dash-filter-select:focus {
            border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); background: #fff;
        }
        .dash-filter-btn {
            height: 38px; padding: 0 20px; background: #6366f1; color: #fff; border: none;
            border-radius: 9px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px;
            font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 7px;
            white-space: nowrap; flex-shrink: 0; transition: background 0.18s;
        }
        .dash-filter-btn:hover { background: #4f46e5; }

        /* KPI Grid */
        .dash-kpi-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; margin-bottom: 22px; }
        .dash-kpi-card {
            background: #fff; border-radius: 14px; padding: 20px;
            border: 1px solid #e5e7eb; text-decoration: none; color: inherit; display: block;
            transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            position: relative; overflow: hidden;
        }
        .dash-kpi-card:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(0,0,0,0.1); }
        .dash-kpi-accent { position: absolute; top:0; left:0; right:0; height:4px; border-radius: 14px 14px 0 0; }
        .dash-kpi-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 16px; margin-top: 8px; }
        .dash-kpi-icon { width:44px; height:44px; border-radius:11px; display:flex; align-items:center; justify-content:center; }
        .dash-kpi-badge { font-size:11px; font-weight:700; padding: 3px 9px; border-radius: 20px; }
        .badge-green { background:#dcfce7; color:#15803d; }
        .badge-indigo { background:#e0e7ff; color:#4338ca; }
        .badge-purple { background:#ede9fe; color:#6d28d9; }
        .badge-red    { background:#fee2e2; color:#dc2626; }
        .badge-gray   { background:#f3f4f6; color:#6b7280; }
        .dash-kpi-label { font-size:12px; font-weight:600; color:#9ca3af; margin-bottom:5px; }
        .dash-kpi-value { font-family:'Outfit',sans-serif; font-size:28px; font-weight:700; color:#111827; letter-spacing:-0.03em; line-height:1; }
        .dash-kpi-meta { font-size:11.5px; color:#d1d5db; margin-top:5px; }

        /* Confidential blur */
        .conf-wrap { position:relative; display:inline-flex; align-items:center; }
        .conf-value { transition: filter 0.3s; display:inline-block; }
        .conf-value.blurred { filter: blur(8px); user-select:none; pointer-events:none; }
        .conf-unlock {
            position:absolute; left:50%; top:50%; transform:translate(-50%,-50%);
            background:#111827; color:#fbbf24; border:none; padding:4px 10px;
            border-radius:7px; font-family:'Plus Jakarta Sans',sans-serif; font-size:11px;
            font-weight:700; cursor:pointer; white-space:nowrap;
            box-shadow:0 2px 10px rgba(0,0,0,0.25); display:flex; align-items:center; gap:4px;
        }
        .conf-unlock.hidden { display:none; }

        /* Charts */
        .dash-charts-row-1 { display:grid; grid-template-columns:1.6fr 1fr; gap:16px; margin-bottom:16px; }
        .dash-charts-row-2 { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:22px; }
        .dash-card {
            background:#fff; border:1px solid #e5e7eb; border-radius:14px; padding:20px;
            box-shadow:0 1px 4px rgba(0,0,0,0.04);
        }
        .dash-card-header { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:18px; }
        .dash-card-title { font-family:'Outfit',sans-serif; font-size:14.5px; font-weight:700; color:#111827; }
        .dash-card-sub { font-size:11.5px; color:#9ca3af; margin-top:2px; }
        .dash-chart-tabs { display:flex; background:#f3f4f6; border-radius:8px; padding:3px; gap:3px; }
        .dash-chart-tab {
            padding:4px 13px; border-radius:6px; font-size:11.5px; font-weight:600;
            cursor:pointer; color:#9ca3af; border:none; background:none;
            font-family:'Plus Jakarta Sans',sans-serif; transition:all 0.15s;
        }
        .dash-chart-tab.active { background:#fff; color:#111827; box-shadow:0 1px 4px rgba(0,0,0,0.1); }
        .dash-chart-body    { height:210px; position:relative; }
        .dash-chart-body-sm { height:170px; position:relative; }
        .dash-view-all { font-size:12px; color:#6366f1; text-decoration:none; font-weight:600; flex-shrink:0; }

        /* Bottom row */
        .dash-bottom-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }

        /* Project table */
        .dash-project-row { display:flex; align-items:center; gap:10px; padding:11px 0; border-bottom:1px solid #f3f4f6; }
        .dash-project-row:last-child { border-bottom:none; }
        .dash-proj-dot { width:8px; height:8px; border-radius:50%; flex-shrink:0; }
        .dash-proj-name { flex:1; font-size:13px; font-weight:500; color:#1f2937; }
        .dash-proj-date { font-size:11px; color:#9ca3af; flex-shrink:0; }
        .dash-pill { padding:3px 11px; border-radius:20px; font-size:11px; font-weight:700; flex-shrink:0; }
        .pill-done    { background:#dcfce7; color:#15803d; }
        .pill-active  { background:#fef3c7; color:#b45309; }
        .pill-pending { background:#dbeafe; color:#1d4ed8; }
        .pill-risk    { background:#fee2e2; color:#dc2626; }

        /* Activity */
        .dash-act-item { display:flex; gap:12px; padding:10px 0; border-bottom:1px solid #f3f4f6; }
        .dash-act-item:last-child { border-bottom:none; }
        .dash-act-icon { width:34px; height:34px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-top:1px; }
        .dash-act-text { font-size:12.5px; color:#374151; line-height:1.4; }
        .dash-act-time { font-size:11px; color:#9ca3af; margin-top:2px; }

        /* Modal */
        .dash-modal-overlay {
            position:fixed; inset:0; background:rgba(0,0,0,0.55); backdrop-filter:blur(4px);
            z-index:999; display:none; align-items:center; justify-content:center;
        }
        .dash-modal-overlay.open { display:flex; }
        .dash-modal-box {
            background:#fff; border-radius:18px; padding:32px; width:100%; max-width:400px;
            box-shadow:0 30px 80px rgba(0,0,0,0.2); animation:dashModalIn 0.25s ease;
        }
        @keyframes dashModalIn {
            from { transform:translateY(12px) scale(0.97); opacity:0; }
            to   { transform:translateY(0) scale(1); opacity:1; }
        }
        .dash-modal-icon { width:54px; height:54px; background:#fef3c7; border-radius:14px; display:flex; align-items:center; justify-content:center; margin-bottom:18px; }
        .dash-modal-title { font-family:'Outfit',sans-serif; font-size:19px; font-weight:700; color:#111827; margin-bottom:6px; }
        .dash-modal-desc  { font-size:13.5px; color:#6b7280; margin-bottom:22px; line-height:1.5; }
        .dash-modal-input {
            width:100%; height:44px; padding:0 14px; border:1.5px solid #e5e7eb; border-radius:10px;
            font-family:'Plus Jakarta Sans',sans-serif; font-size:14px; color:#111827; outline:none;
            background:#f9fafb; margin-bottom:10px; transition:border-color 0.18s, box-shadow 0.18s;
        }
        .dash-modal-input:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.12); background:#fff; }
        .dash-modal-error { font-size:12.5px; color:#dc2626; display:none; margin-bottom:8px; }
        .dash-modal-error.show { display:block; }
        .dash-modal-actions { display:flex; gap:10px; margin-top:4px; }
        .dash-btn-primary {
            flex:1; height:42px; background:#111827; color:#fff; border:none; border-radius:9px;
            font-family:'Plus Jakarta Sans',sans-serif; font-size:13.5px; font-weight:700;
            cursor:pointer; transition:background 0.18s;
        }
        .dash-btn-primary:hover { background:#1f2937; }
        .dash-btn-ghost {
            height:42px; padding:0 18px; background:#f3f4f6; color:#6b7280; border:none;
            border-radius:9px; font-family:'Plus Jakarta Sans',sans-serif; font-size:13.5px;
            font-weight:600; cursor:pointer;
        }
        .dash-btn-ghost:hover { background:#e5e7eb; }

        /* Animations */
        @keyframes fadeSlideUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
        .da { animation: fadeSlideUp 0.45s ease both; }
        .da1{animation-delay:.04s} .da2{animation-delay:.08s} .da3{animation-delay:.12s}
        .da4{animation-delay:.16s} .da5{animation-delay:.20s} .da6{animation-delay:.24s}
        .da7{animation-delay:.28s} .da8{animation-delay:.32s}

        /* Responsive */
        @media(max-width:1280px) { .dash-kpi-grid{grid-template-columns:repeat(2,1fr);} .dash-charts-row-1{grid-template-columns:1fr;} }
        @media(max-width:900px)  { .dash-charts-row-2,.dash-bottom-row{grid-template-columns:1fr;} }
        @media(max-width:640px)  { .dash-kpi-grid{grid-template-columns:1fr;} }
    </style>
</head>
<body class="flex flex-col min-h-screen">

<!-- ══════════ NAVBAR (ORIGINAL — UNTOUCHED) ══════════ -->
<nav class="fixed bg-[#1f1f1f] top-0 z-50 w-full shadow">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-white rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                    </svg>
                </button>
                <a href="#" class="flex items-center ms-2 md:me-24">
                    <img src="{{ asset('images/logo.png') }}" class="h-8 me-2" alt="Logo">
                    <span class="self-center text-xl font-extrabold sm:text-2xl whitespace-nowrap text-white">CaliCrane</span>
                </a>
            </div>
            <div class="flex items-center">
                <div class="flex items-center ms-3">
                    <div>
                        <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-8 h-8 rounded-full object-cover"
                                src="{{ Auth::check() && Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('images/uploadprof.png') }}"
                                alt="Profile Photo">
                        </button>
                    </div>
                    <div class="z-50 hidden my-4 text-base list-none divide-y divide-gray-100 rounded-sm shadow-sm bg-white shadow" id="dropdown-user">
                        <div class="flex justify-center items-center p-2">
                            <img class="w-20 h-20 rounded-full shadow-lg object-cover"
                               src="{{ Auth::check() && Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('images/uploadprof.png') }}"
                                alt="Profile Photo">
                        </div>
                        <div class="px-4 py-3 text-center" role="none">
                            <p class="text-sm font-semibold text-gray-900">{{ Auth::check() ? Auth::user()->name ?? 'Guest' : 'Guest' }}</p>
                            <p class="text-sm font-medium text-gray-500 truncate">{{ Auth::check() ? Auth::user()->email ?? 'guest@example.com' : 'guest@example.com' }}</p>
                        </div>
                        <ul class="py-1" role="none">
                            <li><a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a></li>
                            <li><a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- ══════════ SIDEBAR (ORIGINAL — UNTOUCHED) ══════════ -->
<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-72 h-screen pt-20 transition-transform -translate-x-full lg:translate-x-0 bg-black shadow-xl"
    aria-label="Sidebar">
    <div class="h-full px-6 pb-6 overflow-y-auto bg-black">
        <div class="flex justify-center items-center mb-8">
            <h1 class="text-3xl font-extrabold text-white tracking-wide select-none cursor-default">Core 3</h1>
        </div>
        <button id="toggleSidebar" class="absolute -right-5 top-1/2 transform -translate-y-1/2 bg-black text-white rounded-full p-2 shadow hover:bg-black transition z-50">
            <svg id="arrowIcon" class="w-5 h-5 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <ul class="space-y-2 text-sm font-medium text-white">
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center p-3 rounded-lg hover:bg-blue-900 transition">
                    <img src="{{ asset('svg/dashboard.svg') }}" alt="Dashboard Icon" class="w-6 h-6 mr-3">
                    <span class="ml-4">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('billing.invoices.index') }}" class="flex items-center p-3 rounded-lg hover:bg-blue-900 transition">
                    <img src="{{ asset('svg/billing.svg') }}" alt="Billing Icon" class="w-6 h-6 mr-3">
                    <span class="ml-4">Billing & Invoicing</span>
                </a>
            </li>
            <li>
                <a href="{{ route('record.index') }}" class="flex items-center p-3 rounded-lg hover:bg-blue-900 transition">
                    <img src="{{ asset('svg/record.svg') }}" alt="Record Icon" class="w-6 h-6 mr-3" />
                    <span class="ml-4">Record & Payment</span>
                </a>
            </li>
            <li x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center w-full p-3 rounded-lg hover:bg-blue-900 transition focus:outline-none select-none">
                    <img src="{{ asset('svg/schedule.svg') }}" alt="Schedule Icon" class="w-6 h-6 mr-3" />
                    <span class="ml-4 flex-1 min-w-0 break-words whitespace-normal">Schedule Preventive Maintenance</span>
                    <svg :class="{ 'rotate-180': open }" class="w-5 h-5 ml-auto transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="open" x-transition class="pl-10 mt-2 space-y-1 text-sm font-medium text-white overflow-hidden">
                    <li><a href="{{ route('maintenance-sched') }}" class="block p-2 rounded-lg hover:bg-blue-800 transition">Maintenance Schedule</a></li>
                    <li><a href="{{ route('maintenance-dashboard') }}" class="block p-2 rounded-lg hover:bg-blue-800 transition">Maintenance Dashboard</a></li>
                    <li><a href="{{ route('maintenance-history') }}" class="block p-2 rounded-lg hover:bg-blue-800 transition">Maintenance History Log</a></li>
                </ul>
            </li>
            <li x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center w-full p-3 rounded-lg hover:bg-blue-900 transition focus:outline-none select-none">
                    <img src="{{ asset('svg/contract.svg') }}" alt="Contract Icon" class="w-6 h-6 mr-3" />
                    <span class="ml-4 flex-1 min-w-0 break-words whitespace-normal">Contract & Permit Management</span>
                    <svg :class="{ 'rotate-180': open }" class="w-5 h-5 ml-auto transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="open" x-transition class="pl-10 mt-2 space-y-1 text-sm font-medium text-white overflow-hidden">
                    <li><a href="{{ route('contract.management') }}" class="block p-2 rounded-lg hover:bg-blue-800 transition">Manage Contracts</a></li>
                    <li><a href="{{ route('manage-permits') }}" class="block p-2 rounded-lg hover:bg-blue-800 transition">Manage Permits</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('financial-report') }}" class="flex items-center p-3 rounded-lg hover:bg-blue-900 transition">
                    <img src="{{ asset('svg/reporting.svg') }}" alt="Reporting Icon" class="w-6 h-6 mr-3" />
                    <span class="ml-4">Reporting & Analytics</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

<!-- ══════════ MAIN CONTENT (REDESIGNED) ══════════ -->
<div class="flex-1 pt-20 pl-72 pb-16 dash-main">
    <div class="p-6 mt-14">

        <!-- Page Header -->
        <div class="dash-page-header da da1">
            <div>
                <div class="dash-page-title">Dashboard</div>
                <div class="dash-page-sub">Welcome back — here's what's happening today</div>
            </div>
          
        </div>

        <!-- Filter Bar -->
        <div class="dash-filter-bar da da2">
            <div class="dash-filter-group">
                <span class="dash-filter-label">Period</span>
                <select class="dash-filter-select">
                    <option>Monthly</option><option>Quarterly</option><option>Yearly</option>
                </select>
            </div>
            <div class="dash-filter-group">
                <span class="dash-filter-label">Start Date</span>
                <input type="date" class="dash-filter-input" value="2025-01-01">
            </div>
            <div class="dash-filter-group">
                <span class="dash-filter-label">End Date</span>
                <input type="date" class="dash-filter-input" value="2025-06-30">
            </div>
            <div style="flex:0;display:flex;flex-direction:column;gap:5px;">
                <span class="dash-filter-label" style="opacity:0;">.</span>
                <button class="dash-filter-btn">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>
                    Apply Filters
                </button>
            </div>
        </div>

        <!-- KPI Cards -->
        <div class="dash-kpi-grid">
            <!-- Revenue -->
            <a href="{{ route('financial-report') }}" class="dash-kpi-card da da3">
                <div class="dash-kpi-accent" style="background:linear-gradient(90deg,#10b981,#34d399);"></div>
                <div class="dash-kpi-top">
                    <div class="dash-kpi-icon" style="background:#dcfce7;">
                        <svg width="22" height="22" fill="none" stroke="#10b981" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="dash-kpi-badge badge-green">↑ 12.4%</span>
                </div>
                <div class="dash-kpi-label">Total Revenue</div>
                <div class="dash-kpi-value">
                    <span class="conf-wrap">
                        <span class="conf-value blurred">₱{{ number_format($totalRevenue, 2) }}</span>
                        <button class="conf-unlock" onclick="openModal(event)">🔒 Unlock</button>
                    </span>
                </div>
                <div class="dash-kpi-meta">Payment Management</div>
            </a>

            <!-- Collection Rate -->
            <a href="{{ route('financial-report') }}" class="dash-kpi-card da da4">
                <div class="dash-kpi-accent" style="background:linear-gradient(90deg,#6366f1,#818cf8);"></div>
                <div class="dash-kpi-top">
                    <div class="dash-kpi-icon" style="background:#e0e7ff;">
                        <svg width="22" height="22" fill="none" stroke="#6366f1" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V5a2 2 0 012-2h2a2 2 0 012 2v14m-6 0h6"/>
                        </svg>
                    </div>
                    <span class="dash-kpi-badge badge-indigo">↑ 3.1%</span>
                </div>
                <div class="dash-kpi-label">Collection Rate</div>
                <div class="dash-kpi-value">{{ $collectionRatePercent }}%</div>
                <div class="dash-kpi-meta">Payment performance</div>
            </a>

            <!-- Active Contracts -->
            <a href="{{ route('contract.management') }}" class="dash-kpi-card da da5">
                <div class="dash-kpi-accent" style="background:linear-gradient(90deg,#8b5cf6,#a78bfa);"></div>
                <div class="dash-kpi-top">
                    <div class="dash-kpi-icon" style="background:#ede9fe;">
                        <svg width="22" height="22" fill="none" stroke="#8b5cf6" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <span class="dash-kpi-badge badge-gray">Stable</span>
                </div>
                <div class="dash-kpi-label">Active Contracts</div>
                <div class="dash-kpi-value">
                    <span class="conf-wrap">
                        <span class="conf-value blurred">{{ $activeContracts }}</span>
                        <button class="conf-unlock" onclick="openModal(event)">🔒 Unlock</button>
                    </span>
                </div>
                <div class="dash-kpi-meta">Contract Management</div>
            </a>

            <!-- Maintenance -->
            <a href="{{ route('maintenance-dashboard') }}" class="dash-kpi-card da da6">
                <div class="dash-kpi-accent" style="background:linear-gradient(90deg,#f59e0b,#fbbf24);"></div>
                <div class="dash-kpi-top">
                    <div class="dash-kpi-icon" style="background:#fef3c7;">
                        <svg width="22" height="22" fill="none" stroke="#f59e0b" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="dash-kpi-badge badge-red">↓ 1.8%</span>
                </div>
                <div class="dash-kpi-label">Maintenance Completed</div>
                <div class="dash-kpi-value">
                    <span class="conf-wrap">
                        <span class="conf-value blurred">{{ $completedThisMonth }}</span>
                        <button class="conf-unlock" onclick="openModal(event)">🔒 Unlock</button>
                    </span>
                </div>
                <div class="dash-kpi-meta">Completed this month</div>
            </a>
        </div>

        <!-- Charts Row 1 -->
        <div class="dash-charts-row-1 da da7">
            <div class="dash-card">
                <div class="dash-card-header">
                    <div>
                        <div class="dash-card-title">Revenue Trend</div>
                        <div class="dash-card-sub">Financial Intelligence</div>
                    </div>
                    <div class="dash-chart-tabs">
                        <button class="dash-chart-tab active" onclick="switchRev(this,'6m')">6M</button>
                        <button class="dash-chart-tab" onclick="switchRev(this,'1y')">1Y</button>
                    </div>
                </div>
                <div class="dash-chart-body"><canvas id="revenueChart"></canvas></div>
            </div>
            <div class="dash-card">
                <div class="dash-card-header">
                    <div>
                        <div class="dash-card-title">Payment Methods</div>
                        <div class="dash-card-sub">Distribution by type</div>
                    </div>
                </div>
                <div class="dash-chart-body-sm"><canvas id="paymentChart"></canvas></div>
            </div>
        </div>

        <!-- Charts Row 2 -->
        <div class="dash-charts-row-2 da da8">
            <div class="dash-card">
                <div class="dash-card-header">
                    <div>
                        <div class="dash-card-title">Equipment Availability Rate</div>
                        <div class="dash-card-sub">Maintenance Scheduling — weekly %</div>
                    </div>
                    <div style="display:flex;gap:12px;align-items:center;">
                        <span style="font-size:11px;color:#9ca3af;display:flex;align-items:center;gap:5px;"><span style="width:8px;height:8px;border-radius:50%;background:#6366f1;display:inline-block;"></span>Available</span>
                        <span style="font-size:11px;color:#9ca3af;display:flex;align-items:center;gap:5px;"><span style="width:8px;height:8px;border-radius:50%;background:#fca5a5;display:inline-block;"></span>Maint.</span>
                    </div>
                </div>
                <div class="dash-chart-body-sm"><canvas id="maintenanceChart"></canvas></div>
            </div>
            <div class="dash-card">
                <div class="dash-card-header">
                    <div>
                        <div class="dash-card-title">Invoice Status</div>
                        <div class="dash-card-sub">Paid vs outstanding per month</div>
                    </div>
                </div>
                <div class="dash-chart-body-sm"><canvas id="invoiceChart"></canvas></div>
            </div>
        </div>

    
    </div>
</div>

<!-- ══════════ PASSWORD MODAL ══════════ -->
<div class="dash-modal-overlay" id="dashModal">
    <div class="dash-modal-box">
        <div class="dash-modal-icon">
            <svg width="26" height="26" fill="none" stroke="#f59e0b" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <div class="dash-modal-title">Security Verification</div>
        <div class="dash-modal-desc">Enter your administrator password to reveal confidential data.</div>
        <input type="password" class="dash-modal-input" id="dashPwdInput" placeholder="Enter password" autocomplete="off">
        <div class="dash-modal-error" id="dashPwdError">Incorrect password. Please try again.</div>
        <div class="dash-modal-actions">
            <button class="dash-btn-primary" onclick="verifyDashPwd()">Verify Access</button>
            <button class="dash-btn-ghost" onclick="closeModal()">Cancel</button>
        </div>
    </div>
</div>

<!-- ══════════ FOOTER (ORIGINAL — UNTOUCHED) ══════════ -->
<footer class="bg-[#1f1f1f] text-white py-3 px-4 shadow-lg flex justify-center items-center">
    <div class="flex gap-5 items-center">
        <img class="rounded-full w-10 h-10" src="{{ asset('images/logo.png') }}" alt="">
        <p class="text-sm text-gray-300">© 2025 CaliCrane All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
<script>
// Password
const CORRECT_PWD = 'admin123';
function openModal(e) { e.preventDefault(); e.stopPropagation(); showModal(); }
function showModal() {
    document.getElementById('dashModal').classList.add('open');
    setTimeout(() => document.getElementById('dashPwdInput').focus(), 50);
    document.getElementById('dashPwdError').classList.remove('show');
    document.getElementById('dashPwdInput').value = '';
}
function closeModal() { document.getElementById('dashModal').classList.remove('open'); }
document.getElementById('dashModal').addEventListener('click', e => { if (e.target === document.getElementById('dashModal')) closeModal(); });
document.getElementById('dashPwdInput').addEventListener('keydown', e => { if (e.key === 'Enter') verifyDashPwd(); });
function verifyDashPwd() {
    if (document.getElementById('dashPwdInput').value === CORRECT_PWD) {
        closeModal();
        document.querySelectorAll('.conf-value').forEach(el => el.classList.remove('blurred'));
        document.querySelectorAll('.conf-unlock').forEach(el => el.classList.add('hidden'));
    } else {
        document.getElementById('dashPwdError').classList.add('show');
        document.getElementById('dashPwdInput').value = '';
        document.getElementById('dashPwdInput').focus();
    }
}

// Charts
const cf = { family: "'Plus Jakarta Sans', sans-serif" };
const tt = { backgroundColor:'#111827', titleColor:'#9ca3af', bodyColor:'#fff', padding:12, cornerRadius:8, titleFont:{...cf,size:11}, bodyFont:{...cf,size:13,weight:'600'} };

// Revenue
const revCtx = document.getElementById('revenueChart').getContext('2d');
const revG = revCtx.createLinearGradient(0,0,0,210);
revG.addColorStop(0,'rgba(99,102,241,0.18)'); revG.addColorStop(1,'rgba(99,102,241,0)');
const revData = {
    '6m':{ labels:['Jan','Feb','Mar','Apr','May','Jun'], data:[120000,190000,150000,220000,180000,250000] },
    '1y':{ labels:['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'], data:[95000,120000,190000,150000,220000,180000,250000,210000,195000,270000,230000,300000] }
};
const revenueChart = new Chart(revCtx, {
    type:'line',
    data:{ labels:revData['6m'].labels, datasets:[{ label:'Revenue (₱)', data:revData['6m'].data, borderColor:'#6366f1', backgroundColor:revG, borderWidth:2.5, pointBackgroundColor:'#6366f1', pointBorderColor:'#fff', pointBorderWidth:2, pointRadius:5, pointHoverRadius:7, fill:true, tension:0.4 }] },
    options:{ responsive:true, maintainAspectRatio:false, plugins:{ legend:{display:false}, tooltip:{...tt, callbacks:{label:ctx=>'₱'+ctx.parsed.y.toLocaleString()}} }, scales:{ y:{grid:{color:'#f3f4f6'},border:{display:false},ticks:{font:cf,color:'#9ca3af',callback:v=>'₱'+(v/1000).toFixed(0)+'K'}}, x:{grid:{display:false},border:{display:false},ticks:{font:cf,color:'#9ca3af'}} } }
});
function switchRev(btn, key) {
    btn.closest('.dash-chart-tabs').querySelectorAll('.dash-chart-tab').forEach(t=>t.classList.remove('active'));
    btn.classList.add('active');
    revenueChart.data.labels = revData[key].labels;
    revenueChart.data.datasets[0].data = revData[key].data;
    revenueChart.update();
}

// Payment Donut
new Chart(document.getElementById('paymentChart'),{
    type:'doughnut',
    data:{ labels:['Bank Transfer','Cash','GCash','Check'], datasets:[{data:[45,25,20,10],backgroundColor:['#6366f1','#10b981','#f59e0b','#ef4444'],borderWidth:0,hoverOffset:6}] },
    options:{ responsive:true,maintainAspectRatio:false, plugins:{ legend:{position:'bottom',labels:{font:cf,color:'#6b7280',padding:12,usePointStyle:true,pointStyle:'circle',boxWidth:8}}, tooltip:{...tt} }, cutout:'68%' }
});

// Maintenance
const mCtx = document.getElementById('maintenanceChart').getContext('2d');
const mG = mCtx.createLinearGradient(0,0,0,170);
mG.addColorStop(0,'#818cf8'); mG.addColorStop(1,'#6366f1');
new Chart(mCtx,{
    type:'bar',
    data:{ labels:['Week 1','Week 2','Week 3','Week 4'], datasets:[{label:'Available (%)',data:[85,92,78,88],backgroundColor:mG,borderRadius:5,borderSkipped:false},{label:'Maintenance (%)',data:[15,8,22,12],backgroundColor:'rgba(252,165,165,0.45)',borderRadius:5,borderSkipped:false}] },
    options:{ responsive:true,maintainAspectRatio:false, plugins:{legend:{display:false},tooltip:{...tt}}, scales:{ y:{stacked:true,max:100,grid:{color:'#f3f4f6'},border:{display:false},ticks:{font:cf,color:'#9ca3af',callback:v=>v+'%'}}, x:{stacked:true,grid:{display:false},border:{display:false},ticks:{font:cf,color:'#9ca3af'}} } }
});

// Invoice
new Chart(document.getElementById('invoiceChart'),{
    type:'bar',
    data:{ labels:['Jan','Feb','Mar','Apr','May','Jun'], datasets:[{label:'Paid',data:[18,22,15,28,20,30],backgroundColor:'#10b981',borderRadius:5,borderSkipped:false},{label:'Outstanding',data:[5,3,8,4,6,3],backgroundColor:'rgba(239,68,68,0.22)',borderRadius:5,borderSkipped:false}] },
    options:{ responsive:true,maintainAspectRatio:false, plugins:{ legend:{position:'top',align:'end',labels:{font:cf,color:'#6b7280',padding:12,usePointStyle:true,pointStyle:'circle',boxWidth:8}}, tooltip:{...tt} }, scales:{ y:{grid:{color:'#f3f4f6'},border:{display:false},ticks:{font:cf,color:'#9ca3af'}}, x:{grid:{display:false},border:{display:false},ticks:{font:cf,color:'#9ca3af'}} } }
});
</script>

</body>
</html>