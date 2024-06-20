// export function fileSize(size: number): string {
//     const i = Math.floor(Math.log(size) / Math.log(1024));
//     return (
//         (size / Math.pow(1024, i)).toFixed(2) * 1 +
//         ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i]
//     );
// }

import { SweetAlertOptions } from "sweetalert2";


export function getAppLanguage(): string {
    var langTag: any = document.querySelector('meta[name="lang-value"]');
    if (langTag) return langTag.content;
    return 'en';
}

export function t(enWord: string, arWord: string): string {
    var appLang: any = getAppLanguage();
    if (appLang == 'ar') return arWord;
    return enWord;
}
export function currencyInputSuffix(position: string, currencySymbol: string): string | undefined {
    if (position == 'before') return undefined;
    return ` ${currencySymbol}`;
}
export function currencyInputPrefix(position: string, currencySymbol: string): string | undefined {
    if (position == 'before') return `${currencySymbol} `;
    return undefined;
}
export function currency_format(number: any, decimals: any, dec_point: any, thousands_sep: any, position: any, currency: any, trailing_zeros: boolean = false) {
    var value = number_format(number, decimals, dec_point, thousands_sep);
    if (!trailing_zeros) {
        if (position == 'before') {
            return `${currency} ${value.replace(`${dec_point}00`, "")}`;
        }
        return `${value.replace(`${dec_point}00`, "")} ${currency}`;
    }

    if (position == 'before') {
        return `${currency} ${value}`;
    }
    return `${value} ${currency}`;
}

export function number_format(number: any, decimals: any, dec_point: any, thousands_sep: any) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s: any = '',
        toFixedFix = function (n: any, prec: any) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');

    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}



export function swalConfig(): SweetAlertOptions<any, any> {
    return {
        title: "Are you sure?",
        text: "You cannot undo this action!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#6473f4",
        cancelButtonColor: "#d93025",
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
    };
}
export function swalConfigReset() {
    return {
        title: "Are you sure?",
        text: "You cannot undo this action!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#6473f4",
        cancelButtonColor: "#d93025",
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
    };
}


export function floatValue(value: any): number {
    if (value == undefined || value == null) return 0;
    return Number(parseFloat(value));
}