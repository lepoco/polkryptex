<section class="expanded-footer">
    <div class="container py-4">
        <div class="row">
            <div class="col-12 col-lg-4">
                <h4 class="-mb-4">Polkryptex</h4>
            </div>
            @iflogged
            <div class="col-12"></div>
            @else
            <div class="col-12 col-lg-8">
                <div class="row">
                    <div class="col-6 col-lg-3">
                        <ul class="expanded-footer__menu list-unstyled">
                            <li class="expanded-footer__menu__header">
                                @translate('Account')
                            </li>
                            <li>
                                <a href="@url('dashboard/budget')">@translate('Budget & Analytics')</a>
                            </li>
                            <li>
                                <a href="@url('dashboard/wallet')">@translate('Wallet')</a>
                            </li>
                            <li>
                                <a href="@url('dashboard/crypto')">@translate('Crypto')</a>
                            </li>
                            <li>
                                <a href="@url('dashboard/cards')">@translate('Credit cards')</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-6 col-lg-3">
                        <ul class="expanded-footer__menu list-unstyled">
                            <li class="expanded-footer__menu__header">
                                @translate('Payments')
                            </li>
                            <li>
                                <a href="@url('info/transfers')">@translate('Money transfers')</a>
                            </li>
                            <li>
                                <a href="@url('info/groups')">@translate('Group bills')</a>
                            </li>
                            <li>
                                <a href="@url('info/plans')">@translate('Subscriptions')</a>
                            </li>
                            <li>
                                <a href="@url('info/rewards')">@translate('Rewards')</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-6 col-lg-3">
                        <ul class="expanded-footer__menu list-unstyled">
                            <li class="expanded-footer__menu__header">
                                @translate('Company')
                            </li>
                            <li>
                                <a href="@url('about')">@translate('About us')</a>
                            </li>
                            <li>
                                <a href="@url('carriers')">@translate('Carriers')</a>
                            </li>
                            <li>
                                <a href="@url('affiliates')">@translate('Affiliates')</a>
                            </li>
                            <li>
                                <a href="@url('contact')">@translate('Contact')</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-6 col-lg-3">
                        <ul class="expanded-footer__menu list-unstyled">
                            <li class="expanded-footer__menu__header">
                                @translate('Help')
                            </li>
                            <li>
                                <a href="@url('help')">@translate('Help Centre')</a>
                            </li>
                            <li>
                                <a href="@url('security')">@translate('Security')</a>
                            </li>
                            <li>
                                <a href="@url('api')">@translate('Developer APIs')</a>
                            </li>
                            <li>
                                <a href="@url('licenses')">@translate('Licenses')</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <div class="expanded-footer__list col-12">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        © {{ date('Y') }} Polkryptex Inc
                    </li>
                    <li class="list-inline-item">
                        <a href="@url('terms')">@translate('Website Terms')</a>
                    </li>
                    <li class="list-inline-item">
                        <a href="@url('legal')">@translate('Legal Agreements')</a>
                    </li>
                    <li class="list-inline-item">
                        <a href="@url('privacy')">@translate('Privacy Policy')</a>
                    </li>
                    <li class="list-inline-item">
                        <a href="@url('licenses')">@translate('Licenses')</a>
                    </li>
                </ul>
            </div>

            <div class="expanded-footer__bottom col-12">
                If you would like to find out more about which Polkryptex entity you receive services from, or if you
                have any other questions, please reach out to us via the help@polkryptex email. What is it like to be a scribe? Is it good? In my opinion it's not about being good or not good. If I were to say what I esteem the most in life, I would say - people. People, who gave me a helping hand when I was a mess, when I was alone. And what's interesting, the chance meetings are the ones that influence our lives. The point is that when you profess certain values, even those seemingly universal, you may not find any understanding which, let me say, which helps us to develop. I had luck, let me say, because I found it. And I'd like to thank life. I'd like to thank it - life is singing, life is dancing, life is love. Many people ask me the same question, but how do you do that? where does all your happiness come from? And i replay that it's easy, it's cherishing live, that's what makes me build machines today, and tomorrow... who knows, why not, i would dedicate myself to do some community working and i would be, wham, not least... planting .... i mean... carrots.
            </div>
        </div>
    </div>
</section>
