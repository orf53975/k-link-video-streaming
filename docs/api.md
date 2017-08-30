# Developer API

The developer API is inspired by the RPC-HTTP approach.

The API is exposed via the `/api` URL path.

## Versioning

_to be decided_

## Authentication

_to be clarified_


## Generic request

As the API is heavily inspired by RPC, the requests are all made with via `POST` with a JSON encoded body.

The body must have two properties

- `id` (`String`): the identifier of the request, assigned by the client when making the request
- `params` (`Object`): the action parameters

The `id` is verified to be unique.

## Actions

### `video.add`

Enable a developer to add a video file to the service.

**Parameters**

- `filename` (`string`, `required`): The name of the file being uploaded (with extension);
- `filesize` (`number`, `required`): The size, in bytes, of the video file
- `filetype` (`string`, `required`): The mime type of the video file 

> **Currently only `video/mp4` ([RFC4337](https://tools.ietf.org/html/rfc4337)) files are supported**

**Return**

A json object with the following properites is returned

- `video_id`: the unique identifier of the video
- `request_id`: the id of the request, as it was specified by the client
- `upload_token`: an upload authentication token
- `upload_location`: the URL where the TUS endpoint is listening for connections

### `video.upload`

Tus action endpoint. This endpoint only accepts requests based on the [Tus.io](https://tus.io/) protocol.

In addition to the file, the following metadata attributes must be added:

- `upload_request_id`, with the `id` of the `video.add` issued request
- `token`, with the `upload_token` after the success invocation of the `video.add` action

### `video.get`

Get the details of a video file.

**Parameters**

- `video_id` (`string`, `required`): The identifier of the video

**Return**

A json object with the following properites is returned

- `video_id`: the unique identifier of the video
- `status`: the status of the video, see [Video Status](./video-status.md) for a complete list of the possible values
- `created_at`: when the video was added to the streaming service

> The return object is not complete, expect changes before the first release

### `video.delete`

Delete a previously added video.

**Parameters**

- `video_id` (`string`, `required`): The identifier of the video

**Return**

The data about the original video are returned. 

- `video_id`: the unique identifier of the video
- `status`: the status of the video, see [Video Status](./video-status.md) for a complete list of the possible values
- `created_at`: when the video was added to the streaming service
- `deleted`: a boolean that indicate if the deletion was completed,

> The return object is not complete, expect changes before the first release
