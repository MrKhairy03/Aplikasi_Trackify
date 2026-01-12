@extends('templates.mastertemplate')

@section('title', 'Dashboard')

@section('contents')
    <div class="d-flex mb-4">
        <div class="dropdown mr-2">
            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="actionDropdown" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                {{ request('action') ? ucfirst(str_replace('_', ' ', request('action'))) : 'Semua Action' }}
            </button>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="actionDropdown">
                <a class="dropdown-item"
                    href="{{ route('dashboard', array_merge(request()->query(), ['action' => null])) }}">
                    Semua Action
                </a>

                @foreach ($actions as $act)
                    <a class="dropdown-item"
                        href="{{ route('dashboard', array_merge(request()->query(), ['action' => $act])) }}">
                        {{ ucfirst(str_replace('_', ' ', $act)) }}
                    </a>
                @endforeach
            </div>
        </div>

        <form class="form-inline" method="GET" action="{{ route('dashboard') }}">
            @if (request('action'))
                <input type="hidden" name="action" value="{{ request('action') }}">
            @endif

            <div class="form-group mr-2">
                <input type="date" name="from" class="form-control form-control-sm" value="{{ request('from') }}">
            </div>

            <div class="form-group mr-2">
                <input type="date" name="to" class="form-control form-control-sm" value="{{ request('to') }}">
            </div>

            <button class="btn btn-primary btn-sm" type="submit">
                Terapkan
            </button>
        </form>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Activities
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalActivities) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Jumlah User
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalActiveUsers) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Jenis Action
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalActions }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-random fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Aktivitas Terbanyak
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($topUserActivities ?? 0) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row align-items-stretch">
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Total Activity per Hari
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="activityAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Top 5 User Paling Aktif
                    </h6>
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="chart-pie mt-3" style="height: 320px;">
                        <canvas id="activityPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Aktivitas Berdasarkan Action (Top 3)
                    </h6>
                </div>

                <div class="card-body">
                    @php
                        $colors = ['bg-primary', 'bg-success', 'bg-info'];
                    @endphp

                    @forelse ($topActions as $index => $act)
                        @php
                            $percent = $totalForProgress > 0 ? round(($act->total / $totalForProgress) * 100) : 0;
                        @endphp

                        <h4 class="small font-weight-bold">
                            {{ ucfirst(str_replace('_', ' ', $act->action)) }}
                            <span class="float-right">
                                {{ number_format($act->total) }} ({{ $percent }}%)
                            </span>
                        </h4>
                        <div class="progress mb-4">
                            <div class="progress-bar {{ $colors[$index] ?? 'bg-secondary' }}" role="progressbar"
                                style="width: {{ $percent }}%" aria-valuenow="{{ $percent }}" aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">
                            Tidak ada data aktivitas.
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        window.activityAreaLabels = @json($activityPerDay->pluck('date'));
        window.activityAreaData = @json($activityPerDay->pluck('total'));

        window.pieLabels = @json($topUsers->pluck('name'));
        window.pieData = @json($topUsers->pluck('total'));
    </script>
@endsection

@section('jssection')
    @include('environments.dashboard.js')
@endsection
