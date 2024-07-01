const cookieInfo = document.querySelector('#cookie-info');
const cookieInfoAccept = document.querySelector('#cookie-info-accept');

if (document.cookie.indexOf('cookies-confirmed=1') < 0) {
    cookieInfo.classList.add('cookie-info--show');
}
console.log(document.cookie);
cookieInfoAccept.addEventListener('click', function () {
    cookieInfo.remove();
    const date = new Date();
    date.setTime(date.getTime() + (365*24*60*60*1000));
    document.cookie = 'cookies-confirmed=1;path=/;expires=' + date.toUTCString();
});