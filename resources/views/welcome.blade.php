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
            line-height: 1.5em;
            font-size: 0.7em;
        }

        img {
            width: 25vw;
        }
    </style>
</head>

<body>
    <div id="app"></div>
    <script src="https://unpkg.com/vue"></script>
    <script>
        const TComment = {
            props: ['comment'],
            template: `
            <div style="opacity: 0.5; margin: 0 0 2rem 4rem;">
                <div v-html="comment.body" />
            </div>
            `
        }
        const TContent = {
            components: { TComment },
            props: ['content'],
            template: `
            <div>
                <br>
                <h2>@{{ content.title }}/ @{{ content.id }}</h2>
                <div v-html="content.body" />
                <br />
                <TComment v-for="comment in content.comments" :comment="comment" />
                <br />
            </div>
            `
        }

        new Vue({
            el: '#app',
            components: {
                TContent, TComment
            },
            data: {
                contents: [],
                q: ''
            },
            methods: {
                submit() {
                    fetch(`./api/search?q=${this.q}`)
                        .then(r => r.json())
                        .then(r => {
                            this.contents = r
                            this.q = ''
                        })
                }
            },
            template: `
            <div>
                <input v-model="q" v-on:keyup.enter="submit" />
                <TContent v-for="content in contents" :content="content" />
            </div>
            `
        })
    </script>
</body>

</html>