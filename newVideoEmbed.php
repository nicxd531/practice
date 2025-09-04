function learndash_video_iframe_shortcode($atts) {
    if (empty($atts['link'])) {
        return '<strong>Error:</strong> No video link provided.';
    }

    $iframe_url = esc_url($atts['link']);

    // Extract library ID and video ID from iframe URL
    $parts = explode('/', trim(parse_url($iframe_url, PHP_URL_PATH), '/'));
    $library_id = $parts[1] ?? '';
    $video_id   = $parts[2] ?? '';

    if (!$library_id || !$video_id) {
        return '<strong>Error:</strong> Could not parse video info.';
    }

    // Manual mapping: library ID -> pull zone
    $pull_zone_map = [
      "421926" => "vz-53bb27df-91f.b-cdn.net",  // Library 421926 biology
    "421921" => "vz-f7366c9b-368.b-cdn.net",  // Library 421921 english folder
    "421919" => "vz-fb8b47ba-283.b-cdn.net" , // Library 421919 maths folder 
	"421928" => "vz-31b63c13-755.b-cdn.net" ,  // Library 421928 account folder
	"421924" => "vz-532a2b00-63f.b-cdn.net" ,  // Library 421924 chemistry folder 
	"421931" => "vz-03bddc1d-1fa.b-cdn.net",   // Library 421931 crs folder 
	"421929" => "vz-4d34d471-4ba.b-cdn.net" , // Library 421929 commerce folder 
	"421930" => "vz-ad5b41e7-062.b-cdn.net" ,  // Library 421930 Economics folder 
	"421922" => "vz-8389c98b-add.b-cdn.net",   // Library 421922 Futher mathematics folder
	"421927" => "vz-b9f461c4-815.b-cdn.net",   // Library 421927 Government folder
	"421925" => "vz-2b28255b-900.b-cdn.net",   // Library 421925 Literature folder
		"421923" => "vz-9945b192-7cd.b-cdn.net",   // Library 421923
	"486083" => "vz-19d163ae-ab1.b-cdn.net"   // Library 486083 Qefas training folder 
		
		
        // Add more libraries here if needed
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
        <div style="position: relative; width: 100%; padding-top: 16.25%;">
            <iframe src="<?php echo esc_url($iframe_url); ?>" 
                   style=" display: block; width: 100vw; height: 46.25vw; /* 16:9 ratio */ max-width: 100%; max-height: 100%; border: none; margin: 0; padding: 0; " 
                    allow="accelerometer; gyroscope; autoplay; encrypted-media; picture-in-picture" 
                    allowfullscreen
                    loading="lazy"></iframe>
        </div>
        <?php
    }

    return ob_get_clean();
}
add_shortcode("ld_video", "learndash_video_iframe_shortcode");

