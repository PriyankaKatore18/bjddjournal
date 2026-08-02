@extends('admin.layouts.app')

@section('title', isset($journalTeam) ? 'Edit Team Member' : 'Add Team Member')
@section('content')

<div class="d-flex justify-content-center">
    <div style="width:100%; max-width:1000px;">
        <h4 class="mb-4 text-center" style="color:#00004d; font-weight:600;">{{ isset($journalTeam) ? 'Edit' : 'Add New' }} Team Member</h4>

        <form action="{{ isset($journalTeam) ? route('admin.journal-team.update', $journalTeam->id) : route('admin.journal-team.store') }}" method="POST" enctype="multipart/form-data"
              style="background:#ffffff; padding:30px; border-radius:10px; box-shadow:0px 4px 12px rgba(0,0,0,0.15);">
            @csrf
            @if(isset($journalTeam))
                @method('PUT')
            @endif
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Type *</label>
                    <select name="type" class="form-control" required>
                        <option value="chief_editor" {{ (old('type', $journalTeam->type ?? '') == 'chief_editor') ? 'selected' : '' }}>Chief Editor</option>
                        <option value="editor" {{ (old('type', $journalTeam->type ?? '') == 'editor') ? 'selected' : '' }}>Editor</option>
                        <option value="reviewer" {{ (old('type', $journalTeam->type ?? '') == 'reviewer') ? 'selected' : '' }}>Reviewer</option>
                    </select>
                    @error('type')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $journalTeam->name ?? '') }}" required>
                    @error('name')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Position *</label>
                    <input type="text" name="position" class="form-control" value="{{ old('position', $journalTeam->position ?? '') }}" required>
                    @error('position')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Department *</label>
                    <input type="text" name="department" class="form-control" value="{{ old('department', $journalTeam->department ?? '') }}" required>
                    @error('department')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Institution *</label>
                    <input type="text" name="institution" class="form-control" value="{{ old('institution', $journalTeam->institution ?? '') }}" required>
                    @error('institution')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Email *</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $journalTeam->email ?? '') }}" required>
                    @error('email')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Phone</label>
                    <input type="text" name="phone" class="form-control" 
                           value="{{ old('phone', $journalTeam->phone ?? '') }}"
                           pattern="[0-9]{10}" 
                           title="Please enter exactly 10 digits (numbers only)"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)">
                    <div class="form-text">Enter 10-digit phone number (numbers only)</div>
                    @error('phone')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Qualification</label>
                    <input type="text" name="qualification" class="form-control" value="{{ old('qualification', $journalTeam->qualification ?? '') }}">
                    @error('qualification')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Photo</label>
                    <input type="file" name="photo" class="form-control" accept="image/*">
                    <div class="form-text">Upload a profile photo (JPG, PNG, GIF, max 2MB)</div>
                    @error('photo')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                    
                    @if(isset($journalTeam) && $journalTeam->hasPhoto())
                        <div class="mt-2">
                            <img src="{{ $journalTeam->photo_url }}" alt="{{ $journalTeam->name }}" style="max-width: 100px; max-height: 100px; border-radius: 5px;">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="remove_photo" id="remove_photo">
                                <label class="form-check-label" for="remove_photo">
                                    Remove current photo
                                </label>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Profile Link</label>
                    <input type="url" name="link" class="form-control" value="{{ old('link', $journalTeam->link ?? '') }}" placeholder="https://example.com/profile">
                    <div class="form-text">Enter a URL to personal or professional profile</div>
                    @error('link')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-semibold">Address</label>
                <textarea name="address" class="form-control" rows="3">{{ old('address', $journalTeam->address ?? '') }}</textarea>
                @error('address')<div class="text-danger mt-1">{{ $message }}</div>@enderror
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Order</label>
                    <input type="number" name="order" class="form-control" value="{{ old('order', $journalTeam->order ?? 0) }}">
                    @error('order')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="is_active" class="form-control">
                        <option value="1" {{ (old('is_active', $journalTeam->is_active ?? true) ? 'selected' : '') }}>Active</option>
                        <option value="0" {{ (!old('is_active', $journalTeam->is_active ?? true) ? 'selected' : '') }}>Inactive</option>
                    </select>
                    @error('is_active')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                </div>
            </div>
            
            {{-- Buttons --}}
            <div class="d-flex gap-2 justify-content-center mt-4">
                <button type="submit" class="btn" style="background-color:#00004d; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">Save</button>
                <a href="{{ route('admin.journal-team.index') }}" class="btn" style="background-color:#cc7a00; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const phoneInput = document.querySelector('input[name="phone"]');
    
    phoneInput.addEventListener('input', function(e) {
        // Remove any non-digit characters
        this.value = this.value.replace(/[^0-9]/g, '');
        
        // Limit to 10 digits
        if (this.value.length > 10) {
            this.value = this.value.slice(0, 10);
        }
    });
    
    phoneInput.addEventListener('keypress', function(e) {
        // Allow only numbers (0-9)
        if (e.key < '0' || e.key > '9') {
            e.preventDefault();
        }
    });
});
</script>
@endsection