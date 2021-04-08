@extends('layouts.home')

@section('header',)
@section('content')

  @if (session('status'))
      <div class="alert alert-success" role="alert">
          {{ session('status') }}
      </div>
  @endif
  @if (session('message'))
      <div class="alert alert-success" role="alert">
          {{ session('message') }}
      </div>
  @endif

@endsection
