//Закрытие/открытие модальных окон
let btnModal = document.querySelectorAll('.open-video');
let modal = document.querySelector('#video-modal');
let body = document.querySelector('body');
let closeBtn = modal.querySelector(".close-modal");
let fullBtn = modal.querySelector(".full-modal");

if(btnModal) {
    btnModal.forEach(element => {
        element.addEventListener("click", function(evt) {
        evt.preventDefault();
        modal.classList.add('modal-open');
        body.classList.add('opened');
        })
    });
}

if(fullBtn) {
    fullBtn.addEventListener("click", function() {
        fullBtn.classList.toggle('full-open');
        if(modal.classList.contains('modal-full')) {
            modal.classList.remove('modal-full');
        } else {
            modal.classList.add('modal-full');
        }
    })
}

function closeModal() {
	modal.classList.remove('modal-open');
    // modal.classList.remove('modal-full');
    body.classList.remove('opened');	

    var player = modal.querySelector(".modal-video").contentWindow;
    if(player) {
        player.postMessage('{"event": "command", "func": "stopVideo", "args": ""}', "*");
        player.seekTo(0);
    }
}

closeBtn.addEventListener("click", function() {
    closeModal();
})

$(document).keydown(function(e) {        
  if (e.keyCode == 27) {
	  closeModal();
  }
});

$('.custom-modal').click(function(e) {
	if ($(e.target).is('.custom-modal')) {
		closeModal();
	}
})