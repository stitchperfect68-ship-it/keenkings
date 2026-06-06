@extends('admin.layouts.app')
@section('title', 'Enquiries')
@section('breadcrumb', 'Enquiries')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Contact Enquiries</h1>
        <p class="page-sub">{{ $enquiries->total() }} total enquiries</p>
    </div>
    <div class="filter-pills">
        @foreach(['','new','read','replied','archived'] as $status)
        <a href="{{ route('admin.enquiries.index', $status ? ['status' => $status] : []) }}"
           class="filter-pill {{ request('status', '') === $status ? 'active' : '' }}">
            {{ $status ?: 'All' }}
        </a>
        @endforeach
    </div>
</div>

<div class="table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Service</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($enquiries as $enq)
            <tr class="{{ $enq->status === 'new' ? 'row-unread' : '' }}">
                <td>
                    <div class="table-name-cell">
                        <div class="tbl-avatar">{{ strtoupper(substr($enq->name,0,1)) }}</div>
                        <span>{{ $enq->name }}</span>
                    </div>
                </td>
                <td>{{ $enq->email }}</td>
                <td>{{ $enq->service ?? '—' }}</td>
                <td><span class="enq-status status-{{ $enq->status }}">{{ $enq->status }}</span></td>
                <td>{{ $enq->created_at->format('d M Y') }}</td>
                <td>
                    <div class="table-actions">
                        <a href="{{ route('admin.enquiries.show', $enq) }}" class="action-btn">
                            <i data-feather="eye"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.enquiries.destroy', $enq) }}"
                              onsubmit="return confirm('Delete this enquiry?')">
                            @csrf @method('DELETE')
                            <button class="action-btn danger"><i data-feather="trash-2"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="empty-row">No enquiries found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="pagination-wrap">{{ $enquiries->withQueryString()->links('admin.components.pagination') }}</div>
@endsection
