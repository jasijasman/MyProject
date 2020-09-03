@extends('layouts.app')

@section('sidebar')
  @include('layouts/sidebar')
@endsection

@section('content')
<div class="container">
    <h1>Add New Document</h1>
    <hr>
    <form action="{{route('upload')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group"  maxlength="4" size="4">
            <label for="title">Document Name</label>
            <input type="text" class="form-control" id="documentName"  name="doc_name">
        </div>
        <div class="form-group"  maxlength="4" size="4">
            <label for="description">Department</label>
            <select class="form-control" name="department">
                <option>IT</option>
                <option>Manufacturing</option>
                <option>Transport</option>
                <option>Human Resource</option>

            </select>
        </div>
        <div class="form-group">
            <label for="title">Document</label>
          <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
        </div>
        <div class="form-group">
            <label for="description">Document Description</label>
            <textarea type="text" class="form-control" id="DocumentDescription" name="description"></textarea>
        </div>
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
        </div>
        <img src="uploads/{{ Session::get('file') }}">
        @endif

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data"> -->
            <!-- @csrf -->
            <div class="row">


                <div class="col-md-6">
                    <button type="submit" class="btn btn-success">Upload</button>
                </div>

            </div>
        </form>
</div>
@endsection
