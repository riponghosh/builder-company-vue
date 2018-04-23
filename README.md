# creativer-web

> A Vue.js project

## Build Setup

``` bash
# install dependencies
npm install

# serve with hot reload at localhost:8080
npm run dev

# build for production with minification
npm run build

# build for production and view the bundle analyzer report
npm run build --report
```

For a detailed explanation on how things work, check out the [guide](http://vuejs-templates.github.io/webpack/) and [docs for vue-loader](http://vuejs.github.io/vue-loader).


##  Nginx

```
server {
        listen 80;
        server_name staging.sharecreators.com;

        root /var/www/sharecreators/staging;
        index index.html;

        location /api {
                proxy_pass http://127.0.0.1:8001;
        }
}
```
