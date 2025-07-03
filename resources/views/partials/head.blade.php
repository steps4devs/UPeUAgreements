<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js"></script>
<script src="//unpkg.com/alpinejs" defer></script>
<!-- FilePond CSS -->
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<!-- FilePond JS -->
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<!-- FilePond Plugin for File Type Validation (opcional) -->
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/scrollreveal"></script>


@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance

<style>
@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.2; }
}
.blink-dot {
    animation: blink 1s infinite;
}
</style>