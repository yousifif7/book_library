@extends('logged.tools.nav')

@section('content')
@php
    $user = App\Models\User::find(Auth::id());
@endphp

<div class="container">
    @if (session()->has('message'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close btn-danger" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session()->has('book'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('book') }}
            <button type="button" class="btn-close btn-danger" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Hi <b class="text-success">{{ $user->name }}</b>, this is your Book Collection</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBookModal">+ Add Book</button>
    </div>
    
    @php
        $reading = App\Models\Book::where('status','reading')->get();
        $read = App\Models\Book::where('status','read')->get();
        $want_to_read = App\Models\Book::where('status','want_to_read')->get();
    @endphp
    {{-- Filter Buttons --}}
    <div class="mb-3 text-center">
        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search by title or author">
        <div class="btn-group" role="group">
            <button class="btn btn-outline-dark filter-btn" data-status="all">All ({{ count($books) }})</button>
            <button class="btn btn-outline-primary filter-btn" data-status="reading">Currently Reading ({{ count($reading) }})</button>
            <button class="btn btn-outline-success filter-btn" data-status="read">Read ({{ count($read) }})</button>
            <button class="btn btn-outline-warning filter-btn" data-status="want_to_read">Want to Read ({{ count($want_to_read) }})</button>
        </div>
    </div>

    @unless (count($books) == 0)
        <div class="row row-cols-1 row-cols-md-3 g-4" id="bookGrid">
            @foreach ($books as $book)
                <div class="col book-card" data-status="{{ $book->status }}" data-title="{{ strtolower($book->book_name) }}" data-author="{{ strtolower($book->author) }}">
                    <div class="card h-100">
                        <img src="{{ $book->cover ? asset('storage/' . $book->cover) : asset('/book.png') }}"
                            class="card-img-top" alt="Cover"
                            style="max-height: 250px; max-width: 100%; object-fit: contain; display: block; margin: 0 auto;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $book->book_name }}</h5>
                            <p class="card-text">{{ $book->author }}</p>
                            <span class="badge bg-success">{{ $book->status }}</span>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="/book/edit/{{ $book->id }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            <form method="POST" action="/book/delete/{{ $book->id }}" class="delete-book-form">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-light text-center">
            <p class="text-primary text-muted">You don't have any books in the library</p>
        </div>
    @endunless
</div>
<br>
{{-- Add Book Modal --}}
<div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="/book/store" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            <div class="modal-header">
                <h5 class="modal-title" id="addBookLabel">Add a New Book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" name="book_name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Author</label>
                    <input type="text" class="form-control" name="author" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="reading">Currently Reading</option>
                        <option value="read">Read</option>
                        <option value="want_to_read">Want to Read</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Cover Image</label>
                    <input type="file" class="form-control" name="cover">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Add Book</button>
            </div>
        </form>
    </div>
</div>

{{-- Script for delete confirmation, filtering, and search --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Confirm delete
        document.querySelectorAll('.delete-book-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                const confirmDelete = confirm('Are you sure you want to delete this book?');
                if (!confirmDelete) e.preventDefault();
            });
        });

        const filterButtons = document.querySelectorAll('.filter-btn');
        const bookCards = document.querySelectorAll('.book-card');

        // Filter by status
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                const status = button.dataset.status;
                document.getElementById('searchInput').value = ''; // Clear search input

                bookCards.forEach(card => {
                    if (status === 'all' || card.dataset.status === status) {
                        card.classList.remove('d-none');
                    } else {
                        card.classList.add('d-none');
                    }
                });
            });
        });

        // Search by title or author
        document.getElementById('searchInput').addEventListener('input', function () {
            const query = this.value.toLowerCase().trim();

            bookCards.forEach(card => {
                const title = card.dataset.title;
                const author = card.dataset.author;

                const matches = title.includes(query) || author.includes(query);
                card.classList.toggle('d-none', !matches);
            });
        });
    });
</script>

@endsection
