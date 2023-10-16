@extends('layouts.app')
@section('content')

<div class="container py-3">
  <div class="row row-cols-3 my-3 g-5">

    @foreach ($projects as $project)
    <div class="col d-flex justify-content-center">

      <div class="card" style="width: 300px;">
        <img src="{{ asset('/storage/' . $project->image) }}" class="card-img-top object-fit-cover" alt="{{$project->title}}">
        <div class="card-body">
          <h5 class="card-title text-center"><a class="text-decoration-none" href="{{route("admin.projects.show", $project->slug)}}">{{$project->title}}</a></h5>
          <p class="card-text">{{ $project->description }}</p>
          {{-- questo funziona perchè nei model ho specificato le relazioni! fa un join implicito --}}
          <p class="badge" style="background-color: rgb({{ $project->type->color }})"> 
            {{ $project->type->name }}
          </p>
          <br>
          @foreach ($project->technologies as $technology)
          <p class="badge" style="background-color: #09a6a6">{{$technology->name}}</p>
          @endforeach
          <p class="card-text">{{ $project->published_at?->format("d/m/Y") }}</p>
        </div>
      </div>

    </div>
    @endforeach
    
  </div>

  <div class="text-center my-5">
    <a href=" {{ route('admin.projects.create') }}" class="btn btn-primary">Create New Project</a>
  </div>

</div>

@endsection