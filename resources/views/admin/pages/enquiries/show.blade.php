@extends('admin.layouts.app')
@section('title', 'Enquiry from ' . $enquiry->name)
@section('breadcrumb')
    <a href="{{ route('admin.enquiries.index') }}">Enquiries</a>
    <i data-feather="chevron-right"></i>{{ $enquiry->name }}
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Enquiry #{{ $enquiry->id }}</h1>
    <a href="{{ route('admin.enquiries.index') }}" class="btn btn-ghost">
        <i data-feather="arrow-left"></i> Back
    </a>
</div>

<div class="enquiry-detail-grid">
    <div class="enquiry-message-card">
        <div class="enq-detail-header">
            <div class="enq-avatar large">{{ strtoupper(substr($enquiry->name,0,1)) }}</div>
            <div>
                <h3>{{ $enquiry->name }}</h3>
                <a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a>
                @if($enquiry->phone)
                <a href="tel:{{ $enquiry->phone }}">{{ $enquiry->phone }}</a>
                @endif
            </div>
        </div>
        <div class="enq-message">
            <h4>Message</h4>
            <p>{{ $enquiry->message }}</p>
        </div>
        <div class="enq-detail-meta">
            <span><i data-feather="briefcase"></i> {{ $enquiry->service ?? 'No service specified' }}</span>
            <span><i data-feather="clock"></i> {{ $enquiry->created_at->format('d M Y \a\t H:i') }}</span>
        </div>
    </div>

    <div class="enquiry-sidebar-card">
        <h4>Status</h4>
        <form method="POST" action="{{ route('admin.enquiries.status', $enquiry) }}">
            @csrf @method('PATCH')
            <select name="status" onchange="this.form.submit()" class="filter-select">
                @foreach(['new','read','replied','archived'] as $s)
                <option value="{{ $s }}" {{ $enquiry->status === $s ? 'selected' : '' }}>
                    {{ ucfirst($s) }}
                </option>
                @endforeach
            </select>
        </form>

        <div class="enq-quick-reply">
            <a href="mailto:{{ $enquiry->email }}?subject=Re: Keenkings Media Enquiry" class="btn btn-primary" style="width:100%; margin-top:1.5rem">
                <i data-feather="mail"></i> Reply via Email
            </a>
        </div>

        <form method="POST" action="{{ route('admin.enquiries.destroy', $enquiry) }}"
              onsubmit="return confirm('Permanently delete this enquiry?')"
              style="margin-top:1rem">
            @csrf @method('DELETE')
            <button class="btn btn-ghost" style="width:100%; color:#ff6b6b; border-color:#ff6b6b">
                <i data-feather="trash-2"></i> Delete Enquiry
            </button>
        </form>
    </div>
</div>
@endsection
