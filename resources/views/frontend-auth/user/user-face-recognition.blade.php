@extends('frontend-auth.newlayout')

@section('frontend-section')

<br><br><br><br><br>

<div class="container">
    <h2>Upload Photo</h2>
    <form action="{{ route('users.upload-photo') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="photo">Photo:</label>
            <input type="file" name="photo" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>

</div>

@endsection
