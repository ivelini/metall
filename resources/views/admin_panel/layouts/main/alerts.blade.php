@if ($errors->any())
    <div class="row">
        <div class="col-lg-12">
            @foreach ($errors->all() as $error)
                <div class="alert alert-warning alert-styled-left alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                    {{ $error }}
                </div>
            @endforeach
        </div>
    </div>
@endif
@if (session('success'))
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-info alert-styled-left alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                {{ session()->get('success') }}
            </div>
        </div>
    </div>
@endif
@if (session('alert'))
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-warning alert-styled-left alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                {{ session()->get('alert') }}
            </div>
        </div>
    </div>
@endif