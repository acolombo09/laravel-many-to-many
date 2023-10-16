@extends('layouts.app')
@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-8">

                <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf()
                    
                    {{-- title --}}
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <div>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" value="{{old('title')}}"
                                name="title">
                            @error('title')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Publishing Date</label>
                        <input type="date" class="form-control" name="published_at" value="{{ now()->toDateString() }}">
                    </div>

                    {{-- description --}}
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <div>
                            <textarea class="form-control @error('description') is-invalid @enderror" style="height: 150px;"
                                name="description">{{old('description')}}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- types --}}
                    <div class="row mb-3">
                        <label class="col-3 col-form-label">Type</label>
                        <div class="col-sm-9">
                        <select class="form-select" aria-label="Default select example" name="type_id">
                            @foreach ($types as $type)
                            <option value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        </select>
                        @error('type_id')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                        </div>
                    </div>

                    {{-- technologies --}}
                    <div class="row mb-3">
                        <label class="col-3 col-form-label">Technologies</label>
                        <div class="col-sm-9 d-flex flex-row">
                            @foreach ($technologies as $technology)
                            <div class="d-flex" style="width: fit-content">
                                {{-- con le quadre dopo technologies faccio capire al server che i dati che voglio passare saranno un array di dati --}}
                                <input type="checkbox" name="technologies[]" value="{{$technology->id}}" class="form-check-input mx-1">
                                <label class="form-check-label ms-1 me-2">{{$technology->name}}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- image --}}
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" accept="image/*" class="form-control @error('image') is-invalid @enderror"
                            name="image">
                        @error('image')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>

                    {{-- link --}}
                    <div class="mb-3">
                        <label class="form-label">Link</label>
                        <div>
                            <input type="text" class="form-control @error('link') is-invalid @enderror" value="{{old('link')}}"
                                name="link">
                            @error('link')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="w-100 text-center">
                        <a class="btn btn-secondary" href="{{ route("admin.projects.index") }}">Cancel</a>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection