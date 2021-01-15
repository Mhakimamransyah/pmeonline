@component('preview.component.'.$name)
@endcomponent

<style>
    h1, h2, h3, h4, h5, h6 {
        text-align: center;
        margin-bottom: 0;
    }

    .periode-label {
        margin-top: 6px;
        text-align: center;
    }

    table {
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
        margin-top: 18px;
    }

    td, th {
        border: 1px solid black;
        text-align: center;
    }

    .no-border {
        border-width: 0 !important;
        white-space: nowrap;
    }

    .no-border td, .no-border th {
        border: 0;
        text-align: left;
    }

    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
        padding: 8px;
    }
</style>