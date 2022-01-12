@extends('layouts.app')

@section('id', 'sogetrel-landing')
@section('page-class', 'hide-menu')

@section('content')
    <div class="landing_sogetrel">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="container_parent">
                    <div class="container_bloc">
                        <div class="titre">
                            {{ __('sogetrel.landing.title_text1') }} <br>
                            {{ __('sogetrel.landing.title_text2') }}
                        </div>
                        <hr>
                        <div class="bloc_text">
                            {{ __('sogetrel.landing.block_text1') }}<br>
                            {{ __('sogetrel.landing.block_text2') }}<br>
                            {{ __('sogetrel.landing.block_text3') }}<br>
                            <br>
                            {{ __('sogetrel.landing.block_text4') }}
                        </div>
                        <div class="cta">
                            <a href="https://sogetrel.addworking.com/register" class="btn btn-primary">
                                <img src="{{ asset('img/sogetrel/landing/icon_cta.png') }}" alt="m'inscrire"  width="25"> {{ __('sogetrel.landing.registering') }}
                            </a>
                        </div>
                        <div class="comment_ca_marche">
                            <div class="sous_titre">
                                {{ __('sogetrel.landing.how_it_works') }}
                            </div>
                            <div class="mini_separator"></div>
                            <div class="infos">
                                <div class="ligne">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <div class="numero">1</div>
                                        </div>
                                        <div class="col-md-11">
                                            {{ __('sogetrel.landing.block_text5') }}
                                            {{ __('sogetrel.landing.block_text6') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="ligne">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <div class="numero">2</div>
                                        </div>
                                        <div class="col-md-11">
                                            <div class="adjust">
                                                {{ __('sogetrel.landing.adjust_text') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ligne">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <div class="numero">3</div>
                                        </div>
                                        <div class="col-md-11">
                                            {{ __('sogetrel.landing.block_text7') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="container_parent">
                <div class="container_bloc">
                    <div class="sous_titre">
                        {{ __('sogetrel.landing.trades') }}
                    </div>
                    <hr>
                    <div class="metiers">
                        <div class="row">
                            <div class="col-md-3" data-toggle="modal" data-target="#modal-1" style="cursor: pointer">
                                <img src="{{ asset('img/sogetrel/landing/metiers/metier_1.png') }}" alt="metier_1"  width="150" class="metier_img center-block">
                                <p>
                                    {{ __('sogetrel.landing.electrician') }} <br>
                                    {{ __('sogetrel.landing.installation') }}
                                </p>
                            </div>
                            <div class="col-md-3" data-toggle="modal" data-target="#modal-2" style="cursor: pointer">
                                <img src="{{ asset('img/sogetrel/landing/metiers/metier_2.png') }}" alt="metier_2"  width="150" class="metier_img center-block">
                                <p>
                                    {{ __('sogetrel.landing.technician') }} <br>
                                    {{ __('sogetrel.landing.customer_connection') }}
                                </p>
                            </div>
                            <div class="col-md-3" data-toggle="modal" data-target="#modal-3" style="cursor: pointer">
                                <img src="{{ asset('img/sogetrel/landing/metiers/metier_4.png') }}" alt="metier_3"  width="150" class="metier_img center-block">
                                <p>
                                    {{ __('sogetrel.landing.technician') }} <br>
                                    {{ __('sogetrel.landing.optical_fibre') }}
                                </p>
                            </div>
                            <div class="col-md-3" data-toggle="modal" data-target="#modal-4" style="cursor: pointer">
                                <img src="{{ asset('img/sogetrel/landing/metiers/metier_3.png') }}" alt="metier_4"  width="150" class="metier_img center-block">
                                <p>
                                    {{ __('sogetrel.landing.optical_welder') }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" data-toggle="modal" data-target="#modal-5" style="cursor: pointer">
                                <img src="{{ asset('img/sogetrel/landing/metiers/metier_5.png') }}" alt="metier_5"  width="150" class="metier_img center-block">
                                <p>
                                    {{ __('sogetrel.landing.fitter_wirer') }} <br>
                                    {{ __('sogetrel.landing.fibre_or_copper') }}
                                </p>
                            </div>
                            <div class="col-md-3" data-toggle="modal" data-target="#modal-6" style="cursor: pointer">
                                <img src="{{ asset('img/sogetrel/landing/metiers/metier_6.png') }}" alt="metier_6"  width="150" class="metier_img center-block">
                                <p>
                                    {{ __('sogetrel.landing.radio_wiring_fitter') }}
                                </p>
                            </div>
                            <div class="col-md-3" data-toggle="modal" data-target="#modal-7" style="cursor: pointer">
                                <img src="{{ asset('img/sogetrel/landing/metiers/metier_7.png') }}" alt="metier_7"  width="150" class="metier_img center-block">
                                <p>
                                    {{ __('sogetrel.landing.technician_text') }}
                                </p>
                            </div>
                            <div class="col-md-3" data-toggle="modal" data-target="#modal-8" style="cursor: pointer">
                                <img src="{{ asset('img/sogetrel/landing/metiers/metier_8.png') }}" alt="metier_8"  width="150" class="metier_img center-block">
                                <p>
                                    {{ __('sogetrel.landing.be_rip_stakeholder') }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" data-toggle="modal" data-target="#modal-9" style="cursor: pointer">
                                <img src="{{ asset('img/sogetrel/landing/metiers/metier_9.png') }}" alt="metier_9"  width="150" class="metier_img center-block">
                                <p>
                                    {{ __('sogetrel.landing.designer') }}
                                </p>
                            </div>
                            <div class="col-md-4">
                                <img src="{{ asset('img/sogetrel/landing/metiers/metier_10.png') }}" alt="metier_10"  width="150" class="metier_img center-block">
                                <p>
                                    {{ __('sogetrel.landing.studies_manager') }}
                                </p>
                            </div>
                            <div class="col-md-4" data-toggle="modal" data-target="#modal-11" style="cursor: pointer">
                                <img src="{{ asset('img/sogetrel/landing/metiers/metier_11.png') }}" alt="metier_10"  width="150" class="metier_img center-block">
                                <p>
                                    {{ __('sogetrel.landing.civil_engineering') }}
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="container_parent second">
                <div class="container_bloc">
                    <div class="etapes">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ asset('img/sogetrel/landing/icon_cta.png') }}" alt="m'inscrire"  width="40" class="icon">
                                <p>
                                    <span class="ppl">
                                        1. {{ __('sogetrel.landing.registering') }}
                                    </span>
                                    <span class="description">
                                       {{ __('sogetrel.landing.free_and_without_obligation') }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <img src="{{ asset('img/sogetrel/landing/icon_contact.png') }}" alt="JE SUIS CONTACTÉ"  width="40" class="icon">
                                <p>
                                    <span class="ppl">
                                        2. {{ __('sogetrel.landing.contacted') }}
                                    </span>
                                    <span class="description">
                                       {{ __('sogetrel.landing.contacted_description') }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <img src="{{ asset('img/sogetrel/landing/icon_activite.png') }}" alt="m'inscrire"  width="40" class="icon">
                                <p>
                                    <span class="ppl">
                                        3. {{ __('sogetrel.landing.benifit_from_additional_activity') }}
                                    </span>
                                    <span class="description">
                                       {{ __('sogetrel.landing.increase_income') }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container_parent">
                <div class="container_bloc">
                    @include('sogetrel._sogetrel_description')
                </div>
            </div>

            <div class="container_parent">
                <div class="container_bloc">
                    <div class="videos_youtube">
                        <div class="sous_titre">
                            {{ __('sogetrel.landing.discover') }}
                        </div>
                        <hr>
                        @include('sogetrel._videos_youtube')
                    </div>
                </div>
            </div>
            <div class="cta">
                <a href="https://sogetrel.addworking.com/register" class="btn btn-primary">
                    <img src="{{ asset('img/sogetrel/landing/icon_cta.png') }}" alt="m'inscrire"  width="25"> {{ __('sogetrel.landing.register_now') }}
                </a>
            </div>
            <p class="info_adw">
                {{ __('sogetrel.landing.who_are_we') }} <br>
                <img src="{{ asset('img/logo_addworking_wide.png') }}" alt="Addworking" height="25">&nbsp;
                <strong>{{ __('sogetrel.landing.partner') }}</strong> {{ __('sogetrel.landing.extra_text') }}
            </p>
        </div>
    </div>
</div>

@include('sogetrel.modals._electrician_technician')
@include('sogetrel.modals._welder')
@include('sogetrel.modals._cable_rigger')
@include('sogetrel.modals._technician')
@include('sogetrel.modals._designer')
@include('sogetrel.modals._genie_civil')

@endsection
