const classOpen = 'nav__list--open';
const header = document.querySelector('#header');
const button = document.querySelector('#nav-button');
const list = document.querySelector('#nav-list');

button.addEventListener('click', () => {
    list.classList.toggle(classOpen);
});
window.addEventListener('click', event => {
    if (list.classList.contains(classOpen) && !header.contains(event.target)) {
        list.classList.remove(classOpen);
    }
});