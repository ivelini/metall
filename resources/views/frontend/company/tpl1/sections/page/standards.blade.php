@extends('frontend.company.tpl1.layout.index')

@section('main-content')
    @include('frontend.company.tpl1.sections.include.inner-banner')

    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @if($standards->count() > 0)
                        <table class="table">
                            <thead>
                            <tr>
                                <td width="25%">Стандарт</td>
                                <td width="50%">Описание</td>
                                <td width="25%">Документ</td>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($standards as $standard)
                                    <tr>
                                        <td>{{ $standard->get('h1') }}</td>
                                        <td>{{ $standard->get('description') }}</td>
                                        <td><a href="{{ $standard->get('file') }}" class="btn btn-border btn-theme-colored btn-sm">Скачать документацию</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </section>


@endsection