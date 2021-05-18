
@extends('mypage.layout')

@section('title', 'プロフィール')

@section('mypage-content')
    <link rel="stylesheet" href="{{ asset('css/style1') }}">
    {{--<script type="text/javascript" src="{{ URL::asset('js/script1.js') }}"></script>--}}

    <div class="center">
        <form class="error" method="post">
            请输入旧密码<input type="password" name="oddpass" id="oddpass" maxlength="20"><br>
            请输入新密码<input type="password" name="newpass" id="newpass" maxlength="20"><br>
            请确认新密码<input type="password" name="confirmpass" id="confirmpass" maxlength="20"><br>
            请选择头像<input type="file" name="image" id="image">
            <button id="login" type="submit" value="submit">確定</button>
        </form>

    </div>
    <script>
        window.onload = function () {
            function validate(e) {
                var old_password = document.getElementById('oddpass');
                if (old_password.value.trim() == '') {
                    old_password.style.backgroundColor = '#ff4c4c';
                    old_password.classList.add('error');
                    setTimeout(function() {
                        old_password.classList.remove('error');
                    }, 200);
                    e.preventDefault();
                } else {
                    old_password.style.backgroundColor = null;
                }
                var new_password = document.getElementById('newpass');
                if (new_password.value.trim() == '') {
                    new_password.style.backgroundColor = '#ff4c4c';
                    new_password.classList.add('error');
                    setTimeout(function() {
                        new_password.classList.remove('error');
                    }, 250);
                    e.preventDefault();
                } else {
                    new_password.style.backgroundColor = null;
                }
                var confirm_password = document.getElementById('confirmpass');
                if (confirm_password.value.trim() == '') {
                    confirm_password.style.backgroundColor = '#ff4c4c';
                    confirm_password.classList.add('error');
                    setTimeout(function() {
                        confirm_password.classList.remove('error');
                    }, 250);
                    e.preventDefault();
                } else {
                    confirm_password.style.backgroundColor = null;
                }
            }
            document.getElementById('login').addEventListener('submit', validate);
        }
    </script>



@endsection
