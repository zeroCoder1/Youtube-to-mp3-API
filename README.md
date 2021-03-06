# Youtube-to-mp3-API

With these two php files you are able to create your own Youtube to MP3 API with ability to search also.
See the wiki for examples.

# Possible HTTP requests

## `GET - convert.php`

| Parameter		| Required	| Type | Description |
|-----------|----------|-------------|-------------|
| youtubelink	| Yes	| string |  The full youtubelink of the video you want to download. |
| delete | No | string | The youtubeid of which you want it to be deleted from storage on the server |

### __Possible youtubelinks__
```
youtube.com/v/{vidid}
youtube.com/vi/{vidid}
youtube.com/?v={vidid}
youtube.com/?vi={vidid}
youtube.com/watch?v={vidid}
youtube.com/watch?vi={vidid}
youtu.be/{vidid}
```

## `GET - search.php`

| Parameter		| Required	| Type | Description |
|-----------|----------|-------------|-------------|
| q	| Yes	| string | The query term to search for video's |
| max_results | No | integer | The max results of search results u want to get |

# Possible HTTP responses

## `JSON - convert.php`

| Parameter		|Type | Description |
|-----------|-------------|-------------|
| error	| boolean	| Whether or not an error occured |
| message	| string	| A simple message or the error message |


| Parameter		|Type | Description |
|-----------|-------------|-------------|
| error	| boolean	| false |
| youtube_id | string | The youtube identifier |
| title	| string	| The title of the video that got converted |
| alt_title | string | A secondary title of the video |
| duration	| integer	| The duration of the video that got converted (in seconds) |
| file	| string	| The streamlink or downloadable mp3 file |
| uploaded_at | object | A Date object |

## `JSON - search.php`

| Parameter		|Type | Description |
|-----------|-------------|-------------|
| error	| boolean	| Whether or not an error occured |
| message	| string	| An error message |
| results	| array	| An array with MAX_RESULTS entries. Each entry has: the video id, the channel name of the video, the video title and the full url to the video |

# Software requirements

* [youtube-dl](https://rg3.github.io/youtube-dl/)
* [ffmpeg](https://www.ffmpeg.org/) (+ [libmp3lame](http://lame.sourceforge.net/))

# General installation

First we install the dependencies on the server, then website.

## VPS

* Install ffmpeg (+ libmp3lame - see wiki for tutorial)
* [install youtube-dl](http://ytdl-org.github.io/youtube-dl/download.html)

## Website

* Get a google developer api key
* Go to your webserver files to run composer into
* Run `composer create-project michaelbelgium/youtube-to-mp3 [directoryname]` - where `directoryname` is .. a directory where people can access the API from.

## Configuration

### `search.php`
```PHP
define("MAX_RESULTS", 10);
define("API_KEY", "");
```

### `convert.php`

```PHP
define("DOWNLOAD_FOLDER", dirname(__FILE__)."/download/"); //the folder where files are accessable to download
define("DOWNLOAD_FOLDER_PUBLIC", "http://michaelbelgium.me/ytconverter/download/");
define("DOWNLOAD_MAX_LENGTH", 0); //max video duration (in seconds) to be able to download, set to 0 to disable
```