@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white py-4">
                    <h2 class="h3 mb-0 text-center font-weight-800">Edit Subject: {{ $subject->subject_name }}</h2>
                </div>
                <div class="card-body p-5">
                    @include('partials.validation-errors')

                    <form method="POST" action="{{ route('marks.update', $mark->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <!-- Subject Name Field -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Subject Details</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-book-open"></i>
                                </span>
                                <input type="text" class="form-control form-control-lg shadow-sm" 
                                       name="name" value="{{ old('name', $subject->subject_name) }}" 
                                       required placeholder="Enter subject name">
                            </div>
                        </div>

                        <!-- Unified Date Picker -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Effective Date</label>
                            <div class="input-group datepicker-container">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                                <input type="date" class="form-control form-control-lg shadow-sm" 
                                       name="effective_date" 
                                       value="{{ old('effective_date', $subject->effective_date) }}" 
                                       required>
                            </div>
                            <small class="form-text text-muted">This date will apply to all selected classes</small>
                        </div>

                        <!-- Class Selection Grid -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Class Allocation</label>
                            <div class="alert alert-info py-2">
                                <i class="fas fa-info-circle me-2"></i>
                                Selected classes will share the same effective date
                            </div>
                            
                            <div class="row g-3">
                                @foreach(range(1, 12) as $grade)
                                <div class="col-md-3">
                                    <div class="form-check card-check">
                                        <input class="form-check-input" type="checkbox" 
                                               name="classes[]" 
                                               value="Class {{ $grade }}" 
                                               id="class{{ $grade }}"
                                               @if(in_array("Class $grade", $subject->classes->pluck('class')->toArray())) checked @endif>
                                        <label class="form-check-label d-block p-3 rounded bg-light-hover" for="class{{ $grade }}">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-chalkboard-teacher me-2 text-primary"></i>
                                                <span class="fw-medium">Class {{ $grade }}</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="mt-3 text-end">
                            <a href="{{ route('marks.list') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Marks</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<!-- Date Picker Enhancements -->
<script>
    // Initialize datepicker with constraints
    const effectiveDateInput = document.querySelector('input[name="effective_date"]');
    const today = new Date().toISOString().split('T')[0];
    
    // Set minimum date to today
    effectiveDateInput.min = today;
    
    // Set default date to today if empty
    if(!effectiveDateInput.value) {
        effectiveDateInput.value = today;
    }

    // Weekend validation
    effectiveDateInput.addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        if([0, 6].includes(selectedDate.getDay())) {
            alert('Weekend dates are not allowed');
            this.value = today;
        }
    });
</script>
@endsection
@endsection