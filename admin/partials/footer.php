            </div>
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/trumbowyg.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/plugins/colors/trumbowyg.colors.min.js"></script>
    <script>
        // Initialize the editor on textareas with the 'editor' class
        $('.editor').trumbowyg({
            btnsDef: {
                // Create a new dropdown
                image: {
                    dropdown: ['insertImage', 'upload'],
                    ico: 'insertImage'
                }
            },
            btns: [
                ['viewHTML'],
                ['undo', 'redo'],
                ['formatting'],
                'btnGrp-semantic', // Bold, Italic, Underline
                ['link'],
                ['image'], // Our new dropdown
                'btnGrp-lists', // Unordered & Ordered lists
                ['foreColor', 'backColor'],
                ['horizontalRule'],
                ['fullscreen']
            ],
            plugins: {
                // We don't need a separate upload plugin for the core library
            }
        });
    </script>
</body>
</html>

