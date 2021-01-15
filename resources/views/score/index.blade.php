@component('score.components.'.$form, [
            'submitValue' => $submitValue,
            'score' => $score,
            'scoreValue' => $scoreValue,
            'submit' => $submit,
        ])
@endcomponent

<style>
    table {
        width: 100%;
    }

    .table-bordered {
        border-collapse: collapse;
    }

    .table-bordered, .table-bordered > thead > tr > th, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > th {
        border: 1px solid black;
    }

    .text-center {
        text-align: center;
    }

    * {
        font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }

    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
        padding: 8px;
    }

    thead, tfoot {
        background-color: rgba(54, 162, 235, 0.2);
    }
</style>