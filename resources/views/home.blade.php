@extends('layouts.home')

@section('header',)
@section('content')

  @if (session('status'))
      <div class="alert alert-success" role="alert">
          {{ session('status') }}
      </div>
  @endif

@endsection
