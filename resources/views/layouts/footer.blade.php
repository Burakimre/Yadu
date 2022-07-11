<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <img src={{ asset("images/friends.png") }} class="center-block img-responsive" width="200px"
                alt="friends">
            </div>
            <div class="col-sm">
                <ul class="list-unstyled">
                    <li class="nav-link-footer">
                        <a href="/about">{{__('navigation.footer_about')}}</a>
                    </li>
                    <li class="nav-link-footer">
                        <a href="/contact">{{__('navigation.footer_contact')}}</a>
                    </li>
                    <li class="nav-link-footer">
                        <a href="/terms">{{__('navigation.footer_tos')}}</a>
                    </li>
                    <li class="nav-link-footer">
                        <a href="/cookies">{{__('navigation.footer_cookies')}}</a>
                    </li>
                    <li class="nav-link-footer">
                        <a href="/privacy">{{__('navigation.footer_privacy')}}</a>
                    </li>
                </ul>
            </div>
            <div class="col-sm float-right">
                <form method="POST" action="/language" class="form-group mt-3 float-right">
                    @csrf
                    <select name="language" id="language" onchange="this.form.submit()" class="form-control">
                        <option value="nl" @if(App::getlocale() == 'nl') selected @endif >NL</option>
                        <option value="en" @if(App::getlocale() == 'en') selected @endif >EN</option>
                    </select>
                </form>
            </div>
        </div>
    </div>
</div>
