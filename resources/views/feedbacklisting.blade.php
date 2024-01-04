@extends('layouts.front.navbar')
@section('content')
    <div class="container">
        <h2 align="center">Feedback Listing</h2>
        <div class="row">
            @foreach ($feedbacks as $data)
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $data->title }}</h5>
                            <p class="card-text">{{ $data->description }}</p>
                            <p class="card-text"><small class="text-muted">Category: {{ $data->category }}</small></p>


                            <a href="#" class="btn btn-primary" data-toggle="collapse"
                                data-target="#commentCollapse{{ $data->id }}">Add Comment</a>


                            <div class="collapse" id="commentCollapse{{ $data->id }}">
                                <div class="mt-3">
                                    <form action="{{ route('comments.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                        <input type="hidden" name="feedback_id" value="{{ $data->id }}">

                                        <textarea name="content" class="form-control" placeholder="Your comment..."></textarea>

                                        <button type="submit" class="btn btn-success mt-2">Submit Comment</button>
                                    </form>
                                    <!-- Include Mention.js library -->
                                    <script src="https://cdn.jsdelivr.net/npm/jquery-mention@1.0.0/bootstrap-typeahead.min.js"></script>

                                    <!-- Initialize Mention.js for the textarea -->
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            const textarea = document.querySelector("textarea[name='content']");

                                            const mentions = new Mention({
                                                input: textarea,
                                                // You may need to customize the configuration based on Mention.js documentation
                                            });
                                        });
                                    </script>

                                </div>
                            </div>

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

                @if ($feedbacks->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <span class="page-link" aria-hidden="true">&lsaquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $feedbacks->previousPageUrl() }}" rel="prev"
                            aria-label="@lang('pagination.previous')">&lsaquo;</a>
                    </li>
                @endif


                @for ($i = 1; $i <= $feedbacks->lastPage(); $i++)
                    <li class="page-item {{ $i == $feedbacks->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $feedbacks->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor


                @if ($feedbacks->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $feedbacks->nextPageUrl() }}" rel="next"
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
