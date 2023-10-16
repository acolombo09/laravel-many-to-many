@extends('layouts.app')
@section('content')

{{-- In questa pagina verranno visualizzati i dettagli del project selezionato --}}
<div class="container">
  <div class="text-center my-3">
    <a href=" {{ route('admin.projects.index') }}" class="btn btn-primary">Back to Projects</a>
  </div>
  <div class="row justify-content-center">
    <div class="col-12 p-3">
      <div class="card mt-3">
        <div class="card-header">
          <div class="d-flex justify-content-between">
            <h2 class="ms-3 fs-3 text-lg my-4">
              {{ $project->title }}
            </h2>
            <a class="nav-link d-flex align-items-center text-primary me-5" href="{{ Route("admin.projects.edit", $project->slug)}}">Modify</a>
          </div>
          <div class="d-flex pt-2">
            <div class="row">
              <div class="col-12 col-md-4 text-center mb-3">
                <img class="w-100 object-fit-cover" src="{{ asset('/storage/' . $project->image) }}" alt="{{ $project->title }}">
              </div>
              <div class="col-12 col-md-8 mt-5 mt-md-0 d-flex flex-column">
                <div class="d-flex">
                  <div class="col-3 me-2">Description: </div>
                  <p class="text-break">{{$project->description}}</p>
                </div>
                <div class="d-flex">
                  <div class="col-3 me-2">Type:</div>
                  {{-- questo funziona perchè nei model ho specificato le relazioni! fa un join implicito --}}
                  <p class="badge" style="background-color: rgb({{ $project->type->color }})"> 
                    {{ $project->type->name }}
                  </p>
                </div>
                <div class="d-flex">
                  <div class="col-3 me-2">Technologies:</div>
                  <div class="d-flex">
                    @foreach ($project->technologies as $technology)
                    <div class="badge me-2" style="background-color: #09a6a6">{{$technology->name}}</div>
                    @endforeach
                  </div>
                </div>
                <div class="d-flex">
                  <div class="col-3 me-2">Publishing Date: </div>
                  <p>{{ $project->published_at?->format("d/m/Y") }}</p>
                </div>
                <div class="mt-auto">
                  <div class="d-flex mb-3">
                    <div class="col-3 me-2">GitHub:</div>
                    <div>{{$project->link}}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- Comments section --}}
    <div class="container my-5">
      <h2 class="mb-4">Leave a Comment here</h2>
      <form>
          <div class="mb-3">
              <label for="commentTitle" class="form-label">Title</label>
              <input type="text" class="form-control" id="commentTitle">
          </div>
          <div class="mb-3">
              <label for="commentText" class="form-label">Comment</label>
              <textarea class="form-control" id="commentText" rows="4"></textarea>
          </div>
          <div class="mb-3">
              <label for="commentName" class="form-label">Your Name</label>
              <input type="text" class="form-control" id="commentName">
          </div>
          <div class="mb-3">
              <label for="commentEmail" class="form-label">Your Email</label>
              <input type="email" class="form-control" id="commentEmail">
          </div>
          <button type="submit" class="btn btn-primary">Post Comment</button>
      </form>
  </div>
  
    
  </div>
</div>

@endsection