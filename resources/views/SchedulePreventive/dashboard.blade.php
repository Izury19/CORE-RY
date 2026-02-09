@extends('layouts.app')

@section('content')
<div class="p-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Maintenance Dashboard</h1>
            <p class="text-gray-600 mt-1">Real-time equipment health and maintenance status</p>
        </div>
        <div class="flex items-center space-x-3">
            <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                🟢 System Operational
            </div>
            <div class="text-sm text-gray-500">
                Last updated: {{ now()->format('M d, Y H:i') }}
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <!-- High Risk -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 text-red-600">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.195 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">High Risk Equipment</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $highRiskCount }}</p>
                    <p class="text-xs text-red-600 mt-1">AI Risk Score ≥ 80%</p>
                </div>
            </div>
        </div>

        <!-- Medium Risk -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 text-yellow-600">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6 3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Medium Risk Equipment</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $mediumRiskCount }}</p>
                    <p class="text-xs text-yellow-600 mt-1">AI Risk Score 60-79%</p>
                </div>
            </div>
        </div>

        <!-- Low Risk -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 text-green-600">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Low Risk Equipment</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $lowRiskCount }}</p>
                    <p class="text-xs text-green-600 mt-1">AI Risk Score < 60%</p>
                </div>
            </div>
        </div>

        <!-- Total Schedules -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 text-blue-600">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Schedules</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalSchedules }}</p>
                    <p class="text-xs text-gray-500 mt-1">All maintenance schedules</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Upcoming Maintenance -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 mr-2 text-blue-600">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-6 8h10M8 19l4-4H6a2 2 0 01-2-2V7a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2h-2l-4 4v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-6a2 2 0 012-2h8a2 2 0 012 2v6a2 2 0 01-2 2z" />
                        </svg>
                        Upcoming Maintenance (Next 7 Days)
                    </h2>
                </div>
                
                @if($upcomingMaintenance->count() > 0)
                    <div class="space-y-4">
                        @foreach($upcomingMaintenance as $schedule)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <span class="font-medium text-gray-900">{{ $schedule->equipment_name }}</span>
                                        <span class="ml-2 px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 rounded">
                                            {{ $schedule->maintenanceType->name ?? 'N/A' }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('M d, Y') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        AI Risk: {{ number_format($schedule->ai_risk_score * 100, 0) }}%
                                    </span>
                                    <p class="text-xs text-gray-500 mt-1">
                                        @php
                                        $scheduledDate = \Carbon\Carbon::parse($schedule->scheduled_date);
                                        $daysLeft = $scheduledDate->isFuture() 
                                            ? max(1, round($scheduledDate->diffInDays(now())))
                                            : 0;
                                        @endphp
                                        {{ $daysLeft }} {{ $daysLeft == 1 ? 'day' : 'days' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-16 h-16 mx-auto mb-4 text-gray-300">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-lg font-medium">No upcoming maintenance scheduled</p>
                        <p class="mt-2">Create your first maintenance schedule to get started.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Notifications -->
        <div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 mr-2 text-blue-600">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        Recent Notifications
                    </h2>
                </div>
                
                <div class="space-y-4">
                    @foreach($recentNotifications as $notif)
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="ml-3 flex-1">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                        @if($notif->notification_type === 'upcoming') bg-green-100 text-green-800
                                        @elseif($notif->notification_type === 'overdue') bg-red-100 text-red-800
                                        @else bg-blue-100 text-blue-800 @endif">
                                        {{ ucfirst($notif->notification_type) }}
                                    </span>
                                    <span class="ml-2 text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($notif->created_at)->format('H:i') }}
                                    </span>
                                </div>
                                <p class="text-sm font-medium text-gray-900 mt-1">
                                    @if($notif->notification_type === 'upcoming')
                                        Maintenance for {{ $notif->equipment_name }}
                                    @else
                                        {{ $notif->message }}
                                    @endif
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ \Carbon\Carbon::parse($notif->scheduled_date)->format('M d') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                    
                    @if($recentNotifications->isEmpty())
                        <div class="text-center py-8 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-12 h-12 mx-auto mb-4 text-gray-300">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <p>No notifications yet</p>
                            <p class="text-xs mt-1">Maintenance notifications appear here when schedules are created or completed.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Performance -->
    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Monthly Performance</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <p class="text-2xl font-bold text-green-600">{{ $completedThisMonth }}</p>
                <p class="text-sm text-gray-600 mt-1">Completed This Month</p>
                <p class="text-xs text-green-600 mt-1">✓ On track</p>
            </div>
            <div class="text-center p-4 bg-blue-50 rounded-lg">
                <p class="text-2xl font-bold text-blue-600">{{ $totalSchedules }}</p>
                <p class="text-sm text-gray-600 mt-1">Total Schedules</p>
                <p class="text-xs text-blue-600 mt-1">Active & completed</p>
            </div>
            <div class="text-center p-4 bg-purple-50 rounded-lg">
                <p class="text-2xl font-bold text-purple-600">
                    @if($totalSchedules > 0)
                        {{ round(($totalSchedules - $overdueCount) / $totalSchedules * 100) }}%
                    @else
                        100%
                    @endif
                </p>
                <p class="text-sm text-gray-600 mt-1">On-Time Completion</p>
                <p class="text-xs text-purple-600 mt-1">Target: 95%</p>
            </div>
        </div>
    </div>
</div>
@endsection