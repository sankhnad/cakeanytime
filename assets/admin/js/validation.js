//function work for form validation 
function validateForm(targetFlag) {
    var isValidForm = true;
    $('#' + targetFlag).attr('novalidate', 'novalidate');
    $('#' + targetFlag + ' [required]').each(function() {
        if ($(this).is("select") && $(this).val() == '') {
            $(this).closest('div').addClass('errorDropdown');
            isValidForm = false;
        } else if ($(this).is(":file") && $(this).val() == '') {
            $(this).addClass('errorFileType');
            isValidForm = false;
        } else if ($(this).is("textarea") && $(this).val() == '') {
            $(this).addClass('errorTextArea');
            isValidForm = false;
        } else if ($(this).is(":checkbox") && $(this).is(":not(:checked)")) {
            $(this).closest('label').addClass('errorCheckBox');
            isValidForm = false;
        } else if ($(this).is("input:radio")) {
            var radioBtnName = $(this).attr('name');
            if ($("input[name=" + radioBtnName + "]:checked").length <= 0) {
                $(this).closest('div').parent('div').addClass('errorRadio');
                isValidForm = false;
            } else if ($(this).is(":not(:checked)") && !radioBtnName) {
                $(this).closest('div').parent('div').addClass('errorRadio');
                isValidForm = false;
            }
        } else if ($(this).val() == '') {
            $(this).addClass('errorInput');
            isValidForm = false;
        }
    });
    return isValidForm;
}

$(document).on('keypress', '.numericOnly, .phoneOnly, .percengateOnly, .timeOnly, .alphanumericOnly, .invoicenumberOnly, .numbersonlynegativeOnly, .integersOnly', function(event) {
    if ($(this).hasClass('numericOnly')) {
        return numericOnly(this, event);
    } else if ($(this).hasClass('phoneOnly')) {
        return phoneOnly(this, event);
    } else if ($(this).hasClass('percengateOnly')) {
        return percengateOnly(this, event);
    } else if ($(this).hasClass('timeOnly')) {
        return timeOnly(this, event);
    } else if ($(this).hasClass('alphanumericOnly')) {
        return alphanumericOnly(this, event);
    } else if ($(this).hasClass('invoicenumberOnly')) {
        return invoicenumberOnly(this, event);
    } else if ($(this).hasClass('numbersonlynegativeOnly')) {
        return numbersonlynegativeOnly(this, event);
    } else if ($(this).hasClass('integersOnly')) {
        return integersOnly(this, event);
    }
});

function numericOnly(t, e) {
    return validateInput(t, e, new RegExp("^[0-9]([.:][0-9])?$"));
}
function phoneOnly(t, e) {
    return validateInput(t, e, new RegExp(/^[+-]?\d+$/));
}

function percengateOnly(t, e) {
    var i = new RegExp("^[0-9]{0,2}(\\.[0-9])?$|^1?0{0,2}(\\.0)?$");
    return validateInput(t, e, i)
}

function timeOnly(t, e) {
    return validateInput(t, e, new RegExp("^[0-9]*([.:][0-9]{0,2})?$"))
}

function alphanumericOnly(t, e) {
    return validateInput(t, e, new RegExp("^[0-9a-zA-Z]*$"))
}

function invoicenumberOnly(t, e) {
    return validateInput(t, e, new RegExp("^[A-Za-z0-9 #,./:_-]*$"))
}

function numbersonlynegativeOnly(t, e) {
    return validateInput(t, e, new RegExp("^-?[0-9]([.][0-9])?$"))
}

function integersOnly(t, e) {
    return validateInput(t, e, new RegExp("^[0-9]*$"))
}

function validateInput(t, e, i) {
    var n = t.value;
    $(t).unbind("paste.validateInput"), $(t).bind("paste.validateInput", function() {
        setTimeout(function() {
            i.test(t.value) ? n = t.value : $(t).val(n)
        }, 10)
    });
    var r = jQuery.event.fix(e || window.event);
    if (!isPrintableKey(r)) return !0;
    var a = getFinalValue(t, r);
	return i.test(a);
}

function isPrintableKey(t) {
    if (t.ctrlKey || t.metaKey) return !1;
    var e = t.which;
    return 32 > e || 144 == e ? !1 : !0
}

function getFinalValue(t, e) {
    var i = TextSelection.startPos(t),
        n = TextSelection.endPos(t),

        r = t.value,
        a = String.fromCharCode(e.which),
        s = r.substring(0, i),
        o = r.substring(n, r.length);
    return s + a + o
}

var TextSelection = {
    current: function() {
        return document.getSelection ? document.getSelection().toString() : document.selection ? document.selection.createRange().text : void 0
    },
    selectedValue: function(t) {
        return void 0 !== t.selectionStart ? t.value.substring(t.selectionStart, t.selectionEnd) : document.selection ? document.selection.createRange().text : void 0
    },
    startPos: function(t) {
        if (void 0 !== t.selectionStart) return t.selectionStart;
        if (document.selection) {
            var e = document.selection.createRange();
            return e.moveEnd("character", t.value.length), t.value.length - e.text.length
        }
    },
    endPos: function(t) {
        if (void 0 !== t.selectionEnd) return t.selectionEnd;
        if (document.selection) {
            var e = document.selection.createRange();
            return e.moveStart("character", -t.value.length), e.text.length
        }
    }
};

$(".numberOnly").keydown(function (e) {
	if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
		(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
		(e.keyCode >= 35 && e.keyCode <= 40)) {
		return;
	}
	if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
		e.preventDefault();
	}
});

function validateEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}