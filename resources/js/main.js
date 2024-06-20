topbar.config({
    barThickness: 6,
    barColors: {
        0: 'rgba(100, 115, 244)',
        '.25': 'rgba(100, 115, 244)',
        '.50': 'rgba(100, 115, 244)',
        '.75': 'rgba(100, 115, 244)',
        '1.0': 'rgba(100, 115, 244)'
    }
});
topbar.show();
document.addEventListener('DOMContentLoaded', function () {
    topbar.hide();

    var formSelectList = [].slice.call(document.querySelectorAll('.form-select'));
    formSelectList.map(function (formSelectElement) {
        formSelectElement.addEventListener('change', function (event) {
            this.classList.remove('is-invalid');
        });
    });

    var forms = document.getElementsByTagName('form');
    for (const form of forms) {
        form.addEventListener('submit', function (event) {
            var formBtn = this.querySelector('button[type="submit"]');
            formBtn.disabled = true;
            topbar.show();
        });
    }
    var formControlList = [].slice.call(document.querySelectorAll('.form-control'));
    formControlList.map(function (formControlElement) {
        formControlElement.addEventListener('input', function (event) {
            this.classList.remove('is-invalid');
        });
    });

    var formControlOnFocusList = [].slice.call(document.querySelectorAll('.focus-select-text'));
    formControlOnFocusList.map(function (formControlOnFocusElement) {
        formControlOnFocusElement.addEventListener('focus', () => {
            formControlOnFocusElement.select();
        });
    });

    function previewImage(input, image) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (event) {
                image.classList.remove('d-none');
                image.src = event.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.onkeydown = function (event) {
        event = event || window.event;
        if (event.key === 'Enter') {
            var modalList = [].slice.call(document.querySelectorAll('.modal'));
            modalList.map(function (modalElement) {
                var modalInstance = Bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) {
                    modalInstance.hide();
                }
            });
        }
    };

    var menuToggle = document.querySelector('#menu-toggle');
    if (menuToggle) {
        menuToggle.addEventListener('click', function (event) {
            event.preventDefault();
            console.log('clicked');
            document.querySelector('#wrapper').classList.toggle('toggled');
        });
    }

    function getAppLanguage() {
        var langTag = document.querySelector('meta[name="lang-value"]');
        console.log(langTag.content);
        if (langTag) return langTag.content;
        return 'en';
    }

    function swalConfig() {
        var lang = getAppLanguage();
        return {
            title: lang == 'ar' ? 'هل أنت متأكد؟' : 'Are you sure?',
            text: lang == 'ar' ? 'لا يمكنك التراجع عن هذا الإجراء!' : 'You cannot undo this action!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#6473f4',
            cancelButtonColor: '#d93025',
            confirmButtonText: lang == 'ar' ? 'حذف' : 'Delete',
            cancelButtonText: lang == 'ar' ? 'إلغاء' : 'Cancel',
            hideClass: {
                popup: '' // disable popup fade-out animation
            }
        };
    }

    // var pDatatableWrappers = [].slice.call(document.querySelectorAll('.table-responsive'));
    // pDatatableWrappers.map(function (pDatatableWrapper) {
    //     pDatatableWrapper.addEventListener('show.bs.dropdown', event => {
    //         pDatatableWrapper.style.overflowX = 'inherit';
    //     });
    //     pDatatableWrapper.addEventListener('hide.bs.dropdown', event => {
    //         pDatatableWrapper.style.overflowX = 'auto';
    //     });
    // });

    var keys = '0123456789.';
    var checkInputNumber = function (e) {
        var key = typeof e.which == 'number' ? e.which : e.keyCode;
        var start = this.selectionStart,
            end = this.selectionEnd;
        var filtered = this.value.split('').filter(filterInput);
        this.value = filtered.join('');
        var move = filterInput(String.fromCharCode(key)) || key == 0 || key == 8 ? 0 : 1;
        this.setSelectionRange(start - move, end - move);
    };
    var filterInput = function (val) {
        return keys.indexOf(val) > -1;
    };

    var numberInputList = [].slice.call(document.querySelectorAll('.input-number'));
    numberInputList.map(function (numberInputElement) {
        numberInputElement.addEventListener('input', checkInputNumber);
    });

    var stockKeys = '0123456789.-';
    var checkInputStock = function (e) {
        var key = typeof e.which == 'number' ? e.which : e.keyCode;
        var start = this.selectionStart,
            end = this.selectionEnd;
        var filtered = this.value.split('').filter(filterInputStock);
        this.value = filtered.join('');
        var move = filterInputStock(String.fromCharCode(key)) || key == 0 || key == 8 ? 0 : 1;
        this.setSelectionRange(start - move, end - move);
    };
    var filterInputStock = function (val) {
        return stockKeys.indexOf(val) > -1;
    };

    var stockInputList = [].slice.call(document.querySelectorAll('.input-stock'));
    stockInputList.map(function (numberInputElement) {
        numberInputElement.addEventListener('input', checkInputStock);
    });

    window.previewImage = previewImage;
    window.swalConfig = swalConfig;
});
