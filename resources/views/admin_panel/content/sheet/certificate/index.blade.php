@extends('admin_panel.layouts.main.main')
@section('title')
    Сертификаты
@endsection
@section('pageheader-title')
    Сертификаты
@endsection
@section('header-js')
    <script src="/admin_panel/global_assets/js/plugins/media/glightbox.min.js"></script>
    <script src="/admin_panel/global_assets/js/demo_pages/gallery.js"></script>
@endsection
@section('content-area')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-body border-top-primary">
                <div class="text-right">
                    <a href="{{ route('content.sheet.certificate.create') }}" class="btn btn-light ml-1"><i class="icon-file-plus mr-2"></i> Добавить сертификат</a>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <h6 class="mb-0 font-weight-semibold">
            Список сертификатов
        </h6>
        @if($certificatesChunk->count() == 0)<span class="text-muted d-block">Нет ни одного загруженного сертификата</span>@endif
    </div>
    @if($certificatesChunk->count() > 0)
        @foreach($certificatesChunk as $certificates)
            <div class="row">
                @foreach($certificates as $certificate)
                    <div class="col-sm-6 col-xl-3">
                        <div class="card">
                            <div class="card-img-actions mx-1 mt-1">
                                @if(!empty($certificate->image->img))
                                    <img class="card-img img-fluid" src="{{ $certificate->image->img }}" alt="">
                                    <div class="card-img-actions-overlay card-img">
                                        <a href="{{ $certificate->image->img_original }}" class="btn btn-outline-white border-2 btn-icon rounded-pill" data-popup="lightbox" data-gallery="gallery1">
                                            <i class="icon-eye"></i>
                                        </a>
                                    </div>
                                @elseif(empty($certificate->image->img))
                                    <img class="card-img img-fluid" src="/admin_panel/global_assets/images/placeholders/placeholder.jpg" alt="">
                                    <div class="card-img-actions-overlay card-img">
                                        <a href="/admin_panel/global_assets/images/placeholders/placeholder.jpg" class="btn btn-outline-white border-2 btn-icon rounded-pill" data-popup="lightbox" data-gallery="gallery1">
                                            <i class="icon-eye"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <div class="card-body">
                                <div class="d-flex align-items-start flex-nowrap">
                                    <div>
                                        <div class="font-weight-semibold mr-2">{{ $certificate->name }}</div>
                                        <span class="font-size-sm text-muted">{{ $certificate->description }}</span>
                                    </div>

                                    <div class="list-icons list-icons-extended ml-auto">
                                        <a href="{{ route('content.sheet.certificate.edit', $certificate->id) }}" class="list-icons-item"><i class="icon-cog6 top-0"></i></a>
                                        <form method="POST" action="{{ route('content.sheet.certificate.destroy', $certificate->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="list-icons-item"><i class="icon-bin top-0"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @endif
@endsection
@section('include-footer')

@endsection