<style>
    .date-input {
        position: relative;
        width: 150px;
        height: 38px;
        color: white;
    }

    .date-input:before {
        position: absolute;
        content: attr(data-date);
        display: inline-block;
        color: black;
    }

    .date-input::-webkit-datetime-edit, .date-input::-webkit-inner-spin-button, .date-input::-webkit-clear-button {
        display: none;
    }

    .date-input::-webkit-calendar-picker-indicator {
        position: absolute;
        right: 10px;
        color: black;
        opacity: 1;
    }
</style>