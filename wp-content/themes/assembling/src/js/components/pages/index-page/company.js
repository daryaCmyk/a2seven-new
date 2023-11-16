function handleMarquee(){
    const marquee = document.querySelectorAll('.another-marquee');

    let mob = document.querySelector('.page-wrapper.is_mobile');
    if(mob) {
        var speed = 0.85;
    } else {
        var speed = 2;
    }
    
    marquee.forEach(function(el){
        const container = el.querySelector('.marquee-wrapper');
        const content = el.querySelector('.marquee-wrapper > .marquee');
        //Get total width
        let elWidth = 0;
        elWidth = content.offsetWidth;

        //Duplicate content
        let clone = content.cloneNode(true);
        container.appendChild(clone);
        
        let progress = 1;
        function loop(){
            if(progress <= elWidth*-1) {progress=0; } else {
                progress = progress-speed;
            }
            container.style.transform = 'translateX(' + progress + 'px)';
            container.style.transform += 'skewX(' + speed*0.4 + 'deg)';
            
            window.requestAnimationFrame(loop);
        }
        loop();
    });

    $(function () {
        $(".marquee").hover(function () {
            speed = 1;
        }, function () {
            speed = 1.5;
        });
    });
};
setTimeout(function(){
    handleMarquee();
}, 400);