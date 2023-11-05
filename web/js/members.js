//auto update members
document.addEventListener("DOMContentLoaded", function () {
    function updateMembers() {
        var membersDiv = document.getElementById("members-list");
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "/site/members/", true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                membersDiv.innerHTML = xhr.responseText;
            }
        };

        xhr.send();
    }

    setInterval(updateMembers, 5000);
});
