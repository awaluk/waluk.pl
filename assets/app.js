import hljs from 'highlight.js/lib/core';
import php from 'highlight.js/lib/languages/php';
import xml from 'highlight.js/lib/languages/xml';
import javascript from 'highlight.js/lib/languages/javascript';
import 'highlight.js/styles/github.min.css';
import './styles/app.scss';

hljs.registerLanguage('php', php);
hljs.registerLanguage('xml', xml);
hljs.registerLanguage('javascript', javascript);
hljs.highlightAll();

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