function learndash_video_iframe_shortcode($atts) {
    if (empty($atts['link'])) {
        return '<div style="background:#f8d7da;color:#721c24;padding:10px;border-radius:8px;margin:10px 0;">
                    <strong>Error:</strong> No video link provided.
                </div>';
    }

    $iframe_url = esc_url($atts['link']);

    // ✅ Check if URL is valid
    if (!filter_var($iframe_url, FILTER_VALIDATE_URL)) {
        return '<div style="background:#f8d7da;color:#721c24;padding:10px;border-radius:8px;margin:10px 0;">
                    <strong>Error:</strong> Invalid video URL.
                </div>';
    }

    // Extract path safely
    $path = parse_url($iframe_url, PHP_URL_PATH);
    if (!$path) {
        return '<div style="background:#f8d7da;color:#721c24;padding:10px;border-radius:8px;margin:10px 0;">
                    <strong>Error:</strong> Could not parse video path from URL.
                </div>';
    }

    $parts = explode('/', trim($path, '/'));
    $library_id = $parts[1] ?? '';
    $video_id   = $parts[2] ?? '';

    if (!$library_id || !$video_id) {
        return '<div style="background:#f8d7da;color:#721c24;padding:10px;border-radius:8px;margin:10px 0;">
                    <strong>Error:</strong> Could not extract video information. Please check the link.
                </div>';
    }

    // Manual mapping: library ID -> pull zone
    $pull_zone_map = [
        "421926" => "vz-53bb27df-91f.b-cdn.net",
        "421921" => "vz-f7366c9b-368.b-cdn.net",
        "421919" => "vz-fb8b47ba-283.b-cdn.net",
        "421928" => "vz-31b63c13-755.b-cdn.net",
        "421924" => "vz-532a2b00-63f.b-cdn.net",
        "421931" => "vz-03bddc1d-1fa.b-cdn.net",
        "421929" => "vz-4d34d471-4ba.b-cdn.net",
        "421930" => "vz-ad5b41e7-062.b-cdn.net",
        "421922" => "vz-8389c98b-add.b-cdn.net",
        "421927" => "vz-b9f461c4-815.b-cdn.net",
        "421925" => "vz-2b28255b-900.b-cdn.net",
        "421923" => "vz-9945b192-7cd.b-cdn.net",
        "486083" => "vz-19d163ae-ab1.b-cdn.net"
    ];

    $pull_zone = $pull_zone_map[$library_id] ?? null;

    ob_start();

    if ($pull_zone) {
        // Construct HLS playlist URL
        $hls_url = "https://{$pull_zone}/{$video_id}/playlist.m3u8";
        ?>
        <div style="position: relative; width: 100%; padding-top: 56.25%; background:#000;">
            <video id="ld-video-<?php echo esc_attr($video_id); ?>"
                   controls autoplay playsinline
                   style="position:absolute; top:0; left:0; width:100%; height:100%; object-fit:cover; background:#000;">
            </video>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
        <script>
          (function() {
            var video = document.getElementById("ld-video-<?php echo esc_js($video_id); ?>");
            var videoSrc = "<?php echo esc_url($hls_url); ?>";

            if (Hls.isSupported()) {
              var hls = new Hls();
              hls.loadSource(videoSrc);
              hls.attachMedia(video);
            } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
              video.src = videoSrc;
            }
          })();
        </script>
        <?php
    } else {
        // Fallback: use original iframe if pull zone not found
        ?>
        <div style="position: relative; width: 100%; padding-top: 56.25%;">
            <iframe src="<?php echo esc_url($iframe_url); ?>" 
                   style="display: block; width: 100%; height: 100%; border: none; border-radius:8px; background:#000;" 
                   allow="accelerometer; gyroscope; autoplay; encrypted-media; picture-in-picture" 
                   allowfullscreen
                   loading="lazy"></iframe>
        </div>
        <?php
    }

    return ob_get_clean();
}
add_shortcode("ld_video", "learndash_video_iframe_shortcode");
