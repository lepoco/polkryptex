@extends('layouts.app', [
])
@section('content')
<div class="container -pt-5">
    <div class="row">

        <div class="col-12 col-lg-6 -pb-3 -mh-70 -flex-center -reveal">
            <div>
                <h2 class="-font-secondary -fw-700">@translate('Create your cryptocurrency wallet today')</h2>
                <p>
                    @translate('Polkryptex is a simple way to buy and sell cryptocurrencies.')
                    <br>
                    <a href="@url('register')">@translate('Open your free account now')</a>
                </p>
            </div>
        </div>
        <div class="col-12 col-lg-6 -reveal">
            <img lazy src="@asset('img/iphone-account.png')" alt="" width="550" />
        </div>

        <div class="col-12 -pt-6 -pb-3 -flex-center -flex-justify-center -text-center -reveal">
            <div>
                <h4 class="-font-secondary -fw-700">@translate('Industry best practices')</h4>
                <p>@translate('Polkryptex supports a variety of the most popular digital currencies.')</p>
            </div>
        </div>
        <div class="col-12 -reveal">
            <div class="card -rounded-2 -image -light" style="background-image: url('@asset('img/pexels-photo-7657470.jpeg')')">
                <div class="card-body -p-4">
                    <div class="-minhr-38 -flex-center">
                        <div>
                            <h4 class="-font-secondary -fw-700">@translate('Pay and get paid\nhassle‑free')</h4>
                            <p class="-fw-700">@translate('Make quick payments in multiple currencies\nto people around the world, quickly and securely.')</p>
                        </div>
                    </div>
                    <a class="-color-white -font-secondary -fw-700" href="#">@translate('Payments') <svg viewBox="0 0 24 24" size="24" width="24" aria-label="Payments" class="icon-base__IconBase-sc-1efctcf-0 jHhsyi sc-twf687-1 bYibVB"><g fill="currentColor"><path fill="currentColor" d="M20.5 11.992c0-.276-.105-.535-.306-.737L14.77 5.832a.919.919 0 0 0-1.3 0l-.324.325a.919.919 0 0 0 0 1.3l3.394 3.395H4.42a.919.919 0 0 0-.92.919v.46c0 .507.411.918.92.918h12.12l-3.394 3.394a.919.919 0 0 0 0 1.3l.325.325c.359.359.94.359 1.3 0l5.423-5.422c.204-.205.306-.477.306-.754z"></path></g></svg></a>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 -mt-2 -reveal">
            <div class="card -rounded-2 -image -light" style="background-image: url('@asset('img/pexels-photo-7788007.jpeg')')">
                <div class="card-body -p-4">
                    <div class="-minhr-38 -flex-center">
                        <div>
                            <h4 class="-font-secondary -fw-700">@translate('All currencies\nin one place')</h4>
                            <p class="-fw-700">@translate('With the help of Polkryptex you can exchange traditional currencies\nfor crypto and vice versa. It\'s fast, convenient and safe.')</p>
                        </div>
                    </div>
                    <a class="-color-white -font-secondary -fw-700" href="#">@translate('Crypto') <svg viewBox="0 0 24 24" size="24" width="24" aria-label="Payments" class="icon-base__IconBase-sc-1efctcf-0 jHhsyi sc-twf687-1 bYibVB"><g fill="currentColor"><path fill="currentColor" d="M20.5 11.992c0-.276-.105-.535-.306-.737L14.77 5.832a.919.919 0 0 0-1.3 0l-.324.325a.919.919 0 0 0 0 1.3l3.394 3.395H4.42a.919.919 0 0 0-.92.919v.46c0 .507.411.918.92.918h12.12l-3.394 3.394a.919.919 0 0 0 0 1.3l.325.325c.359.359.94.359 1.3 0l5.423-5.422c.204-.205.306-.477.306-.754z"></path></g></svg></a>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 -mt-2 -reveal">
            <div class="card -rounded-2 -image -light -text-shadow" style="background-image: url('@asset('img/pexels-photo-7293788.jpeg')')">
                <div class="card-body -p-4">
                    <div class="-minhr-38 -flex-center">
                        <div>
                            <h4 class="-font-secondary -fw-700">@translate('Get from cash to crypto\ninstantly')</h4>
                            <p class="-fw-700">@translate('Make quick payments in multiple currencies\nto people around the world, quickly and securely.')</p>
                        </div>
                    </div>
                    <a class="-color-white -font-secondary -fw-700" href="#">@translate('Exchange') <svg viewBox="0 0 24 24" size="24" width="24" aria-label="Payments" class="icon-base__IconBase-sc-1efctcf-0 jHhsyi sc-twf687-1 bYibVB"><g fill="currentColor"><path fill="currentColor" d="M20.5 11.992c0-.276-.105-.535-.306-.737L14.77 5.832a.919.919 0 0 0-1.3 0l-.324.325a.919.919 0 0 0 0 1.3l3.394 3.395H4.42a.919.919 0 0 0-.92.919v.46c0 .507.411.918.92.918h12.12l-3.394 3.394a.919.919 0 0 0 0 1.3l.325.325c.359.359.94.359 1.3 0l5.423-5.422c.204-.205.306-.477.306-.754z"></path></g></svg></a>
                </div>
            </div>
        </div>

        <div class="col-12 -pt-6 -pb-3 -flex-center -flex-justify-center -text-center -reveal">
            <div>
                <h4 class="-font-secondary -fw-700">@translate('Choose a plan for yourself')</h4>
                <p>@translate('Tailored to your needs, no surprises')</p>
            </div>
        </div>
        <div class="col-12 -pb-6">
            <div class="row">
                <div class="col-12 col-lg-3 -reveal">
                    <a href="@url('register')">
                        <div class="card -rounded-2 -color-dark">
                            <div class="card-body -p-4">
                                <h5 class="-font-secondary -fw-700">Standard</h5>
                                <p>Free</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-lg-3 -reveal">
                    <a href="@url('register')">
                        <div class="card -rounded-2 -color-dark">
                            <div class="card-body -p-4">
                                <h5 class="-font-secondary -fw-700">Plus</h5>
                                <p>$ 14,90/@translate('month')</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-lg-3 -reveal">
                    <a href="@url('register')">
                        <div class="card -rounded-2 -color-dark">
                            <div class="card-body -p-4">
                                <h5 class="-font-secondary -fw-700">Premium</h5>
                                <p>$ 29,90/@translate('month')</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-lg-3 -reveal">
                    <a href="@url('register')">
                        <div class="card -rounded-2 -gold">
                            <div class="card-body -p-4">
                                <h5 class="-font-secondary -fw-700">Trader</h5>
                                <p>$ 49,90/@translate('month')</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection