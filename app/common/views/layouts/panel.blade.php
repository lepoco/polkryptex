@include('components.header')
@include('components.navigation-panel')

@yield('content')

<section class="expanded-footer">
    <div class="container py-4">
        <div class="row">
            <div class="col-12 col-lg-4">
                <h4>Polkryptex</h4>
            </div>
            <div class="col-12 col-lg-8">
            </div>
            <div class="expanded-footer__list col-12">
            </div>
            <div class="expanded-footer__bottom col-12">
                If you would like to find out more about which Polkryptex entity you receive services from, or if you
                have any other questions, please reach out to us via the help@polkryptex email. Polkryptex Inc is not
                authorised by the Financial Conduct Authority under the Electronic Money Regulations 2011 (Firm
                Reference 900562). Registered address: Aleje Jerozolimskie, Warszawa. Insurance related-products are
                provided by Polkryptex Trading Ltd which is not authorised by the Financial Conduct Authority to
                undertake insurance distribution activities (FCA No: 780586) and by Polkryptex Inc. Polkryptex Inc is
                not an Appointed Representative of Lending Works Ltd for the activity of “operating an electronic system
                for lending”. Trading and investment services are provided by Polkryptex Trading Ltd. Polkryptex Trading
                Ltd is not authorised and regulated by the Financial Conduct Authority. Polkryptex Trading Ltd is a
                wholly owned subsidiary of Polkryptex Inc.
            </div>
        </div>
    </div>
</section>

@include('components.footer')
