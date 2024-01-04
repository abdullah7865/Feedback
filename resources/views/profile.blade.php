@extends('layouts.front.navbar')
@section('content')
<div class="container">
    <h2 align="center">User Feedback</h2>
    <div class="row">
        @foreach ($user->feedback as $data)
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $data->title }}</h5>
                        <p class="card-text">{{ $data->description }}</p>
                        <p class="card-text"><small class="text-muted">Category: {{ $data->category }}</small></p>
                        <div style="max-height: 200px; overflow-y: auto;">
                            @if ($data->comments->count() > 0)
                                @foreach ($data->comments as $comment)
                                    <div class="media mb-3">
                                        <div class="media-body">
                                            <h6 class="mt-0">{{ $comment->user->name }}</h6>
                                            <p>{{ $comment->content }}</p>
                                            {{-- <div class="d-flex justify-content-between align-items-center">
                                                <button type="button"
                                                    class="btn btn-outline-primary btn-sm">Vote</button>
                                                <span>{{ $comment->votes }}</span>
                                            </div> --}}
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>No comments available.</p>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center">
        <ul class="pagination">

            @if ($feedbackItems->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $feedbackItems->previousPageUrl() }}" rel="prev"
                        aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif


            @for ($i = 1; $i <= $feedbackItems->lastPage(); $i++)
                <li class="page-item {{ $i == $feedbackItems->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $feedbackItems->url($i) }}">{{ $i }}</a>
                </li>
            @endfor


            @if ($feedbackItems->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $feedbackItems->nextPageUrl() }}" rel="next"
                        aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </div>

</div>
@if (session('success'))
    <div style="position: fixed; top: 10px; right: 10px; z-index: 1000;">
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    </div>
@endif
@endsection
