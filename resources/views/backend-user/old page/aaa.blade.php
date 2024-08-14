@extends('user.layout')

@section('user-section')
<form action="{{ route('addResort') }}" method="POST" enctype="multipart/form-data">
@csrf
    <div class="modal-body">
        <!-- {{ Auth::id() }} -->
        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
        <div class="form-group">
            <label for="name">Resort Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Resort Name">
            <span class="text-danger">@error('name') {{$message}} @enderror</span>
        </div>
        <div class="form-group">
            <label for="image">Resort Image </label>
            <input type="file" class="form-control" name="image" id="image" placeholder="Enter Resort Image">
            <span class="text-danger">@error('image') {{$message}} @enderror</span>
        </div>
        <div class="form-group">
            <label for="price">Resort Price</label>
            <input type="number" class="form-control" name="price" id="price" placeholder="Enter Resort Price">
            <span class="text-danger">@error('price') {{$message}} @enderror</span>
        </div>
        <div class="form-group">
            <label for="location">Resort Location</label>
            <input type="text" class="form-control" name="location" id="location">
            <span class="text-danger">@error('location') {{$message}} @enderror</span>
        </div>

        <input type="text" id="latitude" name="latitude">
        <input type="text" id="longitude" name="longitude">

        <div class="form-group">
            <label for="description">Resort Description</label>
            <input type="text" class="form-control" name="description" id="description" placeholder="Enter Description ">
            <span class="text-danger">@error('description') {{$message}} @enderror</span>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add New Resort</button>
    </div>
</form>
@endsection