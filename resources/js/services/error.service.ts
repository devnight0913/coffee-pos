import { toast } from "react-toastify";

class ErrorService {

    handle(error: any): void {
        var errorMessage = error.response.data.message;
        console.log(error);
        console.log(error.response);
        toast.error(errorMessage);
    }
}

export default new ErrorService();