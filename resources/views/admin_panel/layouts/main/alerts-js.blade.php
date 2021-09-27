@if (!empty(session('success')))
    <script>
        window.onload = function () {
            $.jGrowl('{{ session()->get('success') }}', {
                theme: 'alert-styled-left alert-arrow-left alert-primary',
            });
        }
    </script>
@endif
@if (!empty(session('alert')))
    <script>
        window.onload = function () {
            $.jGrowl('{{ session()->get('alert') }}', {
                theme: 'alert-bordered alert-styled-left alert-danger'
            });
        };
    </script>
@endif