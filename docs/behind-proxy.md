# Running behind a proxy

Deployment might sit behind a load balancer, HTTP cache, or other intermediary (reverse) proxy, therefore the application generated URLs might be incorrect.

To let the application trust the proxy you can specify its IP address (or IP Address range) using the environment variable `TRUSTED_PROXY_IP`.

The `TRUSTED_PROXY_IP` accepts a single string with the IP address or the [CIDR](https://github.com/fideloper/TrustedProxy#do-you-even-cidr-brah) address range.

**Default value**

By default the trusted proxy configuration authorizes proxies in the IP range `192.0.2.1/32`.


## When deploying from source

When deploying from source the `TRUSTED_PROXY_IP` should be specified in the `.env` file placed in the root of the project.

```conf
# other configurations omitted
TRUSTED_PROXY_IP=192.168.0.25
```

## When deploying with the Docker image

When deploying using the Docker image, the `TRUSTED_PROXY_IP` must be passed as environment variable to the container.

```bash
docker run -e "TRUSTED_PROXY_IP=192.168.0.25" ...
# see https://docs.docker.com/engine/reference/run/#env-environment-variables
```

If Docker Compose is used, specify the variable in the `environment` section for the service.

```yaml
environment:
    TRUSTED_PROXY_IP: "192.168.0.25"
    # other environment variable omitted
```

## Sub-folders deployment with a Proxy

Sometimes you might want to expose the application on a specific path instead of registering a sub-domain, like http://pretty.domain/video.

In case you're doing this kind of deployment configure the (Reverse) Proxy to **not strip** `/video` and make sure the `APP_URL` environment variable for the service contains the full URL with the `/video/` path. In this way the application knows it has to serve the application at that path, even if is not existing.

> In sub-folder deployment style we recommend Docker based deployments
