// PASEK POSTĘPU CZYTANEGO TEKSTU

var article = document.querySelector('article'), //pobieramy article
    windowHeight = window.innerHeight, //pobieramy wyskość okna
    articleHeight = article.clientHeight,
    maxScroll = article.clientHeight - window.innerHeight,
    progress = document.createElement('progress');

progress.classList.add('articleProgress');
progress.value = 0;
progress.max = maxScroll;

article.appendChild(progress);

var calculateProgress = function () {
    progress.value = window.scrollY;
    // console.log('wywolalem sie'); // czeste wywolywanie sie funkcji, trzeba ograniczyc
};
//ograniczenie

var throttle = function (callback, limit) {
    var wait = false;
    return function () {
        if (!wait) {
            callback();
            wait = true;
            setTimeout(function () {
                wait = false;
            }, limit);
        }
    }
};
// 'mocne' scrollowanie
var debounce = function (callback, time) {
    var timeout;
    return function () {
        var context = this,
            args =  arguments; //tablica z parametrami callback i time
        console.log('F1!');
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            //metoda apply służy do wywoływania zmiennych z konkretnym kontekstem
            callback.apply(context, args);
            console.log('F2!');
        }, time || 200);
    };
};

window.addEventListener('scroll', throttle(calculateProgress, 100));
window.addEventListener('scroll', debounce(calculateProgress, 200));
