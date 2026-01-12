@extends('templates.mastertemplate')

@section('title', 'Data Aktivitas')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                Data Aktivitas Pengguna
            </h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width:60px;">No</th>
                            <th>Nama User</th>
                            <th>Email</th>
                            <th>Action</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($activities as $index => $activity)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $activity->user?->name ?? '-' }}</td>
                                <td class="text-muted">
                                    {{ $activity->user?->email ?? '-' }}
                                </td>
                                <td>
                                    <span class="badge badge-info">
                                        {{ $activity->action }}
                                    </span>
                                </td>
                                <td>
                                    {{ $activity->created_at->translatedFormat('d F Y, H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Data aktivitas belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('jssection')
    @include('environments.activities.js')
@endsection
