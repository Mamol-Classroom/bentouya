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



