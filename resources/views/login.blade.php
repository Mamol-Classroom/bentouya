@extends('layout')

@section('title', 'ログイン')

@section('content')
    <main id="login">
        <h1>ログイン</h1>
        <div class="a-section">
            <div class="a-box">
                <div class="a-box-inner a-padding-extra-large">
                    <h1 class="a-spacing-small">
                        Sign-In
                    </h1>
                    @if($login_failed)
                        <p class="error-message">メールアドレスまたはパスワードが間違いました</p>
                    @endif
                    <form method="post" action="/login">
                        <div class="a-row a-spacing-base">
                            <label for="ap_email" class="a-form-label">
                                メールアドレス
                            </label>
                            <input type="email" maxlength="128" id="ap_email" name="email" tabindex="1" class="a-input-text a-span12 auth-autofocus auth-required-field">
                            <label for="ap_email" class="a-form-label">
                                パスワード
                            </label>
                            <input type="password" maxlength="1024" id="ap-credential-autofill-hint" name="password" class="a-input-text hide">
                        </div>
                        <div class="a-section">
                        <span id="continue" class="a-button a-button-span12 a-button-primary">
                            <span class="a-button-inner">
                                <input id="continue" tabindex="5" class="a-button-input" type="submit" aria-labelledby="continue-announce">
                                <span id="continue-announce" class="a-button-text" aria-hidden="true">
                                    ログイン
                                </span>
                            </span>
                        </span>
                            <span id="continue" class="a-button a-button-span12 a-button-primary">
                            <span class="a-button-inner">
                                <input id="continue" tabindex="5" class="a-button-input" type="button" onclick="location.href='/register'" aria-labelledby="continue-announce">
                                <span id="continue-announce" class="a-button-text" aria-hidden="true">
                                    新規登録
                                </span>
                            </span>
                        </span>
                            {{--
                            <div id="legalTextRow" class="a-row a-spacing-top-medium a-size-small">
                                By continuing, you agree to Amazon's <a href="/gp/help/customer/display.html/ref=ap_signin_notification_condition_of_use?ie=UTF8&amp;nodeId=643006">Conditions of Use</a> and <a href="/gp/help/customer/display.html/ref=ap_signin_notification_privacy_notice?ie=UTF8&amp;nodeId=643000">Privacy Notice</a>.
                            </div>
                            --}}
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </main>
@endsection

