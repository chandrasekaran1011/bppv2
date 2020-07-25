import axios from "axios";

let api = axios.create({
    headers: {
        Accept: "application/json",
        "Content-Type": "application/json"
    }
});

api.interceptors.response.use(
    response => {
        if (response.status === 200 || response.status === 201) {
            return Promise.resolve(response);
        } else {
            return Promise.reject(response);
        }
    },
    error => {
        if (error.response.status) {
            var err = 0;
            switch (error.response.status) {
                case 401:
                    err++;
                    alert("Session Expired");
                    break;
                case 419:
                    err++;
                    alert("Session Expired");
                    break;
                case 502:
                    err++;
                    break;
            }
            if (err > 0) {
                console.log("error Located");
                window.location.reload();
                return;
            } else {
                return Promise.reject(error);
            }
        }
    }
);

export default api;
