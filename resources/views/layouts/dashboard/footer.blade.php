<footer class="main-footer">
    <div class="container">
        <div class="pull-right hidden-xs">
            <b>Versi</b> {{ env('APP_VERSION', '0.1') }}
        </div>
        <strong>Copyright &copy; {{ env('APP_YEAR', '2018') }}
            <a href="{{ env('APP_COPYRIGHT_HOMEPAGE', '#') }}">{{ env('APP_COPYRIGHT_HOLDER', 'Copyright Holder') }}</a>.
        </strong>
        Hak cipta dilindungi undang-undang.
    </div>
</footer>