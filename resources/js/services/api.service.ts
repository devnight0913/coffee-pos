
const API_URL = "/api";
const API_VERSION = "v1";

class ApiService {

    apiUrl(uri: string): string {
        //return `${API_URL}/${API_VERSION}/${uri}`;
        return `${uri}`;
    }

}

export default new ApiService();