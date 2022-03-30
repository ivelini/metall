@extends('frontend.company.tpl1.layout.index')

@section('main-content')
    @include('frontend.company.tpl1.sections.include.inner-banner')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    {!! $content !!}
                </div>
                <div class="col-md-6">
                    <div class="border-1px p-25">
                        <h4 class="text-theme-colored text-uppercase m-0">Make an Appointment</h4>
                        <div class="line-bottom mb-30"></div>
                        <p>Lorem ipsum dolor sit amet, consectetur elit.</p>
                        <form id="appointment_form" name="appointment_form" class="mt-30" method="post" action="includes/appointment.php" novalidate="novalidate">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group mb-10">
                                        <input name="form_name" class="form-control" type="text" required="" placeholder="Enter Name" aria-required="true">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group mb-10">
                                        <input name="form_email" class="form-control required email" type="email" placeholder="Enter Email" aria-required="true">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group mb-10">
                                        <input name="form_phone" class="form-control required" type="text" placeholder="Enter Phone" aria-required="true">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group mb-10">
                                        <input name="form_appontment_date" class="form-control required date-picker" type="text" placeholder="Appoinment Date" aria-required="true">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group mb-10">
                                        <input name="form_appontment_time" class="form-control required time-picker ui-timepicker-input" type="text" placeholder="Appoinment Time" aria-required="true" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-10">
                                <textarea name="form_message" class="form-control required" placeholder="Enter Message" rows="5" aria-required="true"></textarea>
                            </div>
                            <div class="form-group mb-0 mt-20">
                                <input name="form_botcheck" class="form-control" type="hidden" value="">
                                <button type="submit" class="btn btn-dark btn-theme-colored" data-loading-text="Please wait...">Submit</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </section>
@endsection