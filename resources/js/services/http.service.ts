import axios, { AxiosResponse } from "axios";
import ApiService from "./api.service";
// import authService from "./auth.service";
import ErrorService from "./error.service";


class HttpService {

    /**
    * GET Request.
    *
    * @param {string} path request path.
    * @return {Promise<void | AxiosResponse<any>>} axios response or void.
    */
    get(path: string): Promise<void | AxiosResponse<any>> {
        console.log(path);
        console.log(ApiService.apiUrl(path));
        return axios.get(ApiService.apiUrl(path), this.headers())
            .catch((error: any) => ErrorService.handle(error))
            .finally(() => { });
    }

    /**
    * PUT Request.
    *
    * @param {string} path request path.
    * @param {any} data request data.
    * @return {Promise<void | AxiosResponse<any>>} axios response or void.
    */
    put(path: string, data?: any): Promise<void | AxiosResponse<any>> {
        
        return axios.put(ApiService.apiUrl(path), data, this.headers())
            .catch((error: any) => ErrorService.handle(error))
            .finally(() => { });
    }

    /**
    * POST Request.
    *
    * @param {string} path request path.
    * @param {any} data request data.
    * @return {Promise<void | AxiosResponse<any>>} axios response or void.
    */
    post(path: string, data?: any): Promise<void | AxiosResponse<any>> {

        return axios.post(ApiService.apiUrl(path), data, this.headers())
            .catch((error: any) => ErrorService.handle(error))
            .finally(() => { });
    }

    /**
    * DELETE Request.
    *
    * @param {string} path request path.
    * @return {Promise<void | AxiosResponse<any>>} axios response or void.
    */
    delete(path: string): Promise<void | AxiosResponse<any>> {

        return axios.delete(ApiService.apiUrl(path), this.headers())
            .catch((error: any) => ErrorService.handle(error))
            .finally(() => { });
    }

    headers() {
        return {
            // headers: { 'Authorization': `Bearer ${authService.getAccessToken()}` }
            headers: {  }
        };
    }

}

export default new HttpService();