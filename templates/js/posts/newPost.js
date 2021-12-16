$(window).load(function() {
    var categoryIndexes = {
        'Экономика': 1,
        'Спорт': 2,
        'Культура': 3,
        'Наука и техника': 4,
        'Интернет и СМИ': 5,
        'Из жизни': 6,
        'Дом': 7,
        'Путешествия': 8,
        'Бизнес': 9,
        'Ценности': 10
    }

    var quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Enter text...',
    });

    $("#addPost").on("submit", function(e) {
        $("input#text").val(quill.root.innerHTML)
        $("input#textOnly").val(quill.getText())
    })


    $('.ql-container').on('keypress paste', (_.debounce(function() {
        var regex = /[!"#$%&'()*+,-./:;<=>?@[\]^_`{|}~]/g;
        var text = quill.getText().toLowerCase().replace(regex, '');
        console.log(text);
        $.ajax({
            url: 'https://nlpservice.herokuapp.com/category/?q=' + text,
            type: 'GET',
            success: function(res) {
                if (res && res['category']) {
                    $('#categoryId').val(categoryIndexes[res['category']]);
                }
            },
            error: function() {
                console.log("Something went wrong");
            }
        });
    }, 2000)));
});