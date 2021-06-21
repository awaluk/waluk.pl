import hljs from 'highlight.js/lib/core';
import php from 'highlight.js/lib/languages/php';
import xml from 'highlight.js/lib/languages/xml';
import javascript from 'highlight.js/lib/languages/javascript';
import 'highlight.js/styles/darcula.css';

import 'normalize.css/normalize.css';
import './styles/app.scss';

hljs.registerLanguage('php', php);
hljs.registerLanguage('xml', xml);
hljs.registerLanguage('javascript', javascript);
hljs.highlightAll();

const classOpen = 'header__navigation--open';
const header = document.querySelector('#header');
const toggle = document.querySelector('#header-nav-toggle');
const nav = document.querySelector('#header-nav');

toggle.addEventListener('click', () => {
    nav.classList.toggle(classOpen);
});
window.addEventListener('click', event => {
    if (nav.classList.contains(classOpen) && !header.contains(event.target)) {
        nav.classList.remove(classOpen);
    }
});
