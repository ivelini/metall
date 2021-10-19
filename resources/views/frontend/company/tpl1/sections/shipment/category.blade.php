@extends('frontend.company.tpl1.layout.index')

@section('main-content')
    @include('frontend.company.tpl1.sections.include.inner-banner')
    <section class="bg-lighter" id="pricing">
        <div class="container">
            <div class="section-content">
                <div class="row">
                    @if($shipments->count() > 0)
                        @foreach($shipments as $shipment)
                            <div class="col-xs-12 col-sm-6 col-md-4 hvr-float-shadow mb-sm-30">
                                <div class="pricing-table maxwidth400">
                                    <div class="font-36 pl-20 bg-theme-colored text-white text-left pr-20 p-10">
                                        &nbsp;
                                        <span class="font-15 pull-right mt-15 text-white">{{ $shipment->get('point') }}</span>
                                    </div>
                                    <img src="{{ $shipment->get('img') }}" alt="">
                                    <div class=" bg-white border-1px p-30 pt-20 pb-20">
                                        <h3 class="package-type font-28 mt-0 text-black">{{ $shipment->get('h1') }}</h3>
                                        <ul class="table-list theme-colored">
                                            <li><i class="fa fa-check"></i>{{ $shipment->get('date') }}</li>
                                        </ul>
                                    </div>
                                    <a href="{{ route('frontend.company.content.sheet.shipment.page',  $shipment->get('id')) }}" class="btn btn-lg btn-theme-colored text-uppercase btn-block pt-20 pb-20 btn-flat">Состав отгрузки</a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection