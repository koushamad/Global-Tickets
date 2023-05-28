<!DOCTYPE html>
<html lang="en">
<head>
    <title>Global Ticket Swagger UI</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('swagger-ui-dist/swagger-ui.css') }}">
</head>
<body>
<div id="swagger-ui"></div>
<script src="{{ asset('swagger-ui-dist/swagger-ui-bundle.js') }}"></script>
<script>
    const ui = SwaggerUIBundle({
        url: "{{ asset('swagger.json') }}",
        dom_id: '#swagger-ui',
        presets: [
            SwaggerUIBundle.presets.apis,
            SwaggerUIBundle.SwaggerUIStandalonePreset
        ],
        layout: "BaseLayout"
    });
</script>
</body>
</html>
