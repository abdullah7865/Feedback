@extends('layouts.front.navbar')
@section('content')
    <h2 align="center">Feedback Form</h2>

    <form id="feedbackForm" action="{{ route('feedback.submit') }}" method="post">
        @csrf

        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
            @error('title')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
            @error('description')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="category">Category:</label>
            <select class="form-control" id="category" name="category">
                <option value="bug" {{ old('category') == 'bug' ? 'selected' : '' }}>Bug Report</option>
                <option value="feature" {{ old('category') == 'feature' ? 'selected' : '' }}>Feature Request</option>
                <option value="improvement" {{ old('category') == 'improvement' ? 'selected' : '' }}>Improvement</option>
            </select>
            @error('category')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Submit Feedback</button>
    </form>
    @if(session('success'))
    <div style="position: fixed; top: 10px; right: 10px; z-index: 1000;">
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    </div>
@endif

@endsection
