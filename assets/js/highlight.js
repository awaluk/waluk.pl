import hljs from 'highlight.js/lib/core';
import php from 'highlight.js/lib/languages/php';
import xml from 'highlight.js/lib/languages/xml';
import javascript from 'highlight.js/lib/languages/javascript';
import 'highlight.js/styles/github.min.css';

hljs.registerLanguage('php', php);
hljs.registerLanguage('xml', xml);
hljs.registerLanguage('javascript', javascript);
hljs.highlightAll();