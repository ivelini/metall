@extends('admin_panel.layouts.main.main')
@section('title')
    Персонал
@endsection
@section('pageheader-title')
    Персонал
@endsection
@section('header-js')

@endsection
@section('content-area')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-body border-top-primary">
                <div class="text-right">
                    <a href="{{ route('content.sheet.worker.category.index') }}" class="btn btn-primary"><i class="icon-collaboration mr-2"></i> Управление подразделениями</a>
                    <a href="{{ route('content.sheet.worker.create') }}" class="btn btn-light ml-1"><i class="icon-user-plus mr-2"></i> Добавить сотрудника</a>
                </div>
            </div>
        </div>
    </div>
    @if($categories->count() > 0)
        @foreach($categories as $category)
            <div class="mb-3">
                <h6 class="mb-0 font-weight-semibold">
                    {{ $category->name }}
                </h6>
            </div>
            @if($category->workers->count() > 0)
                @foreach($category->workers as $workersChunk)
                    <div class="row">
                        @foreach($workersChunk as $worker)
                                <div class="col-xl-3 col-sm-6">
                                    <div class="card">
                                        <div class="card-img-actions">
                                            <img class="card-img-top img-fluid" src="@if(empty($worker->img))
                                                    /admin_panel/global_assets/images/placeholders/placeholder.jpg
@else
                                            {{ $worker->img}}
                                            @endif" alt="">
                                            <div class="card-img-actions-overlay card-img-top">
                                                <a href="{{ route('content.sheet.worker.edit', $worker->id) }}" class="btn btn-outline-white border-2 btn-icon rounded-pill">
                                                    <i class="icon-cog6"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-body text-center">
                                            <h6 class="font-weight-semibold mb-0">{{ $worker->name }}</h6>
                                            <span class="d-block text-muted">{{ $worker->position }}</span>
                                            <span class="d-block text-muted">{{ $worker->phone }}</span>
                                            <span class="d-block text-muted">{{ $worker->email }} почта</span>
                                        </div>
                                    </div>
                                </div>
                        @endforeach
                    </div>
                @endforeach
            @endif
        @endforeach
    @endif
@endsection
@section('include-footer')

@endsection