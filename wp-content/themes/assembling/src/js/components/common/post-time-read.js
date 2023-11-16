const wordsPerMinute = 200;
let result;

var decCache = [],
decCases = [2, 0, 1, 1, 1, 2];

function numstr(n) { 
    text_forms = ['минута', 'минуты', 'минут'];
    var m = Math.abs(n) % 100; 
    var n1 = m % 10;
    if (m > 10 && m < 20) { return text_forms[2]; }
    if (n1 > 1 && n1 < 5) { return text_forms[1]; }
    if (n1 == 1) { return text_forms[0]; }
    return text_forms[2];
}

let content = document.querySelector('.content');
if(content) {
    let textLength = content.textContent.split(" ").length;
    if(textLength > 0){
        let value = Math.ceil(textLength / wordsPerMinute);
        let mark;
        if(document.querySelector('.page-ru')) {
            mark = numstr(value)
        } else {
            if(value === 1) {
                mark = 'minute';
            } else {
                mark = 'minutes';
            }
        }
        result = `${value} ${mark}`;
    }

    let time = document.querySelector(".post-time .time");
    if(time) {
        time.innerText = result;
    }
}
