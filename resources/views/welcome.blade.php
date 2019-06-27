<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Cousine&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 2rem;
            font-family: Cousine, sans-serif;
            color: #555;
            white-space: pre-wrap;
            line-height: 1.5em;
            font-size: 0.7em;
        }

        img {
            width: 24vw;
        }
    </style>
</head>

<body>
    <div id="app"></div>
    <script src="https://unpkg.com/vue"></script>
    <script>
        const TContent = {
            props: ['content'],
            template: `
            <div>
                <br>
                <h2>@{{ content.title }}/ @{{ content.id }}</h2>
                <div v-html="content.body" />
                <br />
            </div>
            `
        }
        new Vue({
            el: '#app',
            components: {
                TContent
            },
            data: {
                results: [],
                q: ''
            },
            methods: {
                submit() {
                    fetch(`./api/search?q=${this.q}`)
                        .then(r => r.json())
                        .then(r => {
                            this.results = r
                            this.q = ''
                        })
                }
            },
            template: `
            <div>
                <input v-model="q" v-on:keyup.enter="submit" />
                <TContent v-for="result in results" :content="result" />
            </div>
            `
        })
    </script>
</body>

</html>