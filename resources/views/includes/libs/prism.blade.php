@push('styles')
@style('//cdnjs.cloudflare.com/ajax/libs/prism/1.16.0/themes/prism.min.css')
@style('//cdnjs.cloudflare.com/ajax/libs/prism/1.16.0/plugins/toolbar/prism-toolbar.min.css')
@endpush


@push('scripts')

@script('//cdnjs.cloudflare.com/ajax/libs/prism/1.16.0/components/prism-core.min.js')
@script('//cdnjs.cloudflare.com/ajax/libs/prism/1.16.0/plugins/toolbar/prism-toolbar.min.js')
@script('//cdnjs.cloudflare.com/ajax/libs/prism/1.16.0/plugins/autoloader/prism-autoloader.min.js')
<script>
    Prism.plugins.autoloader.languages_path = '//cdnjs.cloudflare.com/ajax/libs/prism/1.16.0/components/';
    (function(){
        if (typeof self === 'undefined' || !self.Prism || !self.document) {
            return;
        }

        if (!Prism.plugins.toolbar) {
            console.warn('Copy to Clipboard plugin loaded before Toolbar plugin.');

            return;
        }

        var ClipboardJS = window.ClipboardJS || undefined;

        if (!ClipboardJS && typeof require === 'function') {
            ClipboardJS = require('clipboard');
        }

        var callbacks = [];

        if (!ClipboardJS) {
            var script = document.createElement('script');
            var head = document.querySelector('head');

            script.onload = function() {
                ClipboardJS = window.ClipboardJS;

                if (ClipboardJS) {
                    while (callbacks.length) {
                        callbacks.pop()();
                    }
                }
            };

            script.src = '//cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js';
            head.appendChild(script);
        }

        Prism.plugins.toolbar.registerButton('copy-to-clipboard', function (env) {
            var linkCopy = document.createElement('button');
            linkCopy.innerHTML = '<i class="fa fa-copy"></i> Copy';

            if (!ClipboardJS) {
                callbacks.push(registerClipboard);
            } else {
                registerClipboard();
            }

            return linkCopy;

            function registerClipboard() {
                var clip = new ClipboardJS(linkCopy, {
                    'text': function () {
                        return env.code;
                    }
                });

                clip.on('success', function() {
                    linkCopy.innerHTML = '<i class="fa fa-copy"></i> Copied!';

                    resetText();
                });
                clip.on('error', function () {
                    linkCopy.innerHTML = '<i class="fa fa-copy"></i> Press Ctrl+C to copy';

                    resetText();
                });
            }

            function resetText() {
                setTimeout(function () {
                    linkCopy.innerHTML = '<i class="fa fa-copy"></i> Copy';
                }, 5000);
            }
        });
    })();
</script>
@endpush