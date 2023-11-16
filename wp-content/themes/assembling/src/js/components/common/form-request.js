import {makeRequest} from './filter-service'
function focusInput() {
	Array.prototype.slice.call(document.querySelectorAll('.contact-field')).forEach(function (elem) {
		elem.onclick = function (event) {
			let target = event.currentTarget
			target.querySelector('.contact-field__input').focus()
		}

		Array.prototype.slice.call(elem.querySelectorAll('.contact-field__input')).forEach(function (element) {
			checkField(element)

			element.addEventListener('focus', function () {
				element.parentNode.classList.add('active')
			})
			element.addEventListener('focusout', function () {
				checkField(element)
			})
		})
	})

	var textarea = document.getElementsByTagName('textarea');

	for (var i = 0; i < textarea.length; i++) {
		textarea[i].setAttribute('style', 'height:' + (textarea[i].scrollHeight) + 'px;overflow-y:hidden;');

		textarea[i].addEventListener("input", OnInput, false);
	}  

	function OnInput() {
		this.style.height = 'auto';
		this.style.height = (this.scrollHeight) + 'px';
	}
}

function addFiles() {
	let fileAdd = document.querySelectorAll('#file-uploader');
	fileAdd.forEach(function(val) {
		val.addEventListener("change", function(evt) {
			if(this.value) {
				this.parentElement.classList.remove('error');
				let files = this.files;
				let name, size;

				for (const file of files) {
				    name = file.name;
                    size = file.size;
				} 

				let spanLast = this.parentElement.querySelector('.file-title');
				let btnDelete = this.parentElement.parentElement.querySelector('.file-delete');

				if(btnDelete.classList.contains('hidden')) {
					btnDelete.classList.remove('hidden')
				}

				var input = this;

				if(btnDelete) {
					btnDelete.addEventListener("click", function(evt) {
						spanLast.textContent = spanLast.dataset.title;
						input.value = '';
						btnDelete.classList.add('hidden');
					})
				}

				spanLast.textContent = name;

                let sizeMax = 1024 * 1024 * 25;

				if(size > sizeMax) {
					evt.preventDefault();
					this.value = '';
					this.parentElement.classList.add('error');	
				}
			}
		})
	})
}
addFiles();

function checkField(element) {
	if (element.value == '') {
		element.parentNode.classList.remove('active')
	} else {
		element.parentNode.classList.add('active')
	}
}

focusInput()

function phoneMask() {
	$('input[type="tel"]').on("input", (function (e) {
		e.target.value = e.target.value.replace(/[^+\d]/g, "")
	}));
}
phoneMask();

function inputText() {
	$('input[type="text"]').on("input", (function (e) {
		e.target.value = e.target.value.replace(/[^a-zA-Zа-яА-ЯёЁ ]/g, "");
	}));
}
inputText();

$('input').on("change", (function (e) {
	if(e.target.name === 'email') {
		validateEmail(e.target)
	} else {
		if(e.target.classList.contains("valid-error") ) {
			e.target.classList.remove("valid-error");
		} 
	}
}));

function validateEmail(email) {
	var emailValue = email.value;

	function validateEmailCheck(mail) {
		var re = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
		return re.test(String(mail).toLowerCase());
	}

	if (validateEmailCheck(emailValue)) {
		email.classList.remove('valid-error');
		email.classList.remove('valid-error--type');
		return true;
	} else {
		email.classList.add('valid-error');
		if(emailValue.value !== '' && emailValue) {
			email.classList.add('valid-error--type');
		} else {
			email.classList.remove('valid-error--type');
		}
		return false;
	}

}

function checkValid(names, email) {
	if (names) {
		if(names.value.length == 0){
			names.classList.add('valid-error');
		}
		else{
			names.classList.remove('valid-error');
		}
	}
	
	if (email) {
		if(!validateEmail(email)){
			email.classList.add('valid-error');
		}
		else{
			email.classList.remove('valid-error');
		}
	}	
}

function indexForm() {
	const form = document.querySelectorAll('.contact-form');

	if (!form) return;

	if (form) {
		for (var i = 0; i < form.length; i++) {
			const button = form[i].querySelector('.contact-form__button');
			const formsTarget = form[i];
			let names = formsTarget.querySelector('.contact-field__input[name="name"]');
			let email = formsTarget.querySelector('.contact-field__input[name="email"]');
			let phone = formsTarget.querySelector('.contact-field__input[name="phone"]');
			let message = formsTarget.querySelector('.contact-field__input[name="message"]');
			let file = formsTarget.querySelector('.contact-field__file');

			button.addEventListener('click', async event => {
				event.preventDefault();
				let url = '/feadback/ajax.php';
				let data = new FormData(formsTarget);
				let resp;
				let result = false;

				formsTarget.classList.add('loading');
				button.classList.add('disabled');

				if (validateEmail(email) && names.value.length !== 0 && !file.classList.contains('error')) {
					if (phone.value.trim() === '') {
						phone.value = '-';
						data.set('phone', phone.value);
					}

					if (message.value.trim() === '') {
						message.value = '-';
						data.set('message', message.value);
					}

					result = true;

					if (formsTarget.classList.contains('crm')) {
						resp = await makeRequest('POST', '/feadback/feedback.php', data, false);
						console.log(resp);
					} else {
						data.append('link', window.location.href);
						data.append('lang', document.querySelector('html').dataset.langOrder);
						if (document.querySelector('.text-page') && document.querySelector('.text-page').classList.contains('subvacancy-page')) {
							data.append('vacancy', document.querySelector('.page-title').textContent);
						}
						resp = await makeRequest('POST', url, data, false);
					}
				} else {
					formsTarget.classList.remove('loading');
					checkValid(names, email);
				}

				button.classList.remove('disabled');

				if (result === true) {
					let title = formsTarget.parentElement.querySelector('.section-title');
					title.textContent = window.formTitle;
					formsTarget.classList.add('send-ok');
					formsTarget.parentElement.parentElement.classList.add('send');
					formsTarget.innerHTML = `
                       <div class="send-ok__title-wrap">
                           <svg xmlns="http://www.w3.org/2000/svg" class="send-ok__svg" viewBox="-105 197 400 400">
                               <g>
                                   <title>Shape</title>
                                   <path id="Path-0" class="st0" d="M95 570.8c-95.8 0-173.8-78-173.8-173.8 0-95.8 77.9-173.8 173.8-173.8s173.8 78 173.8 173.8c0 95.8-78 173.8-173.8 173.8zM95 197c-110.3 0-200 89.7-200 200s89.7 200 200 200 200-89.7 200-200-89.7-200-200-200z"></path>
                                   <g>
                                       <title>Shape</title>
                                       <path id="Path-1" class="st0" d="M167.4 331.5L64.3 434.6 22.6 393c-5.1-5.1-13.4-5.1-18.5 0s-5.1 13.4 0 18.5l51 51c2.6 2.6 5.9 3.8 9.3 3.8s6.7-1.3 9.3-3.8L186 350.1c5.1-5.1 5.1-13.4 0-18.5-5.2-5.2-13.5-5.2-18.6-.1z"></path>
                                   </g>
                               </g>
                           </svg>
                           <p class="send-ok__title">${window.formTitle2}</p>
                       </div>
                       <p class="send-ok__text">${window.formText}</p>`;

					formsTarget.classList.remove('loading');
				} else {
					formsTarget.classList.remove('loading');
				}
			});
		}
	}
}

indexForm();

indexForm()