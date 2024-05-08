import './bootstrap';

document.addEventListener("DOMContentLoaded", function () {
    Echo.channel(`gitlab`).listen("IssueUpdatedEvent", (e) => {});
});
