# **Start up dev env**

1. Start queue

```console
    sail artisan queue:listen
    sail artisan queue:listen --queue=web-push-queue --sleep=0
```

2. Start stripe local webhook

```console
    stripe listen --forward-to https://localhost/stripe/webhook
```
