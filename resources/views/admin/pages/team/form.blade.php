@extends('admin.layouts.app')
@section('title', isset($member) ? 'Edit Team Member' : 'Add Team Member')
@section('breadcrumb')
    <a href="{{ route('admin.team.index') }}">Our Team</a>
    <i data-feather="chevron-right"></i>
    {{ isset($member) ? 'Edit' : 'Add Member' }}
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ isset($member) ? 'Edit Team Member' : 'Add Team Member' }}</h1>
</div>

<div class="form-layout">
    <form method="POST"
          action="{{ isset($member) ? route('admin.team.update', $member) : route('admin.team.store') }}"
          enctype="multipart/form-data"
          class="admin-form">
        @csrf
        @if(isset($member)) @method('PUT') @endif

        @if($errors->any())
        <div class="alert alert-error" style="margin-bottom:20px;">
            <i data-feather="alert-circle"></i>
            <ul style="margin:0 0 0 16px;padding:0;">
                @foreach($errors->all() as $e)
                <li style="font-size:13px;">{{ $e }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="user"></i> Member Details</h3>

            <div class="form-row">
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="name"
                           value="{{ old('name', $member->name ?? '') }}"
                           required maxlength="100" placeholder="e.g. George Mwansa">
                    @error('name')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Role / Position</label>
                    <input type="text" name="role"
                           value="{{ old('role', $member->role ?? '') }}"
                           maxlength="100" placeholder="e.g. Lead Photographer">
                </div>
            </div>

            <div class="form-group">
                <label>Bio <small style="opacity:.6;">(short description)</small></label>
                <textarea name="bio" rows="3"
                          placeholder="A brief description of this team member...">{{ old('bio', $member->bio ?? '') }}</textarea>
            </div>
        </div>

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="image"></i> Photo</h3>

            @if(isset($member) && $member->image_url)
            <div style="margin-bottom:16px;">
                <img src="{{ $member->image_url }}" alt="{{ $member->name }}"
                     style="width:100px;height:100px;border-radius:50%;object-fit:cover;border:2px solid var(--border);">
                <p style="font-size:12px;opacity:.6;margin-top:6px;">Current photo — upload a new file to replace it.</p>
            </div>
            @endif

            <div class="form-row">
                <div class="form-group">
                    <label>Upload Photo</label>
                    <input type="file" name="image_file" accept="image/*">
                    <small style="opacity:.6;">JPG, PNG or WebP · max 3 MB</small>
                </div>
                <div class="form-group">
                    <label>Or Photo URL</label>
                    <input type="text" name="image_url"
                           value="{{ old('image_url', $member->image_url ?? '') }}"
                           placeholder="https://...">
                </div>
            </div>
        </div>

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="settings"></i> Options</h3>
            <div class="form-row">
                <div class="form-group">
                    <label>Sort Order <small style="opacity:.6;">(lower = first)</small></label>
                    <input type="number" name="sort_order" min="0"
                           value="{{ old('sort_order', $member->sort_order ?? 0) }}">
                </div>
                <div class="form-group" style="align-self:flex-end;">
                    <label class="toggle-label">
                        <input type="hidden"   name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $member->is_active ?? true) ? 'checked' : '' }}>
                        <span class="toggle-switch"></span>
                        Show on website
                    </label>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.team.index') }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i data-feather="save"></i>
                {{ isset($member) ? 'Update Member' : 'Add Member' }}
            </button>
        </div>
    </form>
</div>
@endsection
