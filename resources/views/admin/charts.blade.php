@extends('layouts.app')
@section('title', 'Charts & Analytics')

@section('content')
<div class="page-header">
    <h2>Charts & Analytics</h2>
    <p>Visual overview of your application's growth.</p>
</div>

{{-- Stats Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card bg-white">
            <div class="stat-icon" style="background:#ede9fe;">&#128101;</div>
            <div class="stat-value">{{ $totalUsers }}</div>
            <div class="stat-label">Total Users</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card bg-white">
            <div class="stat-icon" style="background:#ecfdf5;">&#128221;</div>
            <div class="stat-value">{{ $totalPosts }}</div>
            <div class="stat-label">Total Posts</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card bg-white">
            <div class="stat-icon" style="background:#fef3c7;">&#128172;</div>
            <div class="stat-value">{{ $totalComments }}</div>
            <div class="stat-label">Total Comments</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card bg-white">
            <div class="stat-icon" style="background:#fef2f2;">&#128683;</div>
            <div class="stat-value">{{ $bannedUsers }}</div>
            <div class="stat-label">Banned Users</div>
        </div>
    </div>
</div>

{{-- Charts --}}
<div class="row g-4">
    <div class="col-md-6">
        <div class="card-custom">
            <div class="card-body">
                <h5 style="font-weight:700;color:#111827;margin-bottom:1.5rem;">
                    User Registrations (Last 6 Months)
                </h5>
                <canvas id="userChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card-custom">
            <div class="card-body">
                <h5 style="font-weight:700;color:#111827;margin-bottom:1.5rem;">
                    Posts Created (Last 6 Months)
                </h5>
                <canvas id="postChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const userLabels = @json($userStats->pluck('month'));
const userData   = @json($userStats->pluck('count'));
const postLabels = @json($postStats->pluck('month'));
const postData   = @json($postStats->pluck('count'));

new Chart(document.getElementById('userChart'), {
    type: 'bar',
    data: {
        labels: userLabels,
        datasets: [{
            label: 'New Users',
            data: userData,
            backgroundColor: 'rgba(79, 70, 229, 0.8)',
            borderRadius: 8,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});

new Chart(document.getElementById('postChart'), {
    type: 'line',
    data: {
        labels: postLabels,
        datasets: [{
            label: 'New Posts',
            data: postData,
            borderColor: '#4f46e5',
            backgroundColor: 'rgba(79, 70, 229, 0.1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#4f46e5',
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});
</script>
@endsection