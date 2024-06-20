import { AxiosResponse } from "axios";
declare class HttpService {
    /**
    * GET Request.
    *
    * @param {string} path request path.
    * @return {Promise<void | AxiosResponse<any>>} axios response or void.
    */
    get(path: string): Promise<void | AxiosResponse<any>>;
    /**
    * PUT Request.
    *
    * @param {string} path request path.
    * @param {any} data request data.
    * @return {Promise<void | AxiosResponse<any>>} axios response or void.
    */
    put(path: string, data?: any): Promise<void | AxiosResponse<any>>;
    /**
    * POST Request.
    *
    * @param {string} path request path.
    * @param {any} data request data.
    * @return {Promise<void | AxiosResponse<any>>} axios response or void.
    */
    post(path: string, data?: any): Promise<void | AxiosResponse<any>>;
    /**
    * DELETE Request.
    *
    * @param {string} path request path.
    * @return {Promise<void | AxiosResponse<any>>} axios response or void.
    */
    delete(path: string): Promise<void | AxiosResponse<any>>;
    headers(): {
        headers: {};
    };
}
declare const _default: HttpService;
export default _default;
