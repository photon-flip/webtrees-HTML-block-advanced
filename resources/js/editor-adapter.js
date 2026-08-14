/*
 * Keep the template picker independent from a particular webtrees editor.
 * webtrees 2.2 uses CKEditor 4. Future editors can listen for the custom event.
 */
window.HtmlAdvancedEditor = {
    setContent(form, content) {
        const textarea = form.querySelector('textarea[name="html"]');

        if (!textarea) {
            return;
        }

        textarea.value = content;

        const ckeditor = window.CKEDITOR?.instances?.[textarea.id];
        if (ckeditor) {
            ckeditor.setData(content);
            return;
        }

        textarea.dispatchEvent(new CustomEvent('html-advanced:set-content', {
            bubbles: true,
            detail: {content},
        }));
        textarea.dispatchEvent(new Event('input', {bubbles: true}));
        textarea.dispatchEvent(new Event('change', {bubbles: true}));
    },
};
