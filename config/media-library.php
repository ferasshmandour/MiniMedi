<?php

return [
    /*
     * The disk on which to store added files and derived images by default.
     */
    'disk_name' => env('MEDIA_DISK', 'public'),

    /*
     * The maximum file size of an item in bytes.
     * Adding a larger file will result in an exception.
     */
    'max_file_size' => 1024 * 1024 * 10, // 10MB

    /*
     * This queue connection will be used for generating media conversions.
     * If null, the default queue connection will be used.
     */
    'queue_connection_name' => env('QUEUE_CONNECTION', 'database'),

    /*
     * The queue name that will be used when generating media conversions.
     */
    'queue_name' => 'media',

    /*
     * When enabled, media conversions will be performed on a queue.
     */
    'queue_conversions_by_default' => env('MEDIA_QUEUE_CONVERSIONS', true),

    /*
     * The fully qualified class name of the media model.
     */
    'media_model' => Spatie\MediaLibrary\MediaCollections\Models\Media::class,

    /*
     * The fully qualified class name of the model that should be
     * attached to the media.
     */
    'model' => Spatie\MediaLibrary\HasMedia::class,

    /*
     * When enabled, the package will append the file size to the database.
     */
    'store_file_size' => true,

    /*
     * The engine that should be used to generate conversions.
     * Currently only 'gd' and 'imagick' are available.
     */
    'image_driver' => 'gd',

    /*
     * FFMPEG & FFProbe binary paths, when using FFMPEG driver.
     */
    'ffmpeg_path' => env('FFMPEG_PATH', '/usr/bin/ffmpeg'),
    'ffprobe_path' => env('FFPROBE_PATH', '/usr/bin/ffprobe'),

    /*
     * Here you can override the default directories used for storing
     * original files and derived images.
     */
    'paths' => [
        /*
         * The directory where your original files are stored.
         * If null, the storage directory will be used.
         */
        'original_files_directory' => null,

        /*
         * The directory where your converted images are stored.
         * If null, the storage directory will be used.
         */
        'media_ conversions_directory' => null,

        /*
         * The directory where your generated PDF files are stored.
         * If null, the storage directory will be used.
         */
        'pdf_directory' => null,

        /*
         * The directory where your export files are stored.
         * If null, the storage directory will be used.
         */
        'export_directory' => null,
    ],

    /*
     * Image extensions that will be converted when uploading.
     */
    'image_extensions' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'],

    /*
     * Video extensions that will be converted when uploading.
     */
    'video_extensions' => ['mp4', 'mov', 'avi', 'mkv', 'webm'],

    /*
     * Audio extensions that will be converted when uploading.
     */
    'audio_extensions' => ['mp3', 'wav', 'ogg', 'flac', 'aac'],

    /*
     * PDF extensions that will be converted when uploading.
     */
    'pdf_extensions' => ['pdf'],

    /*
     * Default conversions that will be applied to each image upload.
     */
    'default_image_conversions' => [
        /*
         * The image conversion that will be used to display images in the
         * admin panel.
         */
        'admin_preview' => [
            'fit' => 'crop, 300, 300',
        ],

        /*
         * The image conversion that will be used to display images in
         * your application.
         */
        'preview' => [
            'fit' => 'crop, 800, 600',
        ],
    ],

    /*
     * The class names of the media collections that should be processed.
     */
    'media_collections' => [
        /*
         * Medical Reports Collection
         */
        'medical_reports' => [
            'name' => 'Medical Reports',
            'disk' => 'public',
            'media_type' => 'file',
            'collection_name' => 'medical_reports',
            'accept' => [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'image/*',
            ],
            'conversions' => ['preview'],
        ],

        /*
         * Lab Results Collection
         */
        'lab_results' => [
            'name' => 'Lab Results',
            'disk' => 'public',
            'media_type' => 'file',
            'collection_name' => 'lab_results',
            'accept' => [
                'application/pdf',
                'image/*',
            ],
            'conversions' => ['preview'],
        ],

        /*
         * Prescription Images
         */
        'prescriptions' => [
            'name' => 'Prescriptions',
            'disk' => 'public',
            'media_type' => 'image',
            'collection_name' => 'prescriptions',
            'accept' => ['image/*'],
            'conversions' => ['admin_preview', 'preview'],
        ],
    ],
];
