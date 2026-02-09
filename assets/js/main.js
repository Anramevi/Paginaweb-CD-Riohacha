console.log('Main JS loaded');

document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});

function toggleFullScreen() {
    var elem = document.getElementById("mainCarousel");
    if (!document.fullscreenElement) {
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.webkitRequestFullscreen) { /* Safari */
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) { /* IE11 */
            elem.msRequestFullscreen();
        }
        elem.classList.add("vh-100");
        elem.querySelector(".carousel-inner").classList.add("h-100");
        elem.querySelectorAll(".carousel-item > div").forEach(div => div.style.height = "100vh");
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) { /* Safari */
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) { /* IE11 */
            document.msExitFullscreen();
        }
        elem.classList.remove("vh-100");
        elem.querySelector(".carousel-inner").classList.remove("h-100");
        elem.querySelectorAll(".carousel-item > div").forEach(div => div.style.height = "400px");
    }
}

// Listener for fullscreen change to reset styles if user exits via ESC
document.addEventListener('fullscreenchange', (event) => {
    var elem = document.getElementById("mainCarousel");
    if (!document.fullscreenElement) {
        elem.classList.remove("vh-100");
        elem.querySelector(".carousel-inner").classList.remove("h-100");
        elem.querySelectorAll(".carousel-item > div").forEach(div => div.style.height = "400px");
    }
});
