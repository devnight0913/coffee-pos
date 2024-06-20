import { SweetAlertOptions } from "sweetalert2";
export declare function getAppLanguage(): string;
export declare function t(enWord: string, arWord: string): string;
export declare function currencyInputSuffix(position: string, currencySymbol: string): string | undefined;
export declare function currencyInputPrefix(position: string, currencySymbol: string): string | undefined;
export declare function currency_format(number: any, decimals: any, dec_point: any, thousands_sep: any, position: any, currency: any, trailing_zeros?: boolean): string;
export declare function number_format(number: any, decimals: any, dec_point: any, thousands_sep: any): any;
export declare function swalConfig(): SweetAlertOptions<any, any>;
export declare function swalConfigReset(): {
    title: string;
    text: string;
    icon: string;
    showCancelButton: boolean;
    confirmButtonColor: string;
    cancelButtonColor: string;
    confirmButtonText: string;
    cancelButtonText: string;
};
export declare function floatValue(value: any): number;
