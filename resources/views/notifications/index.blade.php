@extends('layouts.admin')

@section('title', 'Notifications')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-bell fa-fw mr-2"></i>Notifications
    </h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Your Notifications</h6>
        @if($notifications->isNotEmpty())
            <form action="{{ route('notifications.readAll') }}" method="POST">
                @csrf
                <button class="btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-check-double fa-sm text-white-50 mr-1"></i> Mark all as read
                </button>
            </form>
        @endif
    </div>
    <div class="card-body p-0">
        <div class="list-group list-group-flush">
            @forelse($notifications as $notification)
                <div class="list-group-item list-group-item-action flex-column align-items-start {{ $notification->read_at ? 'bg-light' : '' }}">
                    <div class="d-flex w-100 justify-content-between">
                        <div class="mb-1">
                            @if(isset($notification->data['url']))
                                <a href="{{ route('notifications.redirect', ['id' => $notification->id]) }}" 
                                   class="text-decoration-none {{ $notification->read_at ? 'text-secondary' : 'text-primary font-weight-bold' }}">
                                   <i class="fas fa-circle fa-xs mr-2 {{ $notification->read_at ? 'text-gray-400' : 'text-primary' }}"></i>
                                   {!! $notification->data['message'] !!}
                                </a>
                            @else
                                <span class="{{ $notification->read_at ? 'text-secondary' : 'text-dark font-weight-bold' }}">
                                    <i class="fas fa-circle fa-xs mr-2 {{ $notification->read_at ? 'text-gray-400' : 'text-primary' }}"></i>
                                    {!! $notification->data['message'] !!}
                                </span>
                            @endif
                        </div>
                        <small class="text-muted ml-2 text-nowrap">
                            <i class="far fa-clock mr-1"></i>
                            {{ $notification->created_at->diffForHumans() }}
                        </small>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    <div class="mb-3">
                        <span class="fa-stack fa-2x">
                            <i class="fas fa-circle fa-stack-2x text-gray-200"></i>
                            <i class="fas fa-bell-slash fa-stack-1x text-gray-400"></i>
                        </span>
                    </div>
                    <p class="mb-0">No notifications found.</p>
                </div>
            @endforelse
        </div>
    </div>
    
    @if(method_exists($notifications, 'links'))
        <div class="card-footer">
            {{ $notifications->links() }}
        </div>
    @endif
</div>

@endsection