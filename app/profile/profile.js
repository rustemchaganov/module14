const userPromoBtn = document.querySelector('#user-promo');
const userBirthBtn = document.querySelector('#user-birthday');
const userHistoryBtn = document.querySelector('#user-history');
const showContentPromo = document.querySelector('.content-user.promo');
const showContentBirth = document.querySelector('.content-user.birthday');
const showContentHistory = document.querySelector('.content-user.history');

userPromoBtn.addEventListener('click', () => {
    showContentPromo.classList.add("active");
    showContentBirth.classList.remove("active");
    showContentHistory.classList.remove("active");
});

userBirthBtn.addEventListener('click', () => {
    showContentPromo.classList.remove("active");
    showContentBirth.classList.add("active");
    showContentHistory.classList.remove("active");
});

userHistoryBtn.addEventListener('click', () => {
    showContentPromo.classList.remove("active");
    showContentBirth.classList.remove("active");
    showContentHistory.classList.add("active");
});

document.addEventListener('DOMContentLoaded', function () {
    const countdownElement = document.querySelector('#countdown');
    const expiryTime = parseInt(countdownElement.getAttribute('data-expiry-time')) * 1000;

    function startCountdown() {
        const interval = setInterval(() => {
            const now = new Date().getTime();
            const distance = expiryTime - now;

            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            countdownElement.innerHTML = hours + "h " + minutes + "m " + seconds + "s ";

            if (distance < 0) {
                clearInterval(interval);
                countdownElement.innerHTML = "EXPIRED";
            }
        }, 1000);
    }

    startCountdown();
});

document.addEventListener('DOMContentLoaded', function() {
    flatpickr(".date-input", {
        dateFormat: "Y-m-d",
    });
});
