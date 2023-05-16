# **Start up dev env**

1. Start queue

```console
    sail artisan queue:listen
```

2. Start stripe local webhook

```console
    stripe listen --forward-to https://localhost/stripe/webhook
```
