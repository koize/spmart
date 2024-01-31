function accountSignOut() {
    document.cookie = "id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    window.location.href = "login.php";
}
function editAccDone() {
    window.location.href = "account.php";
}