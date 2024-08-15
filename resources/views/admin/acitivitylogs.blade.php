@extends('admin.layout.base')
@section('title', $title)
@section('style')
@stop
@section('content')
    <div class="page-content">
        <div class="container-fluid mt-2 mb-3">
            <div class="row">
                <div class="col-12">
                    {{-- Date Filter Form --}}
                    <form action="" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="date" name="from_date" value="{{ $fromDate }}" class="form-control" placeholder="From Date">
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="to_date" value="{{ $toDate }}" class="form-control" placeholder="To Date">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>

                    {{-- Activity Logs --}}
                    <div class="list-group">
                        @foreach($activityLogs as $log)
                            <a href="javascript:void(0);" class="list-group-item list-group-item-action mb-2 p-4">
                                <div class="float-end fw-bold fs-18">
                                    {{ ucfirst($log->action) }}
                                </div>
                                <div class="d-flex mb-2 align-items-center">
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="list-title fs-15 mb-1">
                                            <strong>User:</strong>
                                            {{ $log->user->first_name }} {{ $log->user->last_name }}
                                        </h5>
                                        <p class="list-text mb-0 fs-12">{{ $log->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <p class="list-text mb-0">
                                    @if(is_array($log->details))
                                        @foreach($log->details as $key => $value)
                                            <strong>{{ ucfirst($key) }}:</strong>
                                            @if(is_array($value))
                                                {{ implode(', ', $value) }}
                                            @else
                                                {{ htmlspecialchars($value) }}
                                            @endif
                                            <br>
                                        @endforeach
                                    @else
                                        {{ htmlspecialchars($log->details) }}
                                    @endif
                                </p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
