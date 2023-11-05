//auto update prediction
document.addEventListener("DOMContentLoaded", function () {
    function updatePrediction() {
        var predictionDiv = document.getElementById("prediction");
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "/site/prediction/", true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                predictionDiv.innerHTML = xhr.responseText;
            }
        };

        xhr.send();
    }

    setInterval(updatePrediction, 3000);
});
