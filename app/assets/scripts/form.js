document.addEventListener('DOMContentLoaded', function(){
    var httpRequest;
    const submitButton = document.getElementById("main-from");
    submitButton.addEventListener("submit", makeRequest);

    function makeRequest(e) {
        e.preventDefault();

        const data = new FormData(e.target);
        const value = Object.fromEntries(data.entries());

        httpRequest = new XMLHttpRequest();
        if (!httpRequest) {
            alert("Что-то пошло не так. Свяжитесь с администратором.");
            return false;
        }
        httpRequest.onreadystatechange = processResponse;
        httpRequest.open("POST", "/formHandle");
        httpRequest.setRequestHeader("Content-type", "application/json")
        httpRequest.send(JSON.stringify(value));
    }
    
    function processResponse() {
        var response;
        if (httpRequest.readyState === XMLHttpRequest.DONE) {
            if (httpRequest.status === 200) {
                response = JSON.parse(httpRequest.responseText);
                console.log(response);
                if(response.error){
                    document.getElementById("result-info").innerHTML = "Ошибка: " + response.error
                }else{
                    document.getElementById("result-info").innerHTML = "Сделка успешно создана!"
                }
            } else {
                document.getElementById("result-info").innerHTML = "Что-то пошло не так. Попробуйте снова."
                console.log(response)
            }
        }
    }
})
