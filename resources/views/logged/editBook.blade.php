@extends('logged.tools.nav')

@section('content')
    <div class="container">
        <div class="modal-header">
            <h5 class="modal-title" id="addBookLabel">Update book {{ $book->book_name }}</h5>
        </div>
        <form class="" method="POST" action="/book/update/{{ $book->id }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input hidden name="user_id" value={{ Auth::id() }}>

            <div class="container">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" name="book_name" required
                        value="{{ old('book_name', $book->book_name) }}">
                    @error('book_name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Author</label>
                    <input type="text" class="form-control" name="author" required
                        value="{{ old('author', $book->author) }}">
                    @error('author')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="reading" {{ old('status', $book->status) == 'reading' ? 'selected' : '' }}>Currently
                            Reading</option>
                        <option value="read" {{ old('status', $book->status) == 'read' ? 'selected' : '' }}>Read</option>
                        <option value="want_to_read" {{ old('status', $book->status) == 'want_to_read' ? 'selected' : '' }}>
                            Want to Read</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Cover Image</label>
                    <input type="file" class="form-control" name="cover">
                    @error('cover')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
@endsection
