$('.sidebar_inner ul li a').on('click', function(e){
    if($(this).closest("li").children("ul").length) {
        if ( $(this).closest("li").is(".active-submenu") ) {
           $('.sidebar_inner ul li').removeClass('active-submenu');
        } else {
            $('.sidebar_inner ul li').removeClass('active-submenu');
            $(this).parent('li').addClass('active-submenu');
        }
        e.preventDefault();
    }
});

$(window).on("resize", function () {
    $(".keywords-list").trigger("resizeContainer");
});

$(window).on("load", function () {
    $(".keywords-list").trigger("resizeContainer");
});

$(document).on("resizeContainer", ".keywords-list", function () {
    var heightnow = $(this).height();
    var heightfull = $(this)
        .css({ "max-height": "auto", height: "auto" })
        .height();

    $(this).css({ height: heightnow }).animate({ height: heightfull }, 200);
});


$(document).ready(function () {
    const container = document.querySelector(".users-menu");
    const simplebar = new SimpleBar(container);

    function updateSimpleBar() {
        simplebar.recalculate();
    }

    updateSimpleBar();

    $(document).on("click", ".users-menu a", function (event) {
        updateSimpleBar();
    });

    $(".keywords-container").each(function () {
        var keywordInput = $(this).find(".keyword-input");
        var keywordsList = $(this).find(".keywords-list");

        function addKeyword() {
            var $newKeyword = $(
                "<span class='keyword'><span class='keyword-remove'></span><span class='keyword-text'>" +
                    keywordInput.val() +
                    "</span></span>"
            );
            keywordsList.append($newKeyword).trigger("resizeContainer");
            keywordInput.val("");
        }

        keywordInput.bind("keyup", function (e) {
            if (e.keyCode == 13 && keywordInput.val() !== "") {
                addKeyword();
            }
        });

        $(".keyword-input-button").on("click", function () {
            if (keywordInput.val() !== "") {
                addKeyword();
            }
        });

        $(document).on("click", ".keyword-remove", function () {
            $(this).parent().addClass("keyword-removed");

            function removeFromMarkup() {
                $(".keyword-removed").remove();
            }
            setTimeout(removeFromMarkup, 500);
            keywordsList.css({ height: "auto" }).height();
        });

        keywordsList.on("resizeContainer", function () {
            var heightnow = $(this).height();
            var heightfull = $(this)
                .css({ "max-height": "auto", height: "auto" })
                .height();

            $(this)
                .css({ height: heightnow })
                .animate({ height: heightfull }, 200);
        });

        $(window).on("resize", function () {
            keywordsList.css({ height: "auto" }).height();
        });

        $(window).on("load", function () {
            var keywordCount = $(".keywords-list").children("span").length;
            if (keywordCount > 0) {
                keywordsList.css({ height: "auto" }).height();
            }
        });
    });
});

window.checkEditorConfig = {
    placeholder: 'ادخل النص هنا',
    container: '.ckeditor-container',
    language: {
        // The UI will be English.
        ui: 'ar',

        // But the content will be edited in Arabic.
        content: 'ar'
    },

    // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
    toolbar: {
        items: [
            'exportPDF', 'exportWord', '|',
            'findAndReplace', 'selectAll', '|',
            'heading', '|',
            'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript',
            'removeFormat', '|',
            'bulletedList', 'numberedList', 'todoList', '|',
            'outdent', 'indent', '|',
            'undo', 'redo',
            '-',
            'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
            'alignment', '|',
            'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed',
            '|',
            'specialCharacters', 'horizontalLine', 'pageBreak', '|',
            'textPartLanguage', '|',
            'sourceEditing'
        ],
        shouldNotGroupWhenFull: true
    },
    // Changing the language of the interface requires loading the language file using the <script> tag.
    // language: 'es',
    list: {
        properties: {
            styles: true,
            startIndex: true,
            reversed: true
        }
    },
    // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
    heading: {
        options: [{
                model: 'paragraph',
                title: 'Paragraph',
                class: 'ck-heading_paragraph'
            },
            {
                model: 'heading1',
                view: 'h1',
                title: 'Heading 1',
                class: 'ck-heading_heading1'
            },
            {
                model: 'heading2',
                view: 'h2',
                title: 'Heading 2',
                class: 'ck-heading_heading2'
            },
            {
                model: 'heading3',
                view: 'h3',
                title: 'Heading 3',
                class: 'ck-heading_heading3'
            },
            {
                model: 'heading4',
                view: 'h4',
                title: 'Heading 4',
                class: 'ck-heading_heading4'
            },
            {
                model: 'heading5',
                view: 'h5',
                title: 'Heading 5',
                class: 'ck-heading_heading5'
            },
            {
                model: 'heading6',
                view: 'h6',
                title: 'Heading 6',
                class: 'ck-heading_heading6'
            }
        ]
    },
    fontFamily: {
        options: [
            'default',
            'Arial, Helvetica, sans-serif',
            'Courier New, Courier, monospace',
            'Georgia, serif',
            'Lucida Sans Unicode, Lucida Grande, sans-serif',
            'Tahoma, Geneva, sans-serif',
            'Times New Roman, Times, serif',
            'Trebuchet MS, Helvetica, sans-serif',
            'Verdana, Geneva, sans-serif'
        ],
        supportAllValues: true
    },
    fontSize: {
        options: [10, 12, 14, 'default', 18, 20, 22],
        supportAllValues: true
    },
    // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
    // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
    htmlSupport: {
        allow: [{
            name: /.*/,
            attributes: true,
            classes: true,
            styles: true
        }]
    },
    // Be careful with enabling previews
    // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
    htmlEmbed: {
        showPreviews: true
    },
    // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
    link: {
        decorators: {
            addTargetToExternalLinks: true,
            defaultProtocol: 'https://',
            toggleDownloadable: {
                mode: 'manual',
                label: 'Downloadable',
                attributes: {
                    download: 'file'
                }
            }
        }
    },
    // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
    mention: {
        feeds: [{
            marker: '@',
            feed: [
                '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes',
                '@chocolate', '@cookie', '@cotton', '@cream',
                '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread',
                '@gummi', '@ice', '@jelly-o',
                '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding',
                '@sesame', '@snaps', '@soufflé',
                '@sugar', '@sweet', '@topping', '@wafer'
            ],
            minimumCharacters: 1
        }]
    },
    // The "super-build" contains more premium features that require additional configuration, disable them below.
    // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
    removePlugins: [
        // These two are commercial, but you can try them out without registering to a trial.
        // 'ExportPdf',
        // 'ExportWord',
        'CKBox',
        'CKFinder',
        'EasyImage',
        // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
        // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
        // Storing images as Base64 is usually a very bad idea.
        // Replace it on production website with other solutions:
        // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
        // 'Base64UploadAdapter',
        'RealTimeCollaborativeComments',
        'RealTimeCollaborativeTrackChanges',
        'RealTimeCollaborativeRevisionHistory',
        'PresenceList',
        'Comments',
        'TrackChanges',
        'TrackChangesData',
        'RevisionHistory',
        'Pagination',
        'WProofreader',
        // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
        // from a local file system (file://) - load this site via HTTP server if you enable MathType
        'MathType'
    ]
}