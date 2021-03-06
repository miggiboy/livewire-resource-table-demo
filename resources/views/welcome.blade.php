<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
        <title>Livewire Resource Table Demo</title>
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
    </head>
    <body>
        <div class="flex w-full items-center justify-center min-h-screen mb-2 px-64" style="background-color: #eff1f4">
            @livewire ('resource-table', [
                'resource' => 'users',
                'columns' => [
                    'id' => 'id',
                    'name' => 'name',
                    'email' => 'email',
                ]
            ])
        </div>

        @livewireAssets
    </body>
</html>
