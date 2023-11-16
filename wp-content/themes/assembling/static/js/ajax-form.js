function indexForm() {

    var form = document.querySelectorAll('.contact-form');
    if (!form) return;

    if (form) {
        var _loop = function _loop() {
            var button = form[i].querySelector('.contact-form__button');
            var formsTarget = form[i];
            button.addEventListener('click', function(event) {
                console.log('djskhkshdkjshkdhkjs');
                event.preventDefault();
                var url = '/feadback/feadback.php';
                var data = new FormData(formsTarget);
                var result = false;
                formsTarget.classList.add('loading');
                button.classList.add('disabled');
                var div = document.createElement("div");
                div.classList.add('form-status');
                div.classList.add('form-status--smaller');
                div.classList.add('form-status--transparent');
                div.innerHTML = "<div class=\"preloader\">\n                        <div class=\"preloaderitem preloaderitem-1\"></div>\n                        <div class=\"preloaderitem preloaderitem-2\"></div>\n                        <div class=\"preloaderitem preloaderitem-3\"></div>\n                        <div class=\"preloaderitem preloaderitem-4\"></div>\n                        <div class=\"preloaderitem preloaderitem-5\"></div>\n                        <div class=\"preloaderitem preloaderitem-6\"></div>\n                        <div class=\"preloaderitem preloaderitem-7\"></div>\n                        <div class=\"preloaderitem preloaderitem-8\"></div>\n                    </div>";
                button.appendChild(div);
                var names = formsTarget.querySelector('.contact-field__input[name="name"]');
                var namesValue = names.value.trim();
                var email = formsTarget.querySelector('.contact-field__input[name="email"]');
                var file = formsTarget.querySelector('.contact-field__file');
                var message = formsTarget.querySelector('.contact-field__input[name="message"]');
                var messageValue = message.value.trim();


                if (namesValue.length !== 0 && validateEmail(email) && !file.classList.contains('error')) {
                    result = true;

                    if (formsTarget.classList.contains('crm')) {
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', '/feadback/feedback.php', true);
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                // Дальнейшая обработка ответа
                            }
                        };
                        xhr.send(data);
                    } else {
                        data.append('link', window.location.href);
                        data.append('lang', document.querySelector('html').dataset.langOrder);

                        if (document.querySelector('.text-page') && document.querySelector('.text-page').classList.contains('subvacancy-page')) {
                            data.append('vacancy', document.querySelector('.page-title').textContent);
                        }

                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', url, true);
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                // Дальнейшая обработка ответа
                            }
                        };
                        xhr.send(data);
                    }
                } else {
                    formsTarget.classList.remove('loading');
                    checkValid(names, email);
                    console.log('checkValid')
                }
                console.log('ERROR')
                button.classList.remove('disabled');
                div.remove();
            });
        };

        for (var i = 0; i < form.length; i++) {
            _loop();
        }
    }
}